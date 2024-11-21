<?php

return [

    'order_status_admin' => [
        'pending' => [
            'status' => 'chưa xử lý',
            'details' => 'Your order is currently pending',
        ],
        'processed_and_ready_to_ship' => [
            'status' => 'Đã xử lý và sẵn sàng vận chuyển',
            'details' => 'Your package has been processed and will be with delivery parter soon',
        ],
        'dropped_off' => [
            'status' => 'Đã giao cho đơn vị vận chuyển',
            'details' => 'Your package has been dropped off by the seller'
        ],
        'shipped' => [
            'status' => 'Đã vận chuyển',
            'details' => 'Your package has arrived at our logistics facility',
        ],
        'delivered' => [
            'status' => 'Đã giao hàng',
            'details' => 'Đã giao hàng',
        ],
        'return' => [
            'status' => 'Hoàn hàng',
            'details' => 'Hoàn hàng',
        ],
        'canceled' => [
            'status' => 'Hủy bỏ',
            'details' => 'Hủy bỏ',
        ]
    ],
];
