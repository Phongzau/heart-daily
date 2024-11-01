<?php

return [

    'order_status_admin' => [
        'pending' => [
            'status' => 'Pending',
            'details' => 'Your order is currently pending',
        ],
        'processed_and_ready_to_ship' => [
            'status' => 'Processed and ready to ship',
            'details' => 'Your package has been processed and will be with delivery parter soon',
        ],
        'dropped_off' => [
            'status' => 'Dropped Off',
            'details' => 'Your package has been dropped off by the seller'
        ],
        'shipped' => [
            'status' => 'Shipped',
            'details' => 'Your package has arrived at our logistics facility',
        ],
        'delivered' => [
            'status' => 'Delivered',
            'details' => 'Delivered',
        ],
        'canceled' => [
            'status' => 'Canceled',
            'details' => 'Canceled',
        ]
    ],
];
