<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\TopCategory;
use App\Models\SubCategory;

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
        'id',
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
            Text::make('Product code')->maxlength(127),
            Text::make('Barcode')->maxlength(127),
            BelongsTo::make('Main category', 'mainCategory'),

            BelongsTo::make('Top category')->exceptOnForms(),
            Select::make('Top category', 'top_category_id')
                ->dependsOn(
                    'mainCategory',
                    function (Select $field, NovaRequest $request, FormData $formData) {
                        if ($formData->mainCategory) {
                            $topCategories = TopCategory::all()->where('main_category_id', $formData->mainCategory)
                                ->mapWithKeys(function ($element) {
                                    return [$element['id'] => $element['name']];
                                });
                            $field->options($topCategories)->show();
                        }
                    }
                )
                ->resolveUsing(function () {
                    return $this->top_category_id ?? null;
                })
                ->nullable(true)
                ->onlyOnForms(),
            BelongsTo::make('Sub category')->exceptOnForms(),
            Select::make('Sub category', 'sub_category_id')
                ->dependsOn(
                    'topCategory',
                    function (Select $field, NovaRequest $request, FormData $formData) {
                        if ($formData->topCategory) {
                            $subCategories = SubCategory::all()->where('top_category_id', $formData->topCategory)
                                ->mapWithKeys(function ($element2) {
                                    return [$element2['id'] => $element2['name']];
                                });
                            $field->options($subCategories)->show();
                        }
                    }
                )
                ->resolveUsing(function () {
                    return $this->sub_category_id ?? null;
                })
                ->nullable(true)
                ->onlyOnForms(),
            Boolean::make('Active'),
            BelongsTo::make('Product brand', 'productBrand')->searchable(),
            Text::make('Name')->maxlength(255),
            Text::make('Description')->maxlength(255),
            Currency::make('List price')->locale('us'),
            Currency::make('Price')->locale('us'),
            Number::make('tax')->min(0)->max(1)->step(0.01),
            Text::make('Currency')->maxlength(7),
            Number::make('Quantity')->min(0)->step(1),
            Boolean::make('In discount'),
            Trix::make('Detail'),

            HasMany::make('images')->inline(),
            HasMany::make('variants')->inline()
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
}
