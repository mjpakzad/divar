<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Field;
use App\Models\Image;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CategoryController extends Controller
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
        return view('admin.categories.index');
    }

    /**
     * Proceeds ajax request for datatable.
     *
     * @param Request $request
     * @param  \App\Models\Type  $type
     * @return mixed
     * @throws \Exception
     */
    public function ajax(Request $request)
    {
        abort_unless($request->ajax(), 404);
        $categories = Category::withCount('commercials')->with('parent');
        return datatables()->of($categories)
            ->addColumn('parent', function ($category) {
                return view('admin.categories.partials.parent', compact('category'));
            })
            ->addColumn('commercials_count', function ($category) {
                return $category->commercials_count;
            })
            ->editColumn('status', function ($category) {
                return view('admin.categories.partials.status', compact('category'));
            })
            ->addColumn('action', function ($category) {
                return view('admin.categories.partials.action', compact('category'));
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents    = Category::pluck('name', 'id')->toArray();
        $fields     = Field::get();
        return view('admin.categories.create', compact('parents', 'fields'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category_data  = $request->only(['name', 'label', 'slug', 'icon', 'image', 'content', 'meta_description', 'parent_id',  'sort_order', 'buy', 'sell']);
        $category_data['meta_keywords'] = dash2comma($request->input('meta_keywords'));
        $category_data['featured']      = (is_null($request->input('featured')) ? Category::FEATURED_NOT : $request->input('featured'));
        $category_data['status']        = $request->input('status') ? Category::STATUS_PUBLISHED : Category::STATUS_DRAFT;
        $category_data['image']         = null;
        if($request->hasFile('image'))
        {
            $name = Str::random(64);
            if($request->image->storeAs('public/images/categories/' . date('Y/m'), $name . '.' . $request->image->extension()))
            {
                $image = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => 'storage/images/categories/' . date('Y/m') . '/' . $name . '.' . $request->image->extension(),
                ]);
                image_resize($image->name, ['width' => 18, 'height' => 18]);
                $category_data['image_id'] = $image->id;
            }
        }
        $category = Category::create($category_data);
        $category->fields()->sync($request->input('fields'));
        $this->doneMessage("دسته‌بندی $category->name ایجاد شد.");
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('admin.categories.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $children                   = $category->children()->get()->toArray();
        $parents                    = Category::where('id', '<>', $category->id)->pluck('name','id')->toArray();
        $category->meta_keywords    = comma2dash($category->meta_keywords);
        $fields                     = Field::all();
        $selectedFields             = $category->fields()->pluck('id')->toArray();
        return view('admin.categories.edit', compact('category', 'parents', 'fields', 'selectedFields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category_data  = $request->only(['name', 'label', 'slug', 'icon', 'image', 'content', 'meta_description', 'parent_id',  'sort_order', 'buy', 'sell']);
        $category_data['meta_keywords'] = dash2comma($request->input('meta_keywords'));
        $category_data['featured']      = (is_null($request->input('featured')) ? Category::FEATURED_NOT : $request->input('featured'));
        $category_data['status']        = $request->input('status') ? Category::STATUS_PUBLISHED : Category::STATUS_DRAFT;
        if($request->hasFile('image'))
        {
            $name = Str::random(64);
            if($request->image->storeAs('public/images/categories/' . date('Y/m'), $name . '.' . $request->image->extension()))
            {
                $image = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => 'storage/images/categories/' . date('Y/m') . '/' . $name . '.' . $request->image->extension(),
                ]);
                image_resize($image->name, ['width' => 18, 'height' => 18]);
                $category_data['image_id'] = $image->id;
            }
        }
        if ($request->input('remove_image'))
        {
            $category_data['image_id'] = null;
        }
        $category->update($category_data);
        $category->fields()->sync($request->input('fields'));
        $this->doneMessage("دسته‌بندی با موفقیت آپدیت شد.");
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  integer $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        Category::destroy($id);
        $this->doneMessage('دسته‌بندی با موفقیت حذف شد.');
        return redirect()->route('admin.categories.index');
    }
    
    public function list(Request $request)
    {
        $categoriesQuery = Category::latest();
        if($request->input('searchTerm'))
        {
            $phrase = strtolower($request->input('searchTerm'));
            $categoriesQuery->where('name', 'LIKE', "%$phrase%")
                        ->orWhere('slug', 'LIKE', "%$phrase%");
        }
        if($request->input('category'))
        {
            $categoriesQuery->where('parent_id', $request->input('category'));
        }
        $categories = $categoriesQuery->get();

        $data = [];
        foreach ($categories as $category) {
            $data[] = [
                'id'    => $category->id,
                'text'  => $category->name,
            ];
        }

        return response()->json($data);
    }
}
