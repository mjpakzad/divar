<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with(['image', 'reviews' => function ($query) {
            $query->approved();
        }])->published()->latest()->paginate();
        return view('frontend.articles.index', compact('articles'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $blog
     * @return \Illuminate\Http\Response
     */
    public function show($blog)
    {
        $article = Article::with('image')->whereSlug($blog)->published()->firstOrFail();
        return view('frontend.articles.show', compact('article'));
    }
}
