<?php


namespace App\Providers;

use App\Http\ViewComposers\AuthComposer;
use App\Http\ViewComposers\CitiesComposer;
use App\Http\ViewComposers\CityComposer;
use App\Http\ViewComposers\CommercialsCountComposer;
use App\Http\ViewComposers\DistrictsComposer;
use App\Http\ViewComposers\FooterComposer;
use App\Http\ViewComposers\GroupsComposer;
use App\Http\ViewComposers\MenuComposer;
use App\Http\ViewComposers\SettingsComposer;
use App\Http\ViewComposers\CategoriesComposer;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', AuthComposer::class);

        view()->composer('admin.layouts.sidebar', SettingsComposer::class);
        view()->composer('admin.layouts.header', SettingsComposer::class);
        view()->composer('admin.layouts.meta', SettingsComposer::class);
        view()->composer('admin.layouts.sidebar', MenuComposer::class);

        view()->composer('frontend.layouts*', SettingsComposer::class);
        view()->composer('frontend.layouts.header', CitiesComposer::class);
        view()->composer('frontend.layouts.header', CityComposer::class);
        view()->composer('frontend.layouts.header', GroupsComposer::class);
        view()->composer('frontend.layouts.footer', FooterComposer::class);
        view()->composer('frontend.layouts.sidebar', CategoriesComposer::class);
        view()->composer('frontend.partials.commercials-categories', CategoriesComposer::class);
        view()->composer('frontend.partials.filters', DistrictsComposer::class);
        view()->composer('frontend.partials.filters', CategoriesComposer::class);
        view()->composer('frontend.partials.filters', CommercialsCountComposer::class);
    }
}
