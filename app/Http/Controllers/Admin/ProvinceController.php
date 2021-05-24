<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProvinceRequest;
use App\Models\Province;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class   ProvinceController extends Controller
{
    /**
     * ProvinceController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:provinces-create|provinces-edit|provinces-delete')->only('index');
        $this->middleware('permission:provinces-create')->only(['create', 'store']);
        $this->middleware('permission:provinces-edit')->only(['edit', 'update']);
        $this->middleware('permission:provinces-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.provinces.index');
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
        $provinces = Province::latest();
        return Datatables::of($provinces)
            ->setTotalRecords($provinces->count())
            ->addColumn('actions', function ($province) {
                return view('admin.provinces.partials.datatables.actions', compact('province'));
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    public function location(Request $request)
    {
        if(!$request->province) {
            $message = [
                'status'    => 'danger',
                'body'      => "استان را باید به درستی انتخاب کنید.",
            ];
            return response()->json($message);
        }

        $province = Province::find($request->province);
        if(!$province) {
            $message = [
                'status'    => 'danger',
                'body'      => "استانی که درخواست نموده‌اید، وجود ندارد..",
            ];
            return response()->json($message);
        }
        $message = [
            'status'        => 'success',
            'body'          => "نتایج با موفقیت یافت شدند.",
            'latitude'      => $province->latitude,
            'longitude'     => $province->longitude,
        ];
        return response()->json($message);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.provinces.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProvinceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProvinceRequest $request)
    {
        $province = Province::create($request->only(['name', 'code', 'latitude', 'longitude']));
        $this->doneMessage("استان $province->name اضافه شد.");
        return redirect()->route('admin.provinces.index');
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
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function edit(Province $province)
    {
        return view('admin.provinces.edit', compact('province'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProvinceRequest  $request
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function update(ProvinceRequest $request, Province $province)
    {
        $province->update($request->only(['name', 'code', 'latitude', 'longitude']));
        $this->doneMessage("استان $province->name آپدیت شد.");
        return redirect()->route('admin.provinces.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Province::destroy($id);
        $this->doneMessage('استان مورد نظر با موفقیت حذف شد.');
        return redirect()->route('admin.provinces.index');
    }
}
