<?php


namespace App\Http\ViewComposers;

use App\Models\City;
use Illuminate\Contracts\View\View;

class CitiesComposer
{
    public function compose(View $view)
    {
        $cities = City::latest('sort_order')->get();
        $view->with('cities', $cities);
    }
}