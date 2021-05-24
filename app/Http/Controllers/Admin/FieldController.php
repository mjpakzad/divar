<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\FieldRequest;
use App\Models\Field;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fields = Field::latest()->paginate();
        return view('admin.fields.index', compact('fields'));
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

        $fields = Field::query();
        return datatables()->of($fields)
            ->setTotalRecords($fields->count())
            ->addColumn('action', function ($field) {
                return view('admin.fields.partials.actions', compact('field'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.fields.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\FieldRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FieldRequest $request)
    {
        $field_data = $request->only(['name', 'type', 'label', 'placeholder', 'sort_order', 'is_price', 'is_tag']);
        $field_data['buy']      = $request->input('buying') == 2 ? null : $request->input('buying');
        $field_data['rules']    = $request->input('rules') ?? [];
        $field_data['values']   = $request->input('values') ?? [];
        $field_data['options']  = $request->input('options') ?? [];
        $field_data['user_id']  = auth()->id();
        Field::create($field_data);
        $this->doneMessage('فیلد داینامیک با موفقیت ایجاد گردید.');
        return redirect()->route('admin.fields.index');
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
     * @param  \App\models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        return view('admin.fields.edit', compact('field'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Field $field)
    {
        $field_data = $request->only(['name', 'type', 'label', 'placeholder', 'sort_order', 'is_price', 'is_tag']);
        $field_data['buy']      = $request->input('buying') == 2 ? null : $request->input('buying');
        $field_data['rules']    = $request->input('rules') ?? [];
        $field_data['values']   = $request->input('values') ?? [];
        $field_data['options']  = $request->input('options') ?? [];
        $field->update($field_data);
        $this->doneMessage('فیلد داینامیک با موفقیت آپدیت گردید.');
        return redirect()->route('admin.fields.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Field::destroy($id);
        $this->doneMessage('فیلد داینامیک با موفقیت حذف گردید.');
        return redirect()->route('admin.fields.index');
    }
}
