<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $slider = Banner::all();
        return view('client.page.home.home',compact('slider'));
    }
}
