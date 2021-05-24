<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeGroups;
use App\Http\Requests\AttributeRequest;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $attributeGroups = AttributeGroups::latest('sort_order')->paginate();
        return view('admin.attributes.index', compact('attributeGroups'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\AttributeRequest  $request
     * @return Response
     */
    public function store(AttributeRequest $request)
    {
        $attributeGroup = AttributeGroups::create([
            'name'       => $request->input('group_name'),
            'sort_order' => $request->input('group_sort_order'),
        ]);

        if ($request->input('name')) {
            foreach ($request->input('name') as $key => $name) {
                if (is_null($name)) {
                    continue;
                }
                $attributes[] = [
                    'group_id'   => $attributeGroup->id,
                    'name'       => $name,
                    'sort_order' => $request->input('sort_order')[$key]
                ];
            }

            Attribute::insert($attributes);
        }
        $this->doneMessage("ویژگی $attributeGroup->name با موفقیت ایجاد گردید.");
        return redirect()->route('admin.attributes.index');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttributeGroups  $attributeGroup
     * @return Response
     */
    public function edit(AttributeGroups $attributeGroup)
    {
        return view('admin.attributes.edit', compact('attributeGroup'));
    }

    /**
     * Update the specified resource in storage.
     * @param  \App\Http\Requests\AttributeRequest  $request
     * @param  \App\Models\AttributeGroups  $attributeGroup
     * @return Response
     */
    public function update(UpdateAttribute $request, AttributeGroups $attributeGroup)
    {
        $attributeGroup->update([
            'name'          => $request->input('group_name'),
            'sort_order'    => $request->input('group_sort_order'),
        ]);

        // Updates old
        if($request->input('keep_attributes')) {
            foreach ($request->input('keep_attributes') as $id) {
                $attributeGroup->attributes()->where('id', $id)->update([
                    'sort_order'    => $request->input('sort_order')[$id],
                    'name'          => $request->input('name')[$id],
                ]);
            }
        }

        // Removes removed
        if ($request->input('keep_attributes')) {
            $old = array_diff(array_pluck($attributeGroup->attributes->toArray(), 'id'), $request->input('keep_attributes'));
        } else {
            $old = array_pluck($attributeGroup->attributes->toArray(), 'id');
        }
        $attributeGroup->attributes()->whereIn('id', $old)->delete();

        // Adds new
        $newAttribute = array_diff_key($request->input('name'), $request->input('keep_attributes') ?? []);
        if ($newAttribute) {
            $attributes = [];
            foreach ($newAttribute as $key => $name) {
                if (is_null($request->input('name')[$key])) {
                    continue;
                }
                $attributes[] = [
                    'group_id'      => $attributeGroup->id,
                    'name'          => $request->input('name')[$key],
                    'sort_order'    => $request->input('sort_order')[$key]
                ];
            }

            Attribute::insert($attributes);
        }
        $this->doneMessage("ویژگی‌ها با موفقیت آپدیت شدند.");
        return redirect()->route('admin.attributes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param integer $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $data = $request->all();
        $attributeGroup = AttributeGroups::findOrFail($id);
        if ( isset($data['delete'] ))
        {
            $attributeGroup->delete();
        }
        $this->doneMessage();
        return redirect()->route('admin.attributes.index');
    }
}
