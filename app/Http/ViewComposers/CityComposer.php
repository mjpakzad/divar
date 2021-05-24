<?php


namespace App\Http\ViewComposers;

use App\Models\Category;
use App\Models\City;
use Illuminate\Contracts\View\View;
use Route;

class CityComposer
{
    public function compose(View $view)
    {
        $routeParameters    = Route::current()->parameters;
        $currentCity        = isset($routeParameters['city']) ? City::whereSlug($routeParameters['city'])->first() : null;
        $view->with('currentCity', $currentCity);
    }
}
