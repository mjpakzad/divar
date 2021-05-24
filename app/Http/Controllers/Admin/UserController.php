<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Commercial;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;

class UserController extends Controller
{
    /**
     * CommercialController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:users-create')->only(['create', 'store']);
        $this->middleware('permission:users-edit')->only(['edit', 'update']);
        $this->middleware('permission:users-delete')->only('destroy');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }
    
    public function export()
    {
        return (new FastExcel(User::with('city')->get()))->download('users.xlsx', function ($user) {
            return [
                'first_name'    => $user->first_name,
                'last_name'     => $user->last_name,
                'email'         => $user->email,
                'mobile'        => $user->mobile,
                'phone'         => $user->phone,
                'occupation'    => $user->occupation,
                'city'          => $user->city->name ?? '',
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

        $users = User::withCount('commercials');
        return datatables()->of($users)
            ->setTotalRecords($users->count())
            ->addColumn('display_name', function ($user) {
                return $user->roles->first()->display_name ?? '';
            })
            ->addColumn('commercials_count', function($user) {
                return view('admin.users.partials.commercials_count', compact('user'));
            })
            ->addColumn('action', function ($user) {
                return view('admin.users.partials.actions', compact('user'));
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
        $roles  = Role::pluck('display_name', 'id');
        $cities = City::pluck('name', 'id');
        return view('admin.users.create', compact('roles', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $request->merge(['password' => bcrypt($request->input('password'))]);
        $user = User::create($request->only(['first_name', 'last_name', 'mobile', 'email', 'phone', 'city_id', 'occupation', 'password']));
        $user->roles()->sync([$request->input('role')]);
        $this->doneMessage("کاربر $user->name افزوده شد.");
        return redirect()->route('admin.users.index');
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
     * @param  User  $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('display_name', 'id');
        $cities = City::pluck('name', 'id');
        return view('admin.users.edit', compact('user', 'roles', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Models\User  user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $user_data = $request->only(['first_name', 'last_name', 'mobile', 'email', 'phone', 'city_id', 'occupation']);
        if($request->input('password')) {
            $user_data['password'] = bcrypt($request->input('password'));
        }
        $user->update($user_data);
        $user->roles()->sync([$request->input('role')]);
        $this->doneMessage("کاربر $user->name آپدیت شد.");
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        $this->doneMessage('کاربر مورد نظر با موفقیت حذف گردید.');
        return redirect()->route('admin.users.index');
    }
    
    public function list(Request $request)
    {
        if($request->input('searchTerm'))
        {
            $phrase = strtolower($request->input('searchTerm'));
            $users = User::where('mobile', 'LIKE', "%$phrase%")
                        ->orWhere('first_name', 'LIKE', "%$phrase%")
                        ->orWhere('last_name', 'LIKE', "%$phrase%")
                        ->latest()
                        ->take(10)
                        ->get();
        }
        else
        {
            $users = User::latest()->take(10)->get();
        }

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id'    => $user->id,
                'text'  => $user->name . ' (' . $user->mobile . ')',
            ];
        }

        return response()->json($data);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function commercials(User $user)
    {
         return view('admin.users.commercials', compact('user'));
    }
    
    /**
     * Proceeds ajax request for datatable.
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function commercialsAjax(Request $request, User $user)
    {
        abort_unless($request->ajax(), 404);

        $commercials = Commercial::with('user', 'registrar', 'city', 'district', 'category')->withCount(['clicks', 'views'])->where('user_id', $user->id)->withTrashed();
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
            ->rawColumns(['status', 'action', 'buy'])
            ->make(true);
    }
}
