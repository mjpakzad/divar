<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\PromoteRequest;
use App\Models\Commercial;
use App\Models\Invoice;
use App\Models\InvoiceServices;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromoteController extends Controller
{
    /**
     * PromoteController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $promote
     * @return \Illuminate\Http\Response
     */
    public function show($promote)
    {
        $commercial = Commercial::whereSlug($promote)->firstOrFail();
        $user = auth()->user();
        abort_if($commercial->user_id != $user->id, 403, 'شما تنها به آگهی‌های خود دسترسی دارید.');
        $services        = Service::pluck('price', 'id');
        $descriptions    = Service::pluck('description', 'id');
        return view('frontend.promotes.show', compact('commercial', 'services', 'descriptions'));
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
     * @param  \App\Http\Requests\PromoteRequest  $request
     * @param  string  $promote
     * @return \Illuminate\Http\Response
     */
    public function update(PromoteRequest $request, $promote)
    {
        $commercial = Commercial::whereSlug($promote)->firstOrFail();
        $user = auth()->user();
        abort_if($commercial->user_id != $user->id, 403, 'شما تنها به آگهی‌های خود دسترسی دارید.');
        $services = Service::all();
        $total_price = 0;
        $invoice_services = [];
        $services_count = $services->count();
        for ($iteration = 1; $iteration <= $services_count; $iteration++) {
            $service_list = [1 => 'ladder', 'featured', 'renewal', 'reportage'];
            if($request->input($service_list[$iteration])) {
                $service = $services->find($iteration);
                $total_price += $service->price;
                $service_data = [
                    'service_id'    => $service->id,
                    'service_name'  => $service->name,
                    'field'         => $service->field,
                    'price'         => $service->price,
                ];
                $invoice_services[] = new InvoiceServices($service_data);
            }
        }
        $invoice_data = [
            'user_id'       => auth()->id(),
            'commercial_id' => $commercial->id,
            'price'         => $total_price,
            'status'        => Invoice::STATUS_ACTIVE,
        ];
        $invoice = Invoice::create($invoice_data);
        $invoice->services()->saveMany($invoice_services);
        return redirect()->route('frontend.payments.request', $invoice->id);
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
