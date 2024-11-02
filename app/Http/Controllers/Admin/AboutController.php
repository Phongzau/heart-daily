<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//use App\DataTables\AboutDataTable;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\About;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::query()->first();
        return view('admin.page.abouts.index',compact("about"));
    }


    public function update(Request $request)
    {
        $request->validate([
            'content' => ['required'],
        ]);

        About::updateOrCreate(
            ['id' => 1],
            [
                'content' => $request->content,
            ],
        );

        toastr('Cập nhật thành công', 'success');

        return redirect()->back();
    }


}
