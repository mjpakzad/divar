<?php


namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class MenuComposer
{
    public function compose(View $view)
    {
        $menus              = menu_build();
        $userPermissions    = user_permissions();
        $userRoles          = user_roles();
        $view->with('menus', $menus);
        $view->with('userPermissions', $userPermissions);
        $view->with('userRoles', $userRoles);
    }
}