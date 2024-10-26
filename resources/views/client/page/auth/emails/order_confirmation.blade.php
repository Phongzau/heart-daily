<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xác nhận đơn hàng</title>
</head>

<body>
    <h2>Order Confirmation</h2>
    <p>Xin chào,</p>
    <p>Cảm ơn bạn đã đặt hàng. Dưới đây là thông tin chi tiết về đơn hàng của bạn:</p>
    <ul>
        <li>Mã đơn hàng: {{ $order->invoice_id }}</li>
        <li>Tổng tiền: {{ number_format($order->amount) }} VND</li>
    </ul>

</body>

</html>
