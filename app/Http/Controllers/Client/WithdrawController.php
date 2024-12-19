<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OtpVerifyWithdraw;
use App\Models\OtpRequest;
use App\Models\User;
use App\Models\WithdrawRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PragmaRX\Google2FA\Google2FA;

class WithdrawController extends Controller
{
    public function sendOtp(Request $request)
    {
        $withdrawReq = WithdrawRequest::query()
            ->where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->count();
        if ($withdrawReq >= 2) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không được rút điểm quá 2 lần 1 ngày',
            ]);
        }
        $otpData = OtpRequest::where('email', Auth::user()->email)->first();
        if ($otpData) {
            $otp_sent_at = Carbon::parse($otpData->otp_send_at);
            $expiration_time = 90;

            if ($otp_sent_at->diffInSeconds(now()) > $expiration_time) {

                $otp = rand(100000, 999999);
                $email = Auth::user()->email;

                OtpRequest::updateOrCreate(
                    ['email' => $email],
                    [
                        'otp' => $otp,
                        'otp_send_at' => now(),
                    ],
                );

                $data['name'] = Auth::user()->name;
                $data['email'] = $email;
                $data['title'] = 'Mã OTP để xác thực rút tiền!';
                $data['otp'] = $otp;

                try {
                    Mail::to($data['email'])->send(new OtpVerifyWithdraw($data));

                    return response()->json([
                        'status' => 'success',
                        'message' => 'OTP đã được gửi thành công',
                        'start' => true,
                    ]);
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Gửi OTP thất bại: ' . $e->getMessage(),
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Mời bạn nhập OTP',
                    'start' => false,
                ]);
            }
        } else {
            $otp = rand(100000, 999999);
            $email = Auth::user()->email;

            OtpRequest::updateOrCreate(
                ['email' => $email],
                [
                    'otp' => $otp,
                    'otp_send_at' => now(),
                ],
            );

            $data['name'] = Auth::user()->name;
            $data['email'] = $email;
            $data['title'] = 'Mã OTP để xác thực rút tiền!';
            $data['otp'] = $otp;

            try {
                Mail::to($data['email'])->send(new OtpVerifyWithdraw($data));

                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP đã được gửi thành công',
                    'start' => true,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gửi OTP thất bại: ' . $e->getMessage(),
                ]);
            }
        }
    }

    public function verify2FA(Request $request)
    {
        $user = Auth::user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey(auth()->user()->google2fa_secret, $request->input('google2faCode'));

        if ($valid) {
            return response()->json([
                'status' => 'success',
                'message' => 'Mã 2FA hợp lệ!',
            ]);
        }
        return response()->json(['status' => 'error','message' => 'Mã 2FA không hợp lệ!',]);
    }

    public function reSendOtp()
    {
        $otpData = OtpRequest::where('email', Auth::user()->email)->first();

        if ($otpData) {
            $otp_sent_at = Carbon::parse($otpData->otp_send_at);
            $expiration_time = 90;

            if ($otp_sent_at->diffInSeconds(now()) > $expiration_time) {
                $this->sendOtp();
                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP đã được gửi',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Làm ơn thử lại sau một khoảng thời gian',
                ]);
            }
        }
    }

    public function verifyOtp(Request $request)
    {
        $otpData = OtpRequest::where('email', Auth::user()->email)->first();
        if ($otpData) {
            if ($otpData->otp == $request->otpCode) {
                $otp_sent_at = Carbon::parse($otpData->otp_send_at);
                $expiration_time = 90;

                if ($otp_sent_at->diffInSeconds(now()) > $expiration_time) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Mã OTP đã quá hạn',
                    ]);
                } else {

                    $user = User::query()->find(Auth::user()->id);

                    if (!$user) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Có lỗi xảy ra',
                        ]);
                    }
                    if ($request->point < 100000) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Số điểm tối thiểu 100.000đ',
                        ]);
                    } else if ($request->point > 1000000) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Số điểm tối đa 1.000.000đ',
                        ]);
                    }
                    if ($request->point > $user->point) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Số điểm vượt quá số điểm hiện có',
                        ]);
                    }


                    $otpData->delete();

                    WithdrawRequest::create([
                        'user_id' => Auth::user()->id,
                        'point' => $request->point,
                        'equivalent_money' => $request->point,
                        'bank_name' => $request->bankName,
                        'final_balance' => Auth::user()->point - $request->point,
                        'account_name' => $request->accountName,
                        'bank_account' => $request->bankAccount,
                        'status' => 'processing',
                    ]);

                    if ($user) {
                        $user->point -= $request->point;
                        $user->save();
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Bạn đã tạo lệnh rút thành công',
                            'point_current' => number_format($user->point),
                            'point' => $user->point,
                        ]);
                    }

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Bạn đã tạo lệnh rút thành công',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mã OTP không chính xác',
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy yêu cầu OTP cho email này',
            ]);
        }
    }

    public function getHistoryWithdraw()
    {
        $withDraws = WithdrawRequest::query()
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $updatedOrderHtml = view('client.page.dashboard.sections.history-withdraw', compact('withDraws'))->render();


        return response()->json([
            'status' => 'success',
            'updatedOrderHtml' => $updatedOrderHtml,
        ]);
    }

    public function withdrawDetail(Request $request)
    {
        $withDraw = WithdrawRequest::query()->find($request->withDrawId);
        if ($withDraw) {
            $withDraw->withdrawAmount = number_format($withDraw->equivalent_money);
            $withDraw->requestTime = $withDraw->created_at->format('d/m/Y H:i');
            return response()->json([
                'status' => 'success',
                'withDraw' => $withDraw,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không có đơn rút này',
            ]);
        }
    }
}
