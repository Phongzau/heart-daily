<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\DataTables\MenuDataTable;
use App\Http\Requests\MenuRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMenuRequest;

class MenuController extends Controller
{
    public function index(MenuDataTable $dataTable){
        return $dataTable->render('admin.page.menus.index');
    }

    public function create(){
        return view('admin.page.menus.create');
    }

    public function store(MenuRequest $request){
        $menu = new Menu();
        $menu->title = $request->title;
        $menu->slug = Str::slug($request->title);
        $menu->status = $request->status;
        $menu->save();
        toastr('Tạo thành công', 'success');
        return redirect()->route('admin.menus.index');
    }

    public function edit($id){
        $menu = Menu::query()->findOrFail($id);
        return view('admin.page.menus.edit', compact('menu'));
    }

    public function update(UpdateMenuRequest $request, $id){
        $menu = Menu::query()->findOrFail($id);
        $menu->title = $request->title;
        $menu->slug = Str::slug($request->title);
        $menu->status = $request->status;
        $menu->save();
        toastr('Cập nhật thành công', 'success');
        return redirect()->route('admin.menus.index');
    }

    public function destroy($id)
    {
        $menu = Menu::query()->findOrFail($id);
        $menu->delete();

        return response([
            'status' => 'success',
            'message' => 'Xóa thành công !',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $menu = Menu::query()->findOrFail($request->id);
        $menu->status = $request->status == 'true' ? 1 : 0;
        $menu->save();

        return response([
            'message' => 'Cập nhật trạng thái thành công !',
        ]);
    }
}
