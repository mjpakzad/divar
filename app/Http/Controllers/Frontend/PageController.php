<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Page;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Page $page)
    {
        $view = $page->slug == 'call' ? 'frontend.pages.contact' : 'frontend.pages.show';
        return view($view, compact('page'));
    }
}
