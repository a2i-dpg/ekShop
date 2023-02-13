<?php

use Illuminate\Support\Facades\Session;

return [
    'card' => [
        'header' => [
            'title' => 'Select Box',
            'sub-title' => 'Box List ' . (Session::has('box_size') ? '- Size(:size)' : '')
        ],
    ],
    'tabs' => [
        'all' => 'All',
        'small' => 'Small',
        'medium' => 'Medium',
        'large' => 'Large'
    ],
    'legend' => [
        'booked' => 'Booked',
        'maintenance' => 'Maintenance',
        'available' => 'Available'
    ],
    'modal' => [
        'details' => [
            'title' => 'Box Details',
            'label1' => 'Number: ',
            'label2' => 'Size: ',
            'label3' => 'Status: ',
        ],
        'button' => [
            'submit' => 'Start Booking'
        ]
    ],
    'button' => [
        'logout' => 'Logout'
    ]
];
