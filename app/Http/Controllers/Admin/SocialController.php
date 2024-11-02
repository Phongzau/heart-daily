<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SocialDataTable;
use App\Http\Controllers\Controller;
use App\Models\Social;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SocialDataTable $dataTable)
    {
        return $dataTable->render('admin.page.socials.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.page.socials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'icon' => ['required', 'max:200'],
            'name' => ['required', 'max:200'],
            'url' => ['required', 'url'],
            'status' => ['required'],
        ]);
        $socials = new Social();
        $socials->icon = $request->icon;
        $socials->name = $request->name;
        $socials->url = $request->url;
        $socials->status = $request->status;
        $socials->save();
        toastr('Tạo thành công!', 'success');
        return redirect()->route('admin.socials.index');
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
        $socials = Social::query()->findOrFail($id);
        return view('admin.page.socials.edit', compact('socials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $socials = Social::query()->findOrFail($id);
        $request->validate([
            'icon' => ['required', 'not_in:empty'],
            'name' => ['required', 'max:200'],
            'url' => ['required', 'url'],
            'status' => ['required'],
        ]);

        $socials->icon = $request->icon;
        $socials->name = $request->name;
        $socials->url = $request->url;
        $socials->status = $request->status;
        $socials->save();
        toastr('Cập nhật thành công !', 'success');
        return redirect()->route('admin.socials.index'); //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $socials = Social::query()->findOrFail($id);
        $socials->delete();

        return response([
            'status' => 'success',
            'message' => 'Xóa thành công !'
        ]);
    }

    public function socialsChangeStatus(Request $request)
    {
        $socials = Social::query()->findOrFail($request->id);
        $socials->status = $request->status == 'true' ? 1 : 0;
        $socials->save();

        return response([
            'message' => 'Status has been updated',
        ]);
    }
}
