<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AttributeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Models\Attribute;
use App\Models\CategoryAttribute;
use Illuminate\Http\Request;

class AdminAttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AttributeDataTable $dataTable)
    {
        return $dataTable->render('admin.page.attribute.index');
    }

    public function changeStatus(Request $request)
    {
        $attribute = Attribute::query()->findOrFail($request->id);
        $attribute->status = $request->status == 'true' ? 1 : 0;
        $attribute->save();

        return response([
            'message' => 'Cập nhật thành công Status',
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categoryAttributes = CategoryAttribute::all();
        return view('admin.page.attribute.create', compact('categoryAttributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeRequest $request)
    {
        $attribute = new Attribute();
        $attribute->title = $request->title;
        $attribute->slug = $request->slug;
        $attribute->category_attribute_id = $request->category_attribute_id;
        $attribute->price_start = $request->price_start;
        $attribute->price_end = $request->price_end;
        $attribute->status = $request->status;
        $attribute->userid_created = auth()->id(); 

        $attribute->save();

        toastr('Tạo thành công', 'success');
        return redirect()->route('admin.attributes.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);
        $categoryAttributes = CategoryAttribute::all(); 
        return view('admin.page.attribute.edit', compact('attribute', 'categoryAttributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeRequest $request, $id)
    {
        $attribute = Attribute::findOrFail($id);

        $attribute->title = $request->title;
        $attribute->slug = $request->slug;
        $attribute->category_attribute_id = $request->category_attribute_id;
        $attribute->price_start = $request->price_start;
        $attribute->price_end = $request->price_end;
        $attribute->status = $request->status;
        $attribute->userid_updated = auth()->id(); 

        $attribute->save();

        toastr('Sửa thành công', 'success');
        return redirect()->route('admin.attributes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);

        $attribute->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa thành công',
        ]);
    }
}
