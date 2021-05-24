<?php


namespace App\Http\ViewComposers;

use App\Models\Category;
use App\Models\City;
use Illuminate\Contracts\View\View;
use Route;

class CategoriesComposer
{
    public function compose(View $view)
    {
        $routeName          = Route::currentRouteName();
        $routeParameters    = Route::current()->parameters;
        switch ($routeName) {
            case 'frontend.app.index':
                $categories = Category::main()->published()->sorted()->get();
                break;
            case 'frontend.cities.show':
                $categories = Category::main()->published()->sorted()->get();
                break;
            case 'frontend.cities.category':
                $category       = Category::with([
                    'parent',
                    'children' => function($query) {
                        $query->published()->sorted();
                    }
                ])
                    ->whereSlug($routeParameters['category'])
                    ->first();
                $categories     = $category->children;
                $parentCategory = $category->parent;
                $view->with('parentCategory', $parentCategory);
                break;
            default:
                $categories = Category::all();
        }
        $mainCategories = Category::with('children')->main()->published()->get();
        $view->with('categories', $categories);
        $view->with('routeName', $routeName);
        $view->with('routeParameters', $routeParameters);
        $view->with('mainCategories', $mainCategories);
    }
}