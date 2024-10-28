<?php

namespace App\Http\Controllers;

use App\Models\PaypalSetting;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    public function index()
    {
        $paypalSetting = PaypalSetting::query()->firstOrFail();
        return view('admin.page.payment-settings-backup.index', compact('paypalSetting'));
    }
}
