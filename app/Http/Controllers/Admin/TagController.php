<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TagDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TagDataTable $dataTable)
    {
        return $dataTable->render('admin.page.tags.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.page.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:200'],
            'status' => ['required'],

        ]);

        $tags = new Tag();
        $tags->name = $request->name;
        $tags->slug = Str::slug($request->name);
        $tags->status = $request->status;
        $tags->save();

        toastr('Created Successfully!', 'success');
        return redirect()->route('admin.tags.index');
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
        $tags = Tag::query()->findOrFail($id);
        return view('admin.page.tags.edit', compact('tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tags = Tag::query()->findOrFail($id);
        $request->validate([
            'name' => ['required', 'max:200'],
            'status' => ['required'],
        ]);
        $tags->name = $request->name;
        $tags->status = $request->status;
        $tags->slug = Str::slug($request->name);
        $tags->save();

        toastr('Cập nhật thành công !', 'success');
        return redirect()->route('admin.tags.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tags = Tag::query()->findOrFail($id);
        $tags->delete();

        return response([
            'status' => 'success',
            'message' => 'Xóa thành công !',
        ]);
    }

    public function tagsChangeStatus(Request $request)
    {
        $tags = Tag::query()->findOrFail($request->id);
        $tags->status = $request->status == 'true' ? 1 : 0;
        $tags->save();
        return response([
            'message' => 'Cập nhật trạng thái thành công !',
        ]);
    }
    public function getActiveTags()
    {
        $tags = Tag::where('status', 1)->get();
        return view('client.footer', compact('tags'));
    }
}
