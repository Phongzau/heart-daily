<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\LogoSetting;
use App\Models\SocicalLink;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;


class SettingController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $logoSetting = LogoSetting::query()->first();
        $generalSettings = GeneralSetting::query()->first();
        return view('admin.page.settings.index', compact('logoSetting', 'generalSettings'));
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

        $logoPath = $this->updateImage($request, 'logo',  $logoSetting?->logo ?? '', 'logo');
        $faviconPath = $this->updateImage($request, 'favicon', $logoSetting?->favicon ?? '', 'logo');
        $logofooterPath = $this->updateImage($request, 'logo_footer', $logoSetting?->logo_footer ?? '', 'logo');

        LogoSetting::query()->updateOrCreate(
            ['id' => 1],
            [
                'logo' => $logoPath,
                'favicon' => $faviconPath,
                'logo_footer' => $logofooterPath,

            ]
        );
        toastr('Cập nhật thành công !', 'success');

        return redirect()->back();
    }
    public function GeneralSettingUpdate(Request $request)
    {
        $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:20'],
            'contact_address' => ['required', 'string', 'max:255'],
            'map' => ['required', 'string'], // Giả sử map là một chuỗi
            'currency_name' => ['required', 'string', 'max:50'],
            'currency_icon' => ['required', 'string', 'max:255'],
        ]);

        // Cập nhật hoặc tạo mới bản ghi GeneralSetting
        GeneralSetting::query()->updateOrCreate(
            ['id' => 1], // Cập nhật theo ID
            [
                'site_name' => $request->input('site_name'),
                'contact_email' => $request->input('contact_email'),
                'contact_phone' => $request->input('contact_phone'),
                'contact_address' => $request->input('contact_address'),
                'map' => $request->input('map'), // Cập nhật trường map
                'currency_name' => $request->input('currency_name'),
                'currency_icon' => $request->input('currency_icon'),
            ]
        );

        toastr('Cập nhật thành công !', 'success');
        return redirect()->back();
    }
}
