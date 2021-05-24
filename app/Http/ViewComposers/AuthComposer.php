<?php


namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class AuthComposer
{
    public function compose(View $view)
    {
        if (auth()->check())
        {
            $auth_user = auth()->user();
            $view->with('auth_user', $auth_user);
        }
    }
}