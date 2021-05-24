<?php

namespace App\Http\Controllers\Frontend;

use App\Events\CommercialPublished;
use App\Http\Requests\FrontendCommercialRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Commercial;
use App\Models\District;
use App\Models\Field;
use App\Models\Image;
use App\Models\ReportReasons;
use Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Str;

class CommercialController extends Controller
{
    /**
     * CommercialController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['new', 'show', 'contact', 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $commercialsQuery   = Commercial::with([
            'district',
            'fields' => function ($query) {
                $query->price();
            },
        ])
            ->accepted();
        if ($request->category) {
            $commercialsQuery->where('category_id', $request->category);
        }
        if ($request->district) {
            $commercialsQuery->where('district_id', $request->district);
        }
        if ($request->phrase) {
            $commercialsQuery->where('title', 'LIKE', "%$request->phrase%");
        }
        if ($request->hasImage) {
            $commercialsQuery->whereNotNull('image_id');
        }
        if ($request->isFeatured == 'true') {
            $featured_days = Setting::where('key', 'featured_days')->value('value');
            $commercialsQuery->whereNotNull('featured_at')
                            ->where('featured_at', '>', Carbon::now()->subDays($featured_days));
        }
        $commercials = $commercialsQuery->latest('laddered_at')
            ->paginate(16);
        if ($request->ajax()) {
            $view = view('frontend.partials.advertise', compact('commercials'))->render();
            return response()->json([
                'html' => $view
            ]);
        }
        return view('frontend.commercials.index', compact('commercials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\City  $city
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function create(City $city, Category $category)
    {
        $cities = City::pluck('name', 'slug');
        $districts = District::whereCityId($city->id)->pluck('name', 'id');
        $fields = Field::whereHas('categories', function ($query) use($category) {
            $query->where('id', $category->id);
        })->get();
        return view('frontend.commercials.create', compact('city', 'cities', 'category', 'districts', 'fields'));
    }

    /**
     * Show the form for selecting the category to creating a new resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function new(City $city)
    {
        $categories = Category::with('activeChildren.image')->doesntHaveParent()->get();
        $allCategories = [];
        foreach($categories as $category) {
            $allCategories[$category->id] = restructure_category($city, $category);
            if($category->activeChildren->count()) {
                foreach ($category->activeChildren as $child) {
                    $allCategories[$child->id] = restructure_category($city, $child);
                    if($child->activeChildren->count()) {
                        foreach ($child->activeChildren as $grand) {
                            $allCategories[$grand->id] = restructure_category($city, $grand);
                            if($grand->activeChildren->count()) {
                                foreach ($grand->activeChildren as $great) {
                                    $allCategories[$great->id] = restructure_category($city, $great);
                                }
                            }
                        }
                    }
                }
            }
        }
        return view('frontend.commercials.new', compact('city', 'allCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FrontendCommercialRequest  $request
     * @param  \App\Models\City  $city
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function store(FrontendCommercialRequest $request, City $city, Category $category)
    {
        $site_title = get_setting('title');
        $meta['keywords'] = $meta['description'] = [$request->input('title'), $category->name, $city->name, $site_title];
        $meta['description'][3] = Str::words($request->input('title'), 4);
        $commercial_data = $request->only(['title', 'content', 'meta_description', 'status']);
        $commercial_data['user_id']             = auth()->id();
        $commercial_data['category_id']         = $category->id;
        $commercial_data['city_id']             = $city->id;
        $commercial_data['district_id']         = $request->input('district');
        $commercial_data['lat']                 = $request->input('latitude');
        $commercial_data['lng']                 = $request->input('longitude');
        $commercial_data['slug']                = make_slug($request->input('title'));
        $commercial_data['meta_keywords']       = implode(',', $meta['keywords']);
        $commercial_data['meta_description']    = implode(' | ', $meta['description']);
        $images_data = [];
        $image_counter = 0;
        if($request->hasFile('images'))
        {
            $date = date('Y/m');
            foreach($request->file('images') as $key => $file)
            {
                if($image_counter++ == 5) {
                    break;
                }
                $name = Str::random(64);
                $image = \Image::make($file);
                $image->orientate();
                $imageName = $name . '.' . $file->getClientOriginalExtension();
                $destinationPath = '/storage/images/' . $date . '/';
                $root = $_SERVER["DOCUMENT_ROOT"];
                $dir = $root . $destinationPath;
                $old = umask(0);
                if( !file_exists($dir) ) {
                    mkdir($dir, 0755, true);
                }
                umask($old);
                $image->save($dir . $imageName, 20);
                $name = $destinationPath . $imageName;

                $images_data[] = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => $name,
                ]);
            }
        }
        $commercial_data['laddered_at'] = now();
        $commercial = Commercial::create($commercial_data);
        $commercial->images()->saveMany($images_data);
        if($request->fields) {
            $fields = [];
            foreach ($request->fields as $fieldId => $fieldValue) {
                if($fieldValue) {
                    $fields[$fieldId] = ['value' => to_latin_numbers($fieldValue)];
                }
            }
            $commercial->fields()->sync($fields);
        }
        $images = $commercial->images;
        foreach ($images as $image) {
            $commercial->update(['image_id' => $image->id]);
        }
        //event(new CommercialPublished($commercial));
        $this->doneMessage("آگهی شما با موفقیت ثبت شد، بعد از تایید ناظر آگهی شما انتشار می‌یابد.");
        return redirect()->route('frontend.my.show');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Commercial $commercial)
    {
        if($commercial->status != 1) {
            if (auth()->check()) {
                $user = auth()->user();
                abort_if ($commercial->user_id != $user->id, '404', 'آگهی مورد نظر یافت نشد!');
            }
            else {
                abort(404, 'آگهی مورد نظر یافت نشد!');
            }
        }
        $commercial->load('fields', 'images', 'category.parent.parent.parent.parent.parent', 'comments');
        if ($request->session()->has('sentComment')) {
            $request->session()->forget('sentComment');
        } else {
            $commercial->increment('view_counts');
        }
        $breadcrumb[] = [
            'slug'  => $commercial->category->slug,
            'name'  => $commercial->category->name,
        ];
        if($commercial->category->parent_id) {
            $breadcrumb[] = [
                'slug'  => $commercial->category->parent->slug,
                'name'  => $commercial->category->parent->name,
            ];
            if($commercial->category->parent->parent_id) {
                $breadcrumb[] = [
                    'slug'  => $commercial->category->parent->slug,
                    'name'  => $commercial->category->parent->name,
                ];
                if($commercial->category->parent->parent->parent_id) {
                    $breadcrumb[] = [
                        'slug'  => $commercial->category->parent->parent->slug,
                        'name'  => $commercial->category->parent->parent->name,
                    ];
                    if($commercial->category->parent->parent->parent->parent_id) {
                        $breadcrumb[] = [
                            'slug'  => $commercial->category->parent->parent->parent->slug,
                            'name'  => $commercial->category->parent->parent->parent->name,
                        ];
                    }
                }
            }
        }
        $breadcrumb = array_reverse($breadcrumb);
        $reportReasons = ReportReasons::pluck('title', 'id');
        $settings = get_settings();
        $relatedCommercials    = Commercial::where('category_id', $commercial->category_id)
                                            ->where('id', '!=', $commercial->id)
                                            ->inRandomOrder()
                                            ->distinct()
                                            ->take(6)
                                            ->get();
        $commercial->views()->create();
        $site_settings = get_settings();
        return view('frontend.commercials.show', compact('commercial', 'reportReasons', 'breadcrumb', 'settings', 'relatedCommercials', 'site_settings'));
    }

    /**
     * Display the specified resource to manage that.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage(Request $request, Commercial $commercial)
    {
        return view('frontend.commercials.manage', compact('commercial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function edit($commercial)
    {
        $commercial = Commercial::withCount(['clicks', 'views'])->whereSlug($commercial)->where('user_id', auth()->id())->firstOrFail();
        $fields = $commercial->fields()->whereHas('categories', function ($query) use($commercial) {
            $query->where('id', $commercial->category_id);
        })->get();
        return view('frontend.commercials.edit', compact('commercial', 'fields'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commercial $commercial)
    {
        $commercial_data = $request->only(['title', 'content', 'meta_description']);
        $commercial_data['lat']     = $request->input('latitude');
        $commercial_data['lng']     = $request->input('longitude');
        $commercial_data['status']  = Commercial::STATUS_PENDING;
        // Remove old images
        if($request->keeper) {
            $remove = array_diff_key(Arr::pluck($commercial->images->toArray(), 'id', 'id'), $request->keeper);
        } else {
            $remove = Arr::pluck($commercial->images->toArray(), 'id', 'id');
        }
        $commercial->images()->whereIn('id', $remove)->delete();
        if($request->hasFile('images'))
        {
            $image_counter = $commercial->images->count();
            $date = date('Y/m');
            foreach($request->file('images') as $key => $file)
            {
                if($image_counter++ == 5) {
                    break;
                }
                if(in_array($key, $request->keeper ?? [])) {
                    continue;
                }
                $name = Str::random(64);
                $image = \Image::make($file);
                $image->orientate();
                $imageName = $name . '.' . $file->getClientOriginalExtension();
                $destinationPath = '/storage/images/' . $date . '/';
                $root = $_SERVER["DOCUMENT_ROOT"];
                $dir = $root . $destinationPath;
                $old = umask(0);
                if( !file_exists($dir) ) {
                    mkdir($dir, 0755, true);
                }
                umask($old);
                $image->save($dir . $imageName, 20);
                $name = $destinationPath . $imageName;

                $images_data[] = Image::create([
                    'user_id'   => auth()->id(),
                    'name'      => $name,
                ]);
            }
            $commercial->images()->saveMany($images_data);
        }
        $commercial->update($commercial_data);
        if($request->fields) {
            $fields = [];
            foreach ($request->fields as $fieldId => $fieldValue) {
                if($fieldValue) {
                    $fields[$fieldId] = ['value' => to_latin_numbers($fieldValue)];
                }
            }
            $commercial->fields()->sync($fields);
        }
        $images = $commercial->images;
        foreach ($images as $image) {
            $commercial->update(['image_id' => $image->id]);
        }
        $this->doneMessage("آگهی $commercial->name آپدیت شد.");
        return redirect()->route('frontend.my.show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, Commercial $commercial)
    {
        $user_id = auth()->id();
        $commercial->update(['reason' => $request->reason]);
        if($commercial->user_id == $user_id) {
            $commercial->delete();
            $this->doneMessage('آگهی با موفقیت حذف گردید.');
        }
        return redirect()->route('frontend.my.show');
    }

    /**
     * Return contact info.
     *
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function contact(Request $request, Commercial $commercial)
    {
        $commercial->load('user');
        $content = view('frontend.commercials.partials.content', compact('commercial'))->render();
        $contact = view('frontend.commercials.partials.contact', compact('commercial'))->render();
        $commercial->clicks()->create([
            'user_id'       => auth()->check() ? auth()->id() : null,
            'ip'            => $request->getClientIp(),
            'user_agent'    => $request->header('User-Agent'),
        ]);

        $message = [
            'status'    => 'success',
            'body'      => "اطلاعات تماس را در زیر مشخصات آگهی می‌توانید مشاهده کنید.",
            'content'   => $content,
            'contact'   => $contact,
        ];
        return response()->json($message);
    }
}
