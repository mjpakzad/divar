<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PageRequest;
use App\Models\Image;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::latest()->paginate();
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        if($request->hasFile('image'))
        {
            $name = Str::random(64);
            if($request->image->storeAs('public/images/pages/' . date('Y/m'), $name . '.' . $request->image->extension()))
            {
                $image = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => 'storage/images/pages/' . date('Y/m') . '/' . $name . '.' . $request->image->extension(),
                ]);
            }
        }
        $request->merge([
            'user_id'       => auth()->id(),
            'meta_keywords' => dash2comma($request->only('meta_keywords')),
            'image_id'      => $image->id ?? null,
        ]);
        $page = Page::create($request->only(['user_id', 'title', 'slug', 'image_id', 'content', 'meta_keywords', 'meta_description', 'status']));
        $this->doneMessage('صفحه مورد نظر شما با موفقیت ایجاد گردید.');
        return redirect()->route('admin.pages.index');
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
     * @param  Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PageRequest  $request
     * @param  App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page $page)
    {
        if($request->hasFile('image'))
        {
            $name = Str::random(64);
            if($request->image->storeAs('public/images/pages/' . date('Y/m'), $name . '.' . $request->image->extension()))
            {
                $image = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => 'storage/images/pages/' . date('Y/m') . '/' . $name . '.' . $request->image->extension(),
                ]);
                $request->merge(['image_id' => $image->id]);
            }
        }
        $request->merge([
            'meta_keywords' => dash2comma($request->only('meta_keywords')),
            'image_id'      => $image->id ?? $page->image,
        ]);
        $page->update($request->only(['title', 'slug', 'image_id', 'content', 'meta_keywords', 'meta_description', 'status']));
        $this->doneMessage('صفحه مورد نظر شما با موفقیت آپدیت گردید.');
        return redirect()->route('admin.pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Page $page)
    {
        $page->delete();
        $this->doneMessage('صفحه مورد نظر شما با موفقیت حذف گردید.');
        return redirect()->route('admin.pages.index');
    }
}
