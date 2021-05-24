<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Filter;
use App\Models\FilterGroup;
use App\Http\Requests\FilterRequest;

class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $filterGroups = FilterGroup::latest('sort_order')->paginate();
        return view('admin.filters.index', compact('filterGroups'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('admin.filters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\FilterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FilterRequest $request)
    {
        $filterGroup = FilterGroup::create([
            'name'       => $request->input('group_name'),
            'label'      => $request->input('group_label'),
            'sort_order' => $request->input('group_sort_order'),
        ]);

        if ($request->input('name')) {
            foreach ($request->input('name') as $key => $name) {
                if (is_null($name)) {
                    continue;
                }
                $filters[] = [
                    'filter_group_id'   => $filterGroup->id,
                    'name'              => $name,
                    'sort_order'        => $request->input('sort_order')[$key]
                ];
            }

            Filter::insert($filters);
        }

        $this->doneMessage("فیلتر $filterGroup->name با موفقیت ایجاد گردید.");
        return redirect()->route('admin.filters.index');
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
     * @param  \App\Models\FilterGroup  $filterGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(FilterGroup $filterGroup)
    {
        return view('admin.filters.edit', compact('filterGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\FilterRequest  $request
     * @param  \App\Models\FilterGroup  $filterGroup
     * @return \Illuminate\Http\Response
     */
    public function update(FilterRequest $request, FilterGroup $filterGroup)
    {
        $filterGroup->update([
            'name'          => $request->input('group_name'),
            'label'         => $request->input('group_label'),
            'sort_order'    => $request->input('group_sort_order'),
        ]);

        // Updates old
        if($request->input('keep_filters')) {
            foreach ($request->input('keep_filters') as $id) {
                $filterGroup->filters()->where('id', $id)->update([
                    'sort_order'    => $request->input('sort_order')[$id],
                    'name'          => $request->input('name')[$id],
                ]);
            }
        }

        // Removes removed
        if ($request->input('keep_filters')) {
            $old = array_diff(array_pluck($filterGroup->filters->toArray(), 'id'), $request->input('keep_filters'));
        } else {
            $old = array_pluck($filterGroup->filters->toArray(), 'id');
        }
        $filterGroup->filters()->whereIn('id', $old)->delete();

        // Adds new
        $newFilter = array_diff_key($request->input('name'), $request->input('keep_filters') ?? []);
        if ($newFilter) {
            $filters = [];
            foreach ($newFilter as $key => $name) {
                if (is_null($request->input('name')[$key])) {
                    continue;
                }
                $filters[] = [
                    'filter_group_id'   => $filterGroup->id,
                    'name'              => $request->input('name')[$key],
                    'sort_order'        => $request->input('sort_order')[$key]
                ];
            }

            Filter::insert($filters);
        }
        $this->doneMessage("فیلترها با موفقیت آپدیت شدند.");
        return redirect()->route('admin.filters.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  \App\Models\FilterGroup  $filterGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FilterGroup $filterGroup)
    {
        $data = $request->all();
        if (isset($data['delete']))
        {
            $filterGroup->delete();
        }
        $this->doneMessage();
        return redirect()->route('admin.filters.index');
    }
}
