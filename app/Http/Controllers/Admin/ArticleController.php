<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use App\Models\Group;
use App\Models\Image;
use App\Models\Article;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.articles.index');
    }
    
    /**
     * Proceeds ajax request for datatable.
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function ajax(Request $request)
    {
        abort_unless($request->ajax(), 404);

        $articles = Article::query();
        return datatables()->of($articles)
            ->setTotalRecords($articles->count())
            ->editColumn('status', function ($article) {
                return view('admin.articles.partials.status', compact('article'));
            })
            ->addColumn('action', function ($article) {
                return view('admin.articles.partials.actions', compact('article'));
            })
            ->rawColumns(['status', 'action', 'buy'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::pluck('name', 'id');
        return view('admin.articles.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        if($request->hasFile('image'))
        {
            $name = Str::random(64);
            if($request->image->storeAs('public/images/articles/' . date('Y/m'), $name . '.' . $request->image->extension()))
            {
                $image = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => 'storage/images/articles/' . date('Y/m') . '/' . $name . '.' . $request->image->extension(),
                ]);
            }
        }
        $request->merge([
            'user_id'       => auth()->id(),
            'meta_keywords' => dash2comma($request->only('meta_keywords')),
            'image_id'      => $image->id ?? null,
        ]);
        $article = Article::create($request->only(['user_id', 'title', 'slug', 'image_id', 'content', 'meta_keywords', 'meta_description', 'status']));
        $article->groups()->sync($request->input('groups'));
        $this->doneMessage('مقاله مورد نظر شما با موفقیت ایجاد گردید.');
        return redirect()->route('admin.blog.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($blog)
    {
        $article        = Article::whereSlug($blog)->firstOrFail();
        $groups         = Group::pluck('name', 'id');
        $selectedGroups = $article->groups()->pluck('id')->toArray() ?? [];
        return view('admin.articles.edit', compact('article', 'groups', 'selectedGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PageRequest  $request
     * @param  string  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $blog)
    {
        $article = Article::whereSlug($blog)->firstOrFail();
        if($request->hasFile('image'))
        {
            $name = Str::random(64);
            if($request->image->storeAs('public/images/articles/' . date('Y/m'), $name . '.' . $request->image->extension()))
            {
                $image = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => 'storage/images/articles/' . date('Y/m') . '/' . $name . '.' . $request->image->extension(),
                ]);
                $request->merge(['image_id' => $image->id]);
            }
        }
        $request->merge([
            'meta_keywords' => dash2comma($request->only('meta_keywords')),
            'image_id'      => $image->id ?? $article->image_id,
        ]);
        $article->update($request->only(['title', 'slug', 'image_id', 'content', 'meta_keywords', 'meta_description', 'status']));
        $article->groups()->sync($request->input('groups'));
        $this->doneMessage('مقاله مورد نظر شما با موفقیت آپدیت گردید.');
        return redirect()->route('admin.blog.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        Article::destroy($id);
        $this->doneMessage('صفحه مورد نظر شما با موفقیت حذف گردید.');
        return redirect()->route('admin.blog.index');
    }
}
