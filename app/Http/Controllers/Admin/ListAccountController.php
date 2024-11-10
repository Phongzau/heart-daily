<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ListAccountDataTable;
use App\Http\Controllers\Controller;
// use App\Models\Role;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class ListAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ListAccountDataTable $dataTable)
    {
        return $dataTable->render("admin.page.accounts.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
   {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $listAccounts = User::query()->findOrFail($id);
        $role = Role::query()->get();

        return view('admin.page.accounts.edit', compact('listAccounts','role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $listAccounts = User::query()->findOrFail($id);
        
        $listAccounts->name = $request->name;
        $listAccounts->email = $request->email;
        $listAccounts->role_id = $request->role_id;
        $listAccounts->status = $request->status;
        $listAccounts->save();
        $role = Role::query()->findOrFail($request->role_id);
        $listAccounts->syncRoles([$role->name]);

        toastr('Cập nhật thành công!', 'success');
        return redirect()->route('admin.accounts.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $listAccounts = User::query()->findOrFail($id);
        $listAccounts->syncRoles([]);
        $listAccounts->delete();

        return response([
            'status' => 'success',
            'message' => 'Xóa thành công !',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $admin = User::query()->findOrFail($request->id);
        $admin->status = $request->status == 'true' ? 1 : 0;
        $admin->save();

        return response([
            'message' => 'Cập nhật trạng thái thành công !',
        ]);
    }
}
