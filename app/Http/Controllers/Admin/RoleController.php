<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * Hiển thị danh sách các vai trò trong bảng thông qua DataTable.
     */
    public function index(RoleDataTable $dataTable)
    {
        // Render trang danh sách các vai trò từ DataTable
        return $dataTable->render('admin.page.role.index');
    }

    /**
     * Show the form for creating a new resource.
     * Hiển thị form để tạo mới vai trò.
     */
    public function create()
    {
        // Trả về view tạo vai trò mới
        return view('admin.page.role.create');
    }

    /**
     * Store a newly created resource in storage.
     * Lưu vai trò mới vào cơ sở dữ liệu.
     */
    public function store(StoreRoleRequest $request)
    {
        // Tạo một đối tượng Role mới
        $role = new Role();
        // Gán giá trị từ request vào các thuộc tính của Role
        $role->name = $request->name;
        $role->description = $request->description;
        // Lưu vào cơ sở dữ liệu
        $role->save();

        // Gửi thông báo thành công và chuyển hướng về trang danh sách vai trò
        toastr('Tạo thành công', 'success');
        return redirect()->route('admin.roles.index');
    }

    /**
     * Display the specified resource.
     * Hiển thị thông tin chi tiết của một vai trò cụ thể.
     */
    public function show(string $id)
    {
        // Hàm này để trống, có thể thêm logic khi cần
    }

    /**
     * Show the form for editing the specified resource.
     * Hiển thị form để chỉnh sửa vai trò cụ thể.
     */
    public function edit(string $id)
    {
        // Tìm vai trò theo id, nếu không tìm thấy sẽ trả về lỗi
        $role = Role::query()->findOrFail($id);
        // Trả về view chỉnh sửa vai trò và truyền dữ liệu role vào view
        return view('admin.page.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     * Cập nhật thông tin vai trò trong cơ sở dữ liệu.
     */
    public function update(UpdateRoleRequest $request, string $id)
    {
        // Tìm vai trò theo id, nếu không tìm thấy sẽ trả về lỗi
        $role = Role::query()->findOrFail($id);
        // Cập nhật giá trị từ request vào các thuộc tính của Role
        $role->name = $request->name;
        $role->description = $request->description;
        // Lưu thay đổi vào cơ sở dữ liệu
        $role->save();

        // Gửi thông báo thành công và chuyển hướng về trang danh sách vai trò
        toastr('Sửa thành công', 'success');
        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     * Xóa vai trò khỏi cơ sở dữ liệu.
     */
    public function destroy(string $id)
    {
        // Tìm vai trò theo id, nếu không tìm thấy sẽ trả về lỗi
        $role = Role::query()->findOrFail($id);
        // Xóa vai trò khỏi cơ sở dữ liệu
        $role->delete();

        // Trả về phản hồi JSON báo thành công
        return response([
            'status' => 'success',
            'message' => 'Xóa thành công',
        ]);
    }
}
