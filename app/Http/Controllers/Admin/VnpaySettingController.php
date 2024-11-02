<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VnpaySetting;
use App\Models\PaypalSetting;
use Illuminate\Http\Request;

class VnpaySettingController  extends Controller
{
    public function index()
    {
        $vnpay = VnpaySetting::where('method', 'vnpay')->first();
        $cod = VnpaySetting::where('method', 'cod')->first();
        $paypal = PaypalSetting::where('method', 'paypal')->first();
        return view('admin.page.payment-settings.index', ['vnpay' => $vnpay, 'cod' => $cod, 'paypal' => $paypal]);
    }

    public function update(Request $request, $id)
    {
        $paymentSetting = VnpaySetting::query()->findOrFail($id);
        $request->validate([
            'status' => 'required|boolean',
            'vnp_tmncode' => 'nullable|string',
            'vnp_hashsecret' => 'nullable|string',
            'vnp_url' => 'nullable|url',
        ]);
        $paymentSetting->status = $request->status;
        $paymentSetting->name = $request->name;

        if ($paymentSetting->method === 'vnpay') {
            $paymentSetting->vnp_tmncode = $request->vnp_tmncode;
            $paymentSetting->vnp_hashsecret = $request->vnp_hashsecret;
            $paymentSetting->vnp_url = $request->vnp_url;
        }
        $paymentSetting->save();
        toastr('Cập nhật thành công', 'success');
        return redirect()->back();
    }
}
