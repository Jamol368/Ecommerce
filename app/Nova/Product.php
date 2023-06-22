<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Product>
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Vendor')
                ->searchable(),

            BelongsTo::make('Category')
                ->searchable(),

            BelongsTo::make('Product brand')
                ->searchable(),

            Text::make('Model')
                ->rules('required', 'max:31'),

            Text::make('Name')
                ->rules('required', 'max:255'),

            Slug::make('Slug')
                ->hideFromIndex()
                ->rules('required', 'max:255')
                ->from('name'),

            Text::make('Product code')
                ->hideFromIndex()
                ->rules('required', 'max:255'),

            Text::make('Description')
                ->hideFromIndex()
                ->rules('required', 'max:255'),

            Trix::make('Detail')
                ->hideFromIndex()
                ->rules('required')
                ->hideFromIndex(),

            Number::make('tax')
                ->hideFromIndex()
                ->required()
                ->default(0)
                ->min(0)
                ->max(1)
                ->step(0.01),

            BelongsTo::make('Currency')
                ->hideFromIndex(),

            Number::make('Discount')
                ->hideFromIndex()
                ->default(0)
                ->step(1),

            BelongsTo::make('Product status')
                ->searchable(),

            BelongsToMany::make('Tags')
                ->hideFromIndex()
                ->searchable()
                ->showCreateRelationButton()
                ->modalSize('7xl'),

            HasMany::make('Images')
                ->hideFromIndex(),

            HasMany::make('Product Instance', 'productInstances')
                ->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->hasRole('vendor')) {
            $query = parent::indexQuery($request, $query);
            return $query->whereIn('vendor_id',  $request->user()->vendors()->get('id'));
        }
        return $query;
    }
}
