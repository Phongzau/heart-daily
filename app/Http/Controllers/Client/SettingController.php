<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\LogoSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $logoSetting = LogoSetting::query()->first();

        return view('client.component.header-middle', compact('logoSetting'));
    }
}
