<?php

namespace App\Http\Controllers\Frontend;

use App;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;

class SitemapController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $sitemap = App::make('sitemap');
        $sitemap->setCache('laravel.sitemap', 60);
        if (!$sitemap->isCached()) {
            $sitemap->add(URL::to('/'), '2012-08-25T20:10:00+02:00', '1.0', 'daily');
            $commercials = DB::table('commercials')
                ->orderBy('created_at', 'desc')
                ->where('status', 1)
                ->get();
            $articles = DB::table('articles')
                ->orderBy('created_at', 'desc')
                ->where('status', 1)
                ->get();
            foreach ($commercials as $commercial) {
                $sitemap->add(route('frontend.commercials.show', $commercial->slug), $commercial->updated_at, '0.8', 'daily');
            }
            foreach ($articles as $article) {
                $sitemap->add(route('frontend.blog.show', $article->slug), $article->updated_at, '0.8', 'daily');
            }
        }
        return $sitemap->render('xml');

    }
}
