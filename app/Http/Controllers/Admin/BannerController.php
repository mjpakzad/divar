<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use App\Models\BannerItem;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class BannerController extends Controller
{
    /**
     * BannerController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:banners-manage');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $banners = Banner::latest()->paginate();
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * This action saves a banner and its items into the database.
     *
     * @param  \App\Http\Requests\BannerRequest  $request
     * @return Response
     */
    public function store(BannerRequest $request)
    {
        $request->merge(['status' => $request->input('status') ? Banner::STATUS_PUBLISHED : Banner::STATUS_DRAFT]);
        $banner = Banner::create($request->only(['name', 'position', 'width', 'height', 'status']));

        // Puts items (inputs) of each row into an index of the banners array.
        $banners = array_map(function ($input, $banner_id) {
            $banners = [];
            foreach($input as $inputKey => $inputValues)
            {
                foreach ($inputValues as $key => $value)
                {
                    $banners[$key][$inputKey]       = $value;
                    $banners[$key]['banner_id']     = $banner_id;
                    $banners[$key]['created_at']    = date('Y-m-d H:i:s');
                    $banners[$key]['updated_at']    = date('Y-m-d H:i:s');
                    $banners[$key]['image_id']      = NULL;
                }
            }
            return $banners;
        }, [$request->only('title', 'url', 'content', 'sort_order')], [$banner->id])[0];

        if($request->hasfile('image'))
        {
            if($request->hasFile('image'))
            {
                $date = date('Y/m');
                foreach($request->file('image') as $key => $image)
                {
                    $name = Str::random(64);
                    if($image->storeAs('public/images/banners/' . $date, $name . '.' . $image->extension()))
                    {
                        $image = Image::create([
                            'user_id'   => auth()->id(),
                            'name'      => 'storage/images/banners/' . $date . '/' . $name . '.' . $image->extension(),
                        ]);
                    }
                    $banners[$key]['image_id'] = $image->id;
                }
            }
        }

        BannerItem::insert($banners);

        $this->doneMessage("آگهی شما با نام $banner->name ایجاد شد.");
        return redirect()->route('admin.banners.index');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('banner::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $banner = Banner::with('items')->findOrFail($id);
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BannerRequest  $request
     * @param integer $id
     * @return Response
     */
    public function update(BannerRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $request->merge(['status' => $request->input('status') ? Banner::STATUS_PUBLISHED : Banner::STATUS_DRAFT]);
        $banner->update($request->only(['name', 'position', 'width', 'height', 'status']));

        $date = date('Y/m');

        // Removes old banner items
        if ($request->input('keeper')) {
            $remove = array_diff_key(Arr::pluck($banner->items->toArray(), 'id', 'id'), $request->input('keeper'));
            $newBanners = array_diff_key($request->input('title'), $request->input('keeper'));
        } else {
            $remove = Arr::pluck($banner->items->toArray(), 'id', 'id');
            $newBanners = $request->input('title');
        }
        $banner->items()->whereIn('id', $remove)->delete();

        // Updates old banner items
        if ($request->input('keeper')){
            foreach ($request->input('keeper') as $key => $input) {
                $item_data = [
                    'title' => $request->input('title.' . $key),
                    'url' => $request->input('url.' . $key),
                    'content' => $request->input('content.' . $key),
                    'sort_order' => $request->input('sort_order.' . $key),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                if($request->hasfile('image.' . $key)) {
                    $name   = Str::random(64);
                    $image  = $request->file('image.' . $key);
                    if($image->storeAs('public/images/banners/' . $date, $name . '.' . $image->extension()))
                    {
                        $image = Image::create([
                            'user_id'   => auth()->id(),
                            'name'      => 'storage/images/banners/' . $date . '/' . $name . '.' . $image->extension(),
                        ]);
                    }
                    $item_data['image_id'] = $image->id;
                }
                $banner->items()->where('id', $key)->update($item_data);
            }
        }

        // Add new banner items.
        $banners = [];
        if($newBanners) {
            foreach ($newBanners as $key => $value) {
                $banners[$key] = [
                    'banner_id'     => $id,
                    'title'         => $request->input('title.' . $key),
                    'content'       => $request->input('content.' . $key),
                    'url'           => $request->input('url.' . $key),
                    'sort_order'    => $request->input('sort_order.' . $key),
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'image_id'      => NULL,
                ];
            }
        }

        if($request->hasfile('image'))
        {
            foreach($request->file('image') as $key => $image)
            {
                if (in_array($key, $request->input('keeper') ?? [])) {
                    continue;
                }
                $name = Str::random(64);
                if($image->storeAs('public/images/banners/' . $date, $name . '.' . $image->extension()))
                {
                    $image = Image::create([
                        'user_id'   => auth()->id(),
                        'name'      => 'storage/images/banners/' . $date . '/' . $name . '.' . $image->extension(),
                    ]);
                }
                $banners[$key]['image_id'] = $image->id;
            }
        }

        BannerItem::insert($banners);
        $this->doneMessage("آگهی شما با نام $banner->name آپدیت شد.");
        return redirect()->route('admin.banners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer $id
     * @return Response
     */
    public function destroy($id)
    {
        Banner::destory($id);
        $this->doneMessage('بنر با موفقیت حذف شد.');
        return redirect()->route('admin.banners.index');
    }
}
