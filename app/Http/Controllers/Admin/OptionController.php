<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OptionRequest;
use App\Models\Image;
use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class OptionController extends Controller
{
    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:options-create')->only(['create', 'store']);
        $this->middleware('permission:options-edit')->only(['edit', 'update']);
        $this->middleware('permission:options-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = Option::latest()->paginate();
        return view('admin.options.index', compact('options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.options.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryRequest  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function store(OptionRequest $request)
    {
        $option = Option::create([
            'name'          => $request->input('option_name'),
            'sort_order'    => $request->input('option_sort_order'),
        ]);
        if ($request->input('name')) {
            foreach ($request->input('name') as $key => $name) {
                if (is_null($name)) {
                    continue;
                }
                $optionValues[$key] = [
                    'option_id'     => $option->id,
                    'name'          => $name,
                    'sort_order'    => $request->input('sort_order')[$key],
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
                if($request->hasFile('image'))
                {
                    $name = Str::random(64);
                    $date = date('Y/m');
                    if($request->image->storeAs('public/images/options/' . date('Y/m'), $name . '.' . $request->image->extension()))
                    {
                        $image = Image::create([
                            'user_id'   => auth()->id(),
                            'name'      => 'storage/images/options/' . $date . '/' . $name . '.' . $request->image->extension(),
                        ]);
                        $optionValues[$key]['image_id'] = $image->id;
                    }
                }
            }

            OptionValue::insert($optionValues);
        }
        $this->doneMessage("گزینه $option->name با موفقیت ایجاد گردید.");
        return redirect()->route('admin.options.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function edit(Option $option)
    {
        $option = $option->load('values');
        return view('admin.options.edit', compact('option'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OptionRequest  $request
     * @param  \App\Models\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function update(OptionRequest $request, Option $option)
    {
        $option->update([
            'name'          => $request->input('option_name'),
            'sort_order'    => $request->input('option_sort_order'),
        ]);
        // Updates old
        if($request->input('keep_options')) {
            foreach ($request->input('keep_options') as $id) {
                $optionValues = [
                    'sort_order'    => $request->input('sort_order')[$id],
                    'name'          => $request->input('name')[$id],
                ];
                if($request->hasfile('image.' . $id))
                {
                    $image = $request->file('image.' . $id);
                    $date = date('Y/m');
                    $name = Str::random(64);
                    if($image->storeAs('public/images/options/' . $date, $name . '.' . $image->extension()))
                    {
                        $image = Image::create([
                            'user_id'   => auth()->id(),
                            'name'      => 'storage/images/options/' . date('Y/m') . '/' . $name . '.' . $request->image->extension(),
                        ]);
                        $optionValues['image_id'] = $image->id;
                    }
                }
                $option->values()->where('id', $id)->update($optionValues);
            }
        }

        // Removes removed
        if ($request->input('keep_options')) {
            $old = array_diff(array_pluck($option->values->toArray(), 'id'), $request->input('keep_options') ?? []);
        } else {
            $old = array_pluck($option->values->toArray(), 'id');
        }
        $option->values()->whereIn('id', $old)->delete();

        // Adds new
        $newOption = array_diff_key($request->input('name'), $request->input('keep_options') ?? []);
        if ($newOption) {
            $options = [];
            foreach ($newOption as $key => $name) {
                if (is_null($name)) {
                    continue;
                }
                $values[$key] = [
                    'option_id'     => $option->id,
                    'name'          => $name,
                    'sort_order'    => $request->input('sort_order')[$key]
                ];
                if($request->hasfile('image.' . $key))
                {
                    $image = $request->file('image.' . $key);
                    $date = date('Y/m');
                    $name = Str::random(64);
                    if($image->storeAs('public/images/options/' . $date, $name . '.' . $image->extension()))
                    {
                        $image = Image::create([
                            'user_id'   => auth()->id(),
                            'name'      => 'storage/images/options/' . date('Y/m') . '/' . $name . '.' . $request->image->extension(),
                        ]);
                        $values[$key]['image_id'] = $image->id;
                    }
                }
            }
            OptionValue::insert($values);
        }
        $this->doneMessage("گزینه $option->name با موفقیت آپدیت شدند.");
        return redirect()->route('admin.options.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        Option::destroy($id);
        $this->doneMessage('گزینه با موفقیت حذف شد.');
        return redirect()->route('admin.options.index');
    }
}
