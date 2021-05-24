<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Product;
use App\Models\Commercial;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    /**
     * AppController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:dashboard-access');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commercialCount    = Commercial::count();
        $articleCount       = Article::count();
        $userCount          = User::count();
        $productCount       = Product::count();
        return view('admin.app.index', compact('commercialCount', 'articleCount', 'userCount', 'productCount'));
    }
}
