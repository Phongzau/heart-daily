<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class AdminColorController extends Controller
{
    public function index()
    {
        $colors = Color::all(); // Lấy danh sách tất cả colors
        return view('admin.page.colors.index', compact('colors')); // Hiển thị view index
    }

    public function create()
    {
        return view('admin.page.colors.create'); // Hiển thị form tạo mới
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:colors,slug',
        ]);

        Color::create($request->all()); // Lưu màu sắc mới vào database

        return redirect()->route('admin.colors.index')->with('success', 'Color created successfully.');
    }

   

    public function edit(Color $color)
    {
        return view('admin.page.colors.edit', compact('color')); // Hiển thị form chỉnh sửa
    }

    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:colors,slug,' . $color->id,
        ]);

        $color->update($request->all()); // Cập nhật thông tin color

        return redirect()->route('admin.colors.index')->with('success', 'Color updated successfully.');
    }

    public function destroy(Color $color)
    {
        $color->delete(); // Xóa color

        return redirect()->route('admin.colors.index')->with('success', 'Color deleted successfully.');
    }
}
