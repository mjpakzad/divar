<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CommercialRequest;
use App\Models\City;
use App\Models\Commercial;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypeController extends Controller
{
    /**
     * CommercialController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:commercials-create')->only(['create', 'store']);
        $this->middleware('permission:commercials-edit')->only(['edit', 'update']);
        $this->middleware('permission:commercials-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('admin.app.index');
        return view('admin.types.index', compact('type'));
    }

    /**
     * Proceeds ajax request for datatable.
     *
     * @param Request $request
     * @param  \App\Models\Type  $type
     * @return mixed
     * @throws \Exception
     */
    public function ajax(Request $request, Type $type)
    {
        abort_unless($request->ajax(), 404);
        $commercials = Commercial::with('user', 'city', 'district')
                        ->whereTypeId($type->id)
                        ->join('users', 'commercials.user_id', '=', 'users.id');
        return datatables()->of($commercials)
            ->addColumn('mobile', function ($commercial) {
                return $commercial->user->mobile;
            })
            ->addColumn('city', function ($commercial) {
                return $commercial->city->name;
            })
            ->addColumn('district', function ($commercial) {
                return $commercial->district->name ?? '';
            })
            ->editColumn('laddered_at', function ($commercial) {
                return is_null($commercial->laddered_at) ? '' : jdate($commercial->laddered_at)->format('d F Y ساعت H:i');
            })
            ->editColumn('featured_at', function ($commercial) {
                return is_null($commercial->laddered_at) ? '' : jdate($commercial->featured_at)->format('d F Y ساعت H:i');
            })
            ->editColumn('status', function ($commercial) {
                return view('admin.types.partials.status', compact('commercial'));
            })
            ->addColumn('action', function ($commercial) {
                return view('admin.types.partials.actions', compact('commercial'));
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
    public function create(Type $type)
    {
        $cities     = City::pluck('name', 'id')->toArray();
        $categories = $type->categories()->pluck('name', 'id')->toArray();
        return view('admin.types.create', compact('type', 'cities', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CommercialRequest  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function store(CommercialRequest $request, Type $type)
    {
        $commercial_data = $request->only(['title', 'slug', 'content', 'meta_description', 'status']);
        $commercial_data['user_id']         = $request->input('user_id', auth()->id());
        $commercial_data['slug']            = make_slug($request->input('title'));
        $commercial_data['category_id']     = $request->input('category');
        $commercial_data['city_id']         = $request->input('city');
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
        $commercial = $type->commercials()->create($commercial_data);
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
        return redirect()->route('admin.types.show', $type->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        return view('admin.types.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
