<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CityRequest;
use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::latest('sort_order')->paginate();
        return view('admin.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        $request->merge(['meta_keywords' => dash2comma($request->meta_keywords)]);
        City::create($request->only('name', 'title', 'latitude', 'longitude', 'meta_keywords', 'meta_description', 'slug'));
        $this->doneMessage('شهر با موفقیت ایجاد گردید.');
        return redirect()->route('admin.cities.index');
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
     * @param  City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        return view('admin.cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CityRequest  $request
     * @param  City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(CityRequest $request, City $city)
    {
        $request->merge(['meta_keywords' => dash2comma($request->meta_keywords)]);
        $city->update($request->only('name', 'title', 'latitude', 'longitude', 'meta_keywords', 'meta_description', 'slug'));
        $this->doneMessage('شهر با موفقیت آپدیت شد.');
        return redirect()->route('admin.cities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();
        $this->doneMessage('شهر با موفقیت حذف گردید.');
        return redirect()->route('admin.cities.index');
    }

    public function hasDistrict(Request $request)
    {
        if(!$request->city) {
            $message = [
                'status'    => 'danger',
                'body'      => "شهر را باید به درستی انتخاب کنید.",
            ];
            return response()->json($message);
        }

        $city = City::find($request->city);
        if(!$city) {
            $message = [
                'status'    => 'danger',
                'body'      => "شهری که درخواست نموده‌اید، وجود ندارد..",
            ];
            return response()->json($message);
        }

        $hasDistrict = District::where('city_id', $city->id)->count();
        $message = [
            'status'        => 'success',
            'body'          => "نتایج با موفقیت یافت شدند.",
            'hasDistrict'   => $hasDistrict > 0 ? true : false,
            'latitude'      => $city->latitude,
            'longitude'     => $city->longitude,
        ];
        return response()->json($message);
    }
}
