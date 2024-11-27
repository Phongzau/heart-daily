<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SupplierDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class AdminSupplierController extends Controller
{
    public function index(SupplierDataTable $dataTable)
    {
        return $dataTable->render('admin.page.suppliers.index');
    }
    public function changeStatus(Request $request)
    {
        $supplier = Supplier::query()->findOrFail($request->id);
        $supplier->status = $request->status == 'true' ? 1 : 0;
        $supplier->save();

        return response([
            'message' => 'Cập nhật thành công Status',
        ]);
    }
    public function create()
    {
        return view('admin.page.suppliers.create');
    }
    public function store(StoreSupplierRequest $request)
    {
        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->status = $request->status;
        $supplier->save();
        toastr('Thêm nhà cung cấp thành công', 'success');
        return redirect()->route('admin.suppliers.index');
    }
    public function edit(string $id)
    {
        $supplier = Supplier::query()->findOrFail($id);
        return view('admin.page.suppliers.edit', compact('supplier'));
    }
    public function update(UpdateSupplierRequest $request, string $id)
    {
        $supplier = Supplier::query()->findOrFail($id);
    
        $supplier->name = $request->name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->status = $request->status;
        $supplier->save();

        toastr('Cập nhật nhà cung cấp thành công', 'success');
        return redirect()->route('admin.suppliers.index');
    }
    public function destroy(string $id)
    {
        $supplier = Supplier::query()->findOrFail($id);
        $supplier->delete();

        return response([
            'status' => 'success',
            'message' => 'Xóa thành công',
        ]);
    }
}
