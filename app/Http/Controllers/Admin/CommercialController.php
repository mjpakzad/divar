<?php
namespace App\Http\Controllers\Admin;

use App\Events\CommercialPublished;
use App\Events\CommercialRejected;
use App\Events\CommercialReportaged;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommercialRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Commercial;
use App\Models\District;
use App\Models\Field;
use App\Models\Image;
use App\Models\Setting;
use App\TagGenerator;
use Arr;
use DataTables;
use Illuminate\Http\Request;
use Sms;
use Str;
use Rap2hpoutre\FastExcel\FastExcel;

class CommercialController extends Controller
{
    /**
     * CommercialController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:commercials-create')->only(['create', 'store']);
        $this->middleware('permission:commercials-edit')->only(['edit', 'update', 'tag']);
        $this->middleware('permission:commercials-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.commercials.index');
    }
    
    public function export()
    {
        return (new FastExcel(Commercial::with('user', 'city')->get()))->download('commercials.xlsx', function ($commercial) {
            return [
                'slug'              => $commercial->slug,
                'title'             => $commercial->title,
                'first_name'        => $commercial->user->first_name,
                'last_name'         => $commercial->user->last_name,
                'mobile'            => $commercial->user->mobile,
                'city'              => $commercial->city->name,
                'expertise_checked' => $commercial->expertise_checked ? 'بله' : 'خیر',
                'created_at'        => jdate($commercial->created_at)->format('d F Y'),
            ];
        });
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

        $commercials = Commercial::with('user.roles', 'registrar', 'city', 'district', 'category')->withCount(['clicks', 'views'])->withTrashed();
        return datatables()->of($commercials)
            ->setTotalRecords($commercials->count())
            ->addColumn('mobile', function ($commercial) {
                return $commercial->user->mobile;
            })
            ->addColumn('clicks_count', function ($commercial) {
                return $commercial->clicks_count;
            })
            ->addColumn('views_count', function ($commercial) {
                return $commercial->views_count;
            })
            ->addColumn('city', function ($commercial) {
                return $commercial->city->name ?? '';
            })
            ->addColumn('name', function ($commercial) {
                return $commercial->user->name ?? '';
            })
            ->addColumn('staff', function ($commercial) {
                return $commercial->registrar->name ?? '';
            })
            ->addColumn('tag', function ($commercial) {
                return view('admin.commercials.partials.tags', compact('commercial'));
            })
            ->editColumn('laddered_at', function ($commercial) {
                return is_null($commercial->laddered_at) ? '' : jdate($commercial->laddered_at)->format('d F Y ساعت H:i');
            })
            ->editColumn('featured_at', function ($commercial) {
                return is_null($commercial->laddered_at) ? '' : jdate($commercial->featured_at)->format('d F Y ساعت H:i');
            })
            ->editColumn('buy', function ($commercial) {
                return view('admin.commercials.partials.buy', compact('commercial'));
            })
            ->editColumn('status', function ($commercial) {
                return view('admin.commercials.partials.status', compact('commercial'));
            })
            ->addColumn('action', function ($commercial) {
                return view('admin.commercials.partials.actions', compact('commercial'));
            })
            ->rawColumns(['status', 'action', 'buy', 'tag'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities         = City::pluck('name', 'id')->toArray();
        $categories     = Category::pluck('name', 'id')->toArray();
        $mainCategories = Category::main()->pluck('name', 'id')->toArray();
        return view('admin.commercials.create', compact('cities', 'categories', 'mainCategories'));
    }

    /**
     * Return districts of the city.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function districts(Request $request)
    {
        $city = $request->city;
        $districts = District::whereCityId($city)->pluck('name', 'id');
        $data = [];
        foreach ($districts as $id => $name) {
            $data[] = [
                'id'    => $id,
                'text'  => $name,
            ];
        }
        return response()->json($data);
    }

    /**
     * Return fileds of the category along with a notification of status.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function fields(Request $request)
    {
        abort_unless($request->ajax(), 404);
        $category_id = $request->category;
        $sale = $request->buy == 1 ? false : true;
        $category    = Category::find($category_id);
        if(!$category) {
            $message = [
                'status'    => 'danger',
                'body'      => "دسته بندی مورد نظر وجود ندارد.",
                'fields'    => '',
                'category'  => [],
            ];
            return response()->json($message);
        }
        if (is_null($category_id)) {
            $message = [
                'status'    => 'danger',
                'body'      => "برای نمایش فیلدهای اطلاعاتی، باید دسته‌بندی را مشخص کنید.",
                'fields'    => '',
            ];
            return response()->json($message);
        }
        $fields = Field::whereHas('categories', function ($query) use($category_id) {
            $query->where('id', $category_id);
        })->where('buy', '<>', $sale)->get();
        if($request->slug != null) {
            $commercial = Commercial::with('fields')->where('slug', $request->slug)->firstOrFail();
            $commercialFields = $commercial->fields->pluck('pivot.value', 'id');
            foreach ($fields as $field) {
                $field->value = $commercialFields[$field->id] ?? null;
            }
        }

        $fields = view('admin.commercials.partials.fields', compact('fields'))->render();

        $message = [
            'status'    => 'success',
            'body'      => 'فیلدها در تب اطلاعات اضافه شدند.',
            'fields'    => $fields,
            'category'  => $category,
        ];
        return response()->json($message);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CommercialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommercialRequest $request)
    {
        $commercial_data = $request->only(['title', 'slug', 'content', 'meta_description', 'status', 'expertise_checked', 'aparat', 'whatsapp']);
        $commercial_data['user_id']         = $request->input('user_id');
        $commercial_data['registrar_id']    = auth()->id();
        $commercial_data['slug']            = make_slug($request->input('title'));
        $commercial_data['category_id']     = $request->input('category');
        $commercial_data['city_id']         = $request->input('city');
        $commercial_data['buy']             = $request->input('buy', false);
        $commercial_data['district_id']     = $request->input('district');
        $commercial_data['lat']             = $request->input('latitude');
        $commercial_data['lng']             = $request->input('longitude');
        $commercial_data['laddered_at']     = now();
        $commercial_data['meta_keywords']   = dash2comma($request->input('meta_keywords'));
        $images_data = [];
        if($request->hasFile('images'))
        {
            $date       = date('Y/m');
            foreach($request->file('images') as $key => $file)// Before:: file was image
            {
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
        if ($request->hasFile('voice')) {
            $name = Str::random(64);
            if ($request->voice->storeAs('public/voices/' . date('Y/m'), $name . '.' . $request->voice->extension())) {
                $commercial_data['voice']       = 'storage/voices/' . date('Y/m') . '/' . $name . '.' . $request->voice->extension();
                $commercial_data['voice_mime']  = $request->voice->getMimeType();
            }
        }
        $commercial = Commercial::create($commercial_data);
        $commercial->images()->saveMany($images_data);
        if($request->fields) {
            foreach ($request->fields as $fieldId => $fieldValue) {
                $fields[$fieldId] = ['value' => to_latin_numbers($fieldValue)];
            }
            $commercial->fields()->sync($fields);
        }
        $images = $commercial->images;
        foreach ($images as $image) {
            $commercial->update(['image_id' => $image->id]);
        }
        $this->doneMessage("آگهی $commercial->name ایجاد شد.");
        return redirect()->route('admin.commercials.index');
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
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function edit(Commercial $commercial)
    {
        $commercial->load('fields', 'images', 'user', 'tags');
        $cities     = City::pluck('name', 'id')->toArray();
        $districts  = District::whereCityId($commercial->city_id)->pluck('name', 'id')->toArray();
        $fields = Field::whereHas('categories', function ($query) use ($commercial) {
            $query->whereCategoryId($commercial->category_id);
        })->get();
        $commercialFields = $commercial->fields->pluck('pivot.value', 'id');
        foreach ($fields as $field) {
            $field->value = $commercialFields[$field->id] ?? null;
        }
        $categories = Category::pluck('name', 'id')->toArray();
        $mainCategories = Category::main()->pluck('name', 'id')->toArray();
        return view('admin.commercials.edit', compact('cities', 'districts', 'commercial', 'fields', 'categories', 'mainCategories'));
    }
    
    /**
     * 
     */
     public function tags(Commercial $commercial)
     {
         TagGenerator::generate($commercial->slug);
         $this->doneMessage('برچسب‌ها با موفقیت اضافه شدند.');
         return back();
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CommercialRequest  $request
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function update(CommercialRequest $request, Commercial $commercial)
    {
        $commercial_data = $request->only(['title', 'content', 'meta_description', 'status', 'aparat', 'immediate', 'featured', 'whatsapp']);
        $commercial_data['city_id']         = $request->input('city');
        $commercial_data['buy']             = $request->input('buy', false);
        $commercial_data['district_id']     = $request->input('district');
        $commercial_data['meta_keywords']   = dash2comma($request->input('meta_keywords'));
        $commercial_data['lat']             = $request->input('latitude');
        $commercial_data['lng']             = $request->input('longitude');
        $commercial_data['category_id']     = $request->input('category');
        $commercial_data['user_id']         = $request->input('user_id');
        if($request->input('ladder')) {
            $commercial_data['laddered_at'] = now();
        }
        if($request->input('feature')) {
            $commercial_data['featured_at'] = now();
        }
        if($request->input('reportage')) {
            $commercial_data['reportage_at'] = now();
            event(new CommercialReportaged($commercial));
        }
        if($request->input('expire')) {
            $fdays = Setting::where('key', 'featured_days')->value('value');
            $commercial_data['expire_at'] = now()->addDays($fdays);
        }
        if ($request->hasFile('voice')) {
            $name = Str::random(64);
            if ($request->voice->storeAs('public/voices/' . date('Y/m'), $name . '.' . $request->voice->extension())) {
                $commercial_data['voice']       = 'storage/voices/' . date('Y/m') . '/' . $name . '.' . $request->voice->extension();
                $commercial_data['voice_mime']  = $request->voice->getMimeType();
            }
        }
        // Remove old images
        if($request->keeper) {
            $remove = array_diff_key(Arr::pluck($commercial->images->toArray(), 'id', 'id'), $request->keeper);
        } else {
            $remove = Arr::pluck($commercial->images->toArray(), 'id', 'id');
        }
        Image::destroy($remove);
        $images_data = [];
        if($request->hasFile('images'))
        {
            $date = date('Y/m');
            foreach($request->file('images') as $key => $file)
            {
                if(in_array($key, $request->keeper ?? [])) {
                    Image::where('id', $key)->update(['alt' => $request->input('alt.' . $key)]);
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
                    'alt'       => $request->input('alt.' . $key),
                ]);
            }
            $commercial->images()->saveMany($images_data);
        }
        
        if($commercial->status == 0 && $commercial_data == 1) {
            event(new CommercialPublished($commercial));
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
            $commercial->update(['image_id' => $image->id, 'alt' => $image->alt]);
            break;
        }
        switch($commercial->status) {
            case Commercial::STATUS_REJECTED:
                event(new CommercialRejected($commercial));
                break;
            case Commercial::STATUS_ACCEPTED:
                event(new CommercialPublished($commercial));
                break;
        }
        $this->doneMessage("آگهی $commercial->name آپدیت شد.");
        return redirect()->route('admin.commercials.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Commercial $commercial)
    {
        $commercial->delete();
        $this->doneMessage('آگهی با موفقیت حذف گردید.');
        return redirect()->route('admin.commercials.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function sms(Commercial $commercial)
    {
        return view('admin.commercials.sms', compact('commercial'));
    }

    /**
     * Send sms to someone.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commercial  $commercial
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request, Commercial $commercial)
    {
        $commercial->load('user');
        $message = $request->input('content');
        //Sms::send($message, $commercial->user->mobile);
        send_sms($commercial->user->mobile, $message);
        $this->doneMessage('پیام شما با موفقیت ارسال گردید.');
        return redirect()->route('admin.commercials.index');
    }
}
