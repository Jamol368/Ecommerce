<?php

namespace App\Providers;

use App\Nova\Category;
use App\Nova\CategoryStatus;
use App\Nova\City;
use App\Nova\Currency;
use App\Nova\Option;
use App\Nova\OptionValue;
use App\Nova\Product;
use App\Nova\ProductBrand;
use App\Nova\ProductInstance;
use App\Nova\ProductOption;
use App\Nova\ProductStatus;
use App\Nova\Role;
use App\Nova\State;
use App\Nova\Tag;
use App\Nova\User;
use App\Nova\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Dashboards\Main;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Menu\MenuGroup;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::booted(function () {
            app()->setlocale('uz');
        });

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),

                MenuSection::make('Users', [
                    MenuItem::resource(User::class),
                ])->icon('users')->collapsable(),

                MenuSection::make('Auth', [
                    MenuItem::resource(Role::class),
                ])->icon('key')->collapsable(),

                MenuSection::make('Store', [
                    MenuGroup::make('Product', [
                        MenuItem::resource(ProductStatus::class),
                        MenuItem::resource(Product::class),
                        MenuItem::resource(ProductInstance::class),
                    ]),

                    MenuGroup::make('Product options', [
                        MenuItem::resource(Option::class),
                        MenuItem::resource(OptionValue::class),
                        MenuItem::resource(ProductOption::class),
                    ]),

                    MenuGroup::make('Product parameters', [
                        MenuItem::resource(ProductBrand::class),
                        MenuItem::resource(Currency::class),
                        MenuItem::resource(Tag::class),
                        MenuItem::resource(CategoryStatus::class),
                        MenuItem::resource(Category::class),
                    ]),
                ])->icon('view-boards')->collapsable()->collapsedByDefault(),

                MenuSection::make('Vendors', [
                    MenuItem::resource(Vendor::class),
                ])->icon('library')->collapsable()->collapsedByDefault(),

                MenuSection::make('Addresses', [
                    MenuItem::resource(State::class),
                    MenuItem::resource(City::class),
                ])->icon('globe')->collapsable()->collapsedByDefault(),
            ];
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes(): void
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate(): void
    {
        Gate::define('viewNova', function ($user) {
            return $user->hasAnyRole(['admin', 'vendor']);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards(): array
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools(): array
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
}
