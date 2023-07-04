<?php

namespace App\Nova;

use Dniccum\PhoneNumber\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;
use Gabelbart\Laravel\Nova\Fields\Geolocation\Geolocation;


class Vendor extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Vendor>
     */
    public static $model = \App\Models\Vendor::class;

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
        'name',
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
            BelongsTo::make('user'),
            Text::make('name'),
            Slug::make('slug')->from('name')->hideFromIndex(),
            Image::make('image')
                ->hideFromIndex(),
            Text::make('description')->hideFromIndex(),
            Text::make('manager'),
            BelongsTo::make('state'),
            BelongsTo::make('city'),
            Text::make('address')->hideFromIndex(),
            Hidden::make('latitude'),
            Hidden::make('longitude'),
            Geolocation::make('Map position')
                ->defaultLatitude(41.55137020827421)
                ->defaultLongitude(60.63146147389899)
                ->defaultZoom(17)
                ->hideFromIndex(),

            PhoneNumber::make('Phone')
                ->hideFromIndex()
                ->country('UZ')
                ->useMaskPlaceholder()
                ->format('+998-(##)-###-##-##')
                ->linkOnDetail()
                ->disableValidation()
                ->rules('required')
                ->creationRules('unique:vendors,phone')
                ->updateRules('unique:vendors,phone,{{resourceId}}'),
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
            return $query->where('user_id', $request->user()->id);
        }
        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        if ($request->user()->hasRole('vendor')) {
            $query = parent::indexQuery($request, $query);
            return $query->where('user_id', $request->user()->id);
        }
        return $query;
    }

    public static function softDeletes()
    {
        return Auth::user()->hasRole('admin');
    }
}
