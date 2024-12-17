<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\WithdrawRequestDataTable;
use App\Http\Controllers\Controller;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;

class WithdrawRequestController extends Controller
{
    public function index(WithdrawRequestDataTable $dataTable)
    {
        return $dataTable->render('admin.page.withdraw.index');
    }

    public function show(string $id)
    {
        $withdrawRequest = WithdrawRequest::query()->find($id);
        return view('admin.page.withdraw.show', compact('withdrawRequest'));
    }

    public function changeWithdrawStatus(Request $request)
    {
        $request->validate([
            'status' => ['required', 'in:processing,complete,rejected'],
        ], [
            'status.required' => 'Trạng thái không được để trống.',
        ]);

        $withdrawRequest = WithdrawRequest::find($request->id);
        if ($withdrawRequest) {
            if ($withdrawRequest->status == 'rejected' || $withdrawRequest->status == 'complete') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Chuyển trạng thái thất bại đơn hàng đang ở trạng thái khác không chuyển được',
                ]);
            }
            $withdrawRequest->status = $request->status;
            $withdrawRequest->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Chuyển trạng thái thành công',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Đơn rút không tồn tại',
            ]);
        }
    }
}
