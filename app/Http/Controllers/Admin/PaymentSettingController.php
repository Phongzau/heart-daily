<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function index()
    {
        $vnpay = PaymentSetting::where('method', 'vnpay')->first();
        $cod = PaymentSetting::where('method', 'cod')->first();
        return view('admin.page.payment-settings.index', ['vnpay' => $vnpay, 'cod' => $cod]);
    }

    public function update(Request $request, $id)
    {
        $paymentSetting = PaymentSetting::query()->findOrFail($id);
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
