<?php

namespace App\Http\Controllers\Admin;

use App\Models\ReportReasons;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportReasonController extends Controller
{
    /**
     * ReportReasonController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:reports-reasons');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reasons = ReportReasons::latest()->paginate();
        return view('admin.reports.reasons.index', compact('reasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.reports.reasons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reason = ReportReasons::create($request->only('title'));
        $this->doneMessage('دلیل گزارش با موفقیت ذخیره شد.');
        return redirect()->route('admin.reports.reasons.index');
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
     * @param  \App\Models\ReportReasons  $reason
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportReasons $reason)
    {
        return view('admin.reports.reasons.edit', compact('reason'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReportReasons  $reason
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportReasons $reason)
    {
        $request->update($request->only('title'));
        $this->doneMessage('دلیل گزارش با موفقیت آپدیت شد.');
        return  redirect()->route('admin.reports.reasons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ReportReasons::destroy($id);
        $this->doneMessage('دلیل گزارش با موفقیت حذف گردید.');
        return redirect()->route('admin.reports.reasons.index');
    }
}
