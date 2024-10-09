<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogoSetting;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;


class SettingController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $logoSetting = LogoSetting::query()->first();
        return view('admin.page.settings.index', compact('logoSetting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function logoSettingUpdate(Request $request)
    {
        $logoSetting = LogoSetting::query()->first();
        $request->validate([
            'logo' => ['image', 'max:3000'],
            'favicon' => ['image', 'max:3000'],
            'logo_footer' => ['image', 'max:3000'],
        ]);

        $logoPath = $this->updateImage($request, 'logo',  $logoSetting?->logo, 'logo');
        $faviconPath = $this->updateImage($request, 'favicon', $logoSetting?->favicon, 'logo');
        $logofooterPath = $this->updateImage($request, 'logo_footer', $logoSetting?->logo_footer, 'logo');

        LogoSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'logo' => $logoPath,
                'favicon' => $faviconPath,
                'logo_footer' => $logofooterPath,

            ]
        );
        toastr('Updated Successfully!', 'success');

        return redirect()->back();
    }
}
