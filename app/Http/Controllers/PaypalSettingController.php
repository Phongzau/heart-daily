<?php

namespace App\Http\Controllers;

use App\Models\PaypalSetting;
use Illuminate\Http\Request;

class PaypalSettingController extends Controller
{
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => ['required', 'boolean'],
            'mode' => ['required', 'boolean'],
            'currency_name' => ['required', 'string', 'max:200'],
            'currency_rate' => ['required', 'numeric'],  // Sửa đổi ở đây
            'client_id' => ['required', 'string'],
            'secret_key' => ['required', 'string'],
        ]);

        PaypalSetting::updateOrCreate(
            ['id' => $id],
            [
                'status' => $request->status,
                'mode' => $request->mode,
                'currency_name' => $request->currency_name,
                'currency_rate' =>  $request->currency_rate,
                'client_id' => $request->client_id,
                'secret_key' => $request->secret_key,
            ]
        );

        toastr('Cập nhật thành công', 'success');
        return redirect()->back();
    }
}
