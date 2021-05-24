<?php


namespace App\Http\ViewComposers;

use App\Models\Category;
use App\Models\City;
use App\Models\Commercial;
use Illuminate\Contracts\View\View;
use Route;

class CommercialsCountComposer
{
    public function compose(View $view)
    {
        $commercialsQuery = Commercial::accepted();
        $routeName          = Route::currentRouteName();
        $routeParameters    = Route::current()->parameters;
        if(isset($routeParameters['city'])) {
            $currentCity = City::whereSlug($routeParameters['city'])->first();
            $commercialsQuery->where('city_id', $currentCity->id);
        }
        if(isset($routeParameters['category'])) {
            $currentCategory = Category::whereSlug($routeParameters['category'])->first();
            $commercialsQuery->where('category_id', $currentCategory->id);
        }
        $commercialsCount = array_reverse(str_split($commercialsQuery->count()));
        $view->with('commercialsCount', $commercialsCount);
    }
}
