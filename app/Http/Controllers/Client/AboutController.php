<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index(Request $request)
    {
        $about = About::query()->first();

        if (!$about) {
            return view('client.page.about')->with('error', 'No about data found.');
        }

        return view('client.page.about', compact('about'));
    }
}
