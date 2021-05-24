<?php


namespace App\Http\ViewComposers;

use App\Models\Banner;
use Illuminate\Contracts\View\View;

class FooterComposer
{
    public function compose(View $view)
    {
        $footerCol1 = Banner::with('orderedItems')->inPosition('footer-col-1')->firstOrFail();
        $footerCol2 = Banner::with('orderedItems')->inPosition('footer-col-2')->firstOrFail();
        $footerCol3 = Banner::with('orderedItems')->inPosition('footer-col-3')->firstOrFail();
        $view->with('footerCol1', $footerCol1);
        $view->with('footerCol2', $footerCol2);
        $view->with('footerCol3', $footerCol3);
    }
}