<?php

namespace App\Nova;

use App\Nova\Filters\CreditCardUser;
use Dniccum\PhoneNumber\PhoneNumber;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\BelongsTo;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

class CreditCard extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\CreditCard>
     */
    public static $model = \App\Models\CreditCard::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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
            BelongsTo::make('User'),
            Text::make('Name')
                ->hideFromIndex(),
            Number::make('Card number')
                ->rules('required', function ($attribute, $value, $fail) {
                    if (strlen($value) < 16) {
                        return $fail('The ' . $attribute . ' field must be valid credit card number.');
                    }
                })
                ->maxlength(16),
            Number::make('Expiration month')
                ->min(1)
                ->max(12)
                ->rules('required')
                ->hideFromIndex(),
            Number::make('Expiration year')
                ->min(date('y'))
                ->rules([
                    'required',
                    'digits:2'
                ])
                ->hideFromIndex(),
            PhoneNumber::make('Phone')
                ->useMaskPlaceholder('+998-(##)-###-##-##')
                ->format('+998-(##)-###-##-##')
                ->disableValidation()
                ->linkOnDetail()
                ->rules(['required', function ($attribute, $value, $fail) {
                    if (strlen($value) < 19) {
                        return $fail('The ' . $attribute . ' field must be valid phone number.');
                    }
                }]),
            Boolean::make('Main')->default(false),
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
        return [
            new CreditCardUser
        ];
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
