<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đăng ký tài khoản</title>
</head>

<body>
    <h1>Chào {{ $user->name }},</h1>
    <p>Cảm ơn bạn đã đăng ký tài khoản tại <strong>{{ config('mail.from.name') }}</strong>.</p>
    <p>Vui lòng nhấn vào liên kết dưới đây để xác nhận tài khoản của bạn:</p>
    <p><a href="{{ $confirmationLink }}" class="btn btn-primary">Xác nhận tài khoản</a></p>
    <p>Nếu bạn không đăng ký tài khoản, vui lòng bỏ qua email này.</p>
    <br>
    <p>Trân trọng,<br>{{ config('app.name') }}</p>
</body>

</html>
