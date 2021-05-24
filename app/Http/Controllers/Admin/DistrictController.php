<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DistrictRequest;
use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function index(City $city)
    {
        $districts = District::whereCityId($city->id)->paginate();
        return view('admin.districts.index', compact('city', 'districts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function create(City $city)
    {
        return view('admin.districts.create', compact('city'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DistrictRequest  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function store(DistrictRequest $request, City $city)
    {
        $city->districts()->create($request->only(['name', 'sort_order']));
        $this->doneMessage('محله با موفقیت اضافه گردید.');
        return redirect()->route('admin.cities.districts.index', compact('city'));
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
     * @param  \App\Models\City  $city
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city, District $district)
    {
        return view('admin.districts.edit', compact('city', 'district'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DistrictRequest  $request
     * @param  City  $city
     * @param  District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(DistrictRequest $request, City $city, District $district)
    {
        $district->update($request->only(['name', 'sort_order']));
        $this->doneMessage('محله با موفقیت آپدیت گردید.');
        return redirect()->route('admin.cities.districts.index', compact('city'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @param  District  $district
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(City $city, District $district)
    {
        $district->delete();
        $this->doneMessage('محله با موفقیت حذف گردید.');
        return redirect()->route('admin.cities.districts.index', compact('city'));
    }
}
