<?php


namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class SettingsComposer
{
    public function compose(View $view)
    {
        $settings = get_settings();
        $view->with('site_settings', $settings);
    }
}