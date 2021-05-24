<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('permission:categories-create')->only(['create', 'store']);
        $this->middleware('permission:categories-edit')->only(['edit', 'update']);
        $this->middleware('permission:categories-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.groups.index');
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

        $groups = Group::with('parent');
        return datatables()->of($groups)
            ->addColumn('parent', function ($group) {
                return view('admin.groups.partials.parent', compact('group'));
            })
            ->editColumn('status', function ($group) {
                return view('admin.groups.partials.status', compact('group'));
            })
            ->addColumn('action', function ($group) {
                return view('admin.groups.partials.action', compact('group'));
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents    = Group::pluck('name', 'id')->toArray();
        return view('admin.groups.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\GroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        $group_data  = $request->only(['name', 'slug', 'meta_description', 'parent_id']);
        $group_data['meta_keywords'] = dash2comma($request->input('meta_keywords'));
        $group_data['status']        = $request->input('status') ? Group::STATUS_PUBLISHED : Group::STATUS_DRAFT;
        $group = Group::create($group_data);
        $this->doneMessage("دسته‌بندی $group->name ایجاد شد.");
        return redirect()->route('admin.groups.index');
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
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $children                   = $group->children()->get()->toArray();
        $parents                    = Group::where('id', '<>', $group->id)->pluck('name','id')->toArray();
        $group->meta_keywords       = comma2dash($group->meta_keywords);
        return view('admin.groups.edit', compact('group', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\GroupRequest  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(GroupRequest $request, Group $group)
    {
        $group_data  = $request->only(['name', 'slug', 'meta_description', 'parent_id']);
        $group_data['meta_keywords'] = dash2comma($request->input('meta_keywords'));
        $group_data['status']        = $request->input('status') ? Group::STATUS_PUBLISHED : Group::STATUS_DRAFT;
        $group->update($group_data);
        $this->doneMessage("دسته‌بندی با موفقیت آپدیت شد.");
        return redirect()->route('admin.groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\GroupRequest  $request
     * @param  integer  $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        Group::delete();
        $this->doneMessage('دسته‌بندی با موفقیت حذف شد.');
        return redirect()->route('admin.groups.index');
    }
}
