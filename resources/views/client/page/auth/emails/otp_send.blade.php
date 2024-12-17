<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['title'] ?? 'Xác thực rút tiền' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .otp-code {
            display: block;
            font-size: 28px;
            font-weight: bold;
            color: #d9534f;
            text-align: center;
            margin: 20px 0;
        }

        .email-footer {
            font-size: 12px;
            color: #777;
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Xác thực rút tiền</h1>
        </div>

        <p>Chào <strong>{{ $data['name'] }}</strong>,</p>
        <p>Bạn vừa yêu cầu rút tiền từ tài khoản của mình tại <strong>{{ config('app.name') }}</strong>.</p>
        <p>Vui lòng sử dụng mã OTP dưới đây để xác thực yêu cầu rút tiền:</p>

        <div class="otp-code">{{ $data['otp'] }}</div>

        <p>Mã OTP có hiệu lực trong vòng <strong>90 giây</strong>. Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua
            email này hoặc liên hệ với chúng tôi để được hỗ trợ.</p>

        <p>Trân trọng,<br>
            Đội ngũ hỗ trợ {{ config('app.name') }}</p>

        <div class="email-footer">
            <p>Email này được gửi từ hệ thống tự động, vui lòng không trả lời trực tiếp.</p>
        </div>
    </div>
</body>

</html>
