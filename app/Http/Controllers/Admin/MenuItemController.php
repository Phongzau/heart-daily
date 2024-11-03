<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MenuItemDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MenuItemDataTable $dataTable)
    {
        return $dataTable->render('admin.page.menu_items.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menuItems = MenuItem::query()->get();
        $menu = Menu::query()->where('status', 1)->get();
        $maxOrderChild = MenuItem::query()
            ->where('parent_id', 0)
            ->orderBy('order', 'desc')
            ->first();
        // $maxOrder = $maxOrderChild->order + 1;
        $maxOrder = $maxOrderChild ? $maxOrderChild->order + 1 : 0;
        return view('admin.page.menu_items.create', compact(['menu', 'maxOrderChild', 'maxOrder', 'menuItems']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuItemRequest $request)
    {
        // dd($request->all());

        // Kiểm tra giá trị order có tồn tại trong cùng danh mục cha không
        if (MenuItem::where('order', $request->order)
            ->where('parent_id', $request->parent_id)
            ->exists()
        ) {
            toastr('Giá trị order đã tồn tại trong danh mục cha!', 'error');
            return redirect()->back()->withInput();
        }
     
        // Tạo mới MenuItem
    $menuItems = new MenuItem();
    // Lưu các giá trị vào database
    $menuItems->title = $request->title;
    $menuItems->url = $request->url; // Lưu URL đầy đủ
    $menuItems->parent_id = $request->parent_id;
    $menuItems->order = $request->order;
    $menuItems->slug = Str::slug($request->title);
    $menuItems->menu_id = $request->menu_id;
    $menuItems->status = $request->status;
    $menuItems->userid_created = $request->userid_created;
    $menuItems->userid_updated = $request->userid_updated;

    // Lưu đối tượng
    $menuItems->save();

        toastr('Tạo mới thành công!', 'success');
        return redirect()->route('admin.menu_items.index');
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
        $menuItems = MenuItem::query()->findOrFail($id);
        $menu = Menu::query()->where('status', 1)->get();
        $menuItemAll = MenuItem::query()
            ->where('id', '!=', $id)
            ->where('parent_id', '!=', $id)->get();

        return view('admin.page.menu_items.edit', compact('menuItems', 'menu', 'menuItemAll'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuItemRequest $request, string $id)
    {
        $menuItems = MenuItem::query()->findOrFail($id);

        // Chỉ kiểm tra khi parent_id thay đổi
        if ($request->parent_id != $menuItems->parent_id) {
            if (MenuItem::where('parent_id', '=', $id)->first()) {
                toastr('Danh mục này đã có danh mục con!', 'error');
                return redirect()->back()->withInput();
            }
        }

        if (MenuItem::where('order', $request->order)
            ->where('parent_id', $request->parent_id)
            ->where('id', '!=', $menuItems->id) // Loại bỏ bản ghi hiện tại ra khỏi điều kiện
            ->exists()
        ) {
            toastr('Giá trị order đã tồn tại trong danh mục cha!', 'error');
            return redirect()->back()->withInput();
        }

        $menuItems->title = $request->title;
        $menuItems->url = $request->url; // Lưu URL đầy đủ
        $menuItems->parent_id = $request->parent_id;
        $menuItems->order = $request->order;
        $menuItems->slug = Str::slug($request->title);
        $menuItems->menu_id = $request->menu_id;
        $menuItems->status = $request->status;
        $menuItems->userid_created = $request->userid_created;
        $menuItems->userid_updated = $request->userid_updated;

        // $menuItems->userid_created = Auth::user()->id;
        // $menuItems->userid_updated = Auth::user()->id;

        $menuItems->save();

        toastr('Tạo mới thành công!', 'success');
        return redirect()->route('admin.menu_items.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menuItems = MenuItem::query()->findOrFail($id);
        $check = MenuItem::where('parent_id', '=', $id)->first();
        // Xóa danh mục
        if ($check) {
            return response([
                'status' => 'error',
                'message' => 'Danh mục con đang tồn tại xóa danh mục con trước khi xóa danh mục cha',
            ]);
        } else {
            $menuItems->delete();
            return response([
                'status' => 'success',
                'message' => 'Xóa thành công',
            ]);
        }
    }

    public function changeStatus(Request $request)
    {
        $menuItem = MenuItem::query()->findOrFail($request->id);
        $menuItem->status = $request->status == 'true' ? 1 : 0;
        // Khởi tạo mảng idArray để đảm bảo luôn tồn tại
        $idArray = [];
        if ($request->status == 'false') {
            $menuItems = MenuItem::where('parent_id', '=', $menuItem->id)->get();

            foreach ($menuItems as $value) {
                $idArray[] = $value->id;
                $value->status = $request->status == 'true' ? 1 : 0;
                $value->save();
            }
        }
        $menuItem->save();

        return response([
            'message' => 'Cập nhật trạng thái thành công !',
            'id_array' => $idArray,
        ]);
    }

    public function getParentMenuItems(Request $request)
    {

        if ($request->id == 0) {
            $menuItems = MenuItem::query()
                ->where('parent_id', 0)
                ->orderBy('order', 'desc')
                ->first();
            return $menuItems;
        }
        $menuItems = MenuItem::query()->findOrFail($request->id);
        $maxOrderChild = MenuItem::query()
            ->where('parent_id', $menuItems->id)
            ->orderBy('order', 'desc')
            ->first();
        return response([
            'order' => $maxOrderChild ? $maxOrderChild->order : null,
        ]);
    }
}
