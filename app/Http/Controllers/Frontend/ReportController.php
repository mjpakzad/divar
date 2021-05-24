<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Commercial;
use App\Models\Report;
use App\Models\ReportReasons;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless($request->ajax(), 404);
        $reason     = ReportReasons::find($request->reason);
        $commercial = Commercial::find($request->commercial);
        if(!$reason) {
            $message = [
                'status'    => 'danger',
                'body'      => "دلیل ارائه شده جهت گزارش معتبر نیست!",
            ];
            return response()->json($message);
        }
        if(!$commercial) {
            $message = [
                'status'    => 'danger',
                'body'      => "آگهی معتبر نیست!",
            ];
            return response()->json($message);
        }
        $reports_data['reason_id']      = $reason->id;
        $reports_data['commercial_id']  = $commercial->id;
        if(auth()->check()) {
            $reports_data['user_id'] = auth()->id();
        }
        if($reason->id == 9) {
            $reports_data['content'] = $request->input('content');
        }
        $report = Report::create($reports_data);
        $message = [
            'status'    => 'success',
            'body'      => "گزارش شما با موفقیت ثبت گردید. با تشکر از همکاری شما",
        ];
        return response()->json($message);
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
