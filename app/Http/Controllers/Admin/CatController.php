<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CatController extends Controller
{
    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:categories-create')->only(['create', 'store']);
        $this->middleware('permission:categories-edit')->only(['edit', 'update']);
        $this->middleware('permission:categories-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::withCount('commercials')->main()->get();
        return view('admin.cats.index', compact('categories'));
    }

    /**
     * Proceeds ajax request for datatable.
     *
     * @param Request $request
     * @param  string  $cat
     * @return mixed
     * @throws \Exception
     */
    public function ajax(Request $request, $cat)
    {
        $category = Category::where('slug', $cat)->firstOrFail();
        abort_unless($request->ajax(), 404);
        $categories = Category::withCount('commercials')->where('parent_id', $category->id);
        return datatables()->of($categories)
            ->editColumn('status', function ($category) {
                return view('admin.shop.categories.partials.status', compact('category'));
            })
            ->addColumn('action', function ($category) {
                return view('admin.shop.categories.partials.action', compact('category'));
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $cat
     * @return \Illuminate\Http\Response
     */
    public function show($cat)
    {
        $category = Category::where('slug', $cat)->firstOrFail();
        return view('admin.cats.show', compact('category'));
    }
}
