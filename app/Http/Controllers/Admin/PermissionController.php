<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);
        $permissions        = Permission::all();
        $userPermissions    = $role->permissions->pluck('id')->toArray() ?? [];
        return view('admin.permissions.edit', compact('role', 'permissions', 'userPermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param   int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->permissions()->sync($request->permissions_id ?? []);
        $this->doneMessage('دسترسی‌های گروه کاربری با موفقیت آپدیت شدند.');
        return redirect()->route('admin.roles.index');
    }
}
