<?php

use Illuminate\Support\Facades\Session;

return [
    'card' => [
        'header' => [
            'title' => 'বক্স নির্বাচন করুন',
            'sub-title' => 'বক্সের তালিকা ' . (Session::has('box_size') ? ' - আকার( :size )' : ''),
        ],
    ],
    'tabs' => [
        'all' => 'সব',
        'small' => 'ছোট',
        'medium' => 'মধ্যম',
        'large' => 'বড়'
    ],
    'legend' => [
        'booked' => 'বুক',
        'maintenance' => 'রক্ষণাবেক্ষণ',
        'available' => 'ব্যবহারযোগ্য'
    ],
    'modal' => [
        'details' => [
            'title' => 'বক্সের বিবরণ',
            'label1' => 'নম্বর: ',
            'label2' => 'আকার: ',
            'label3' => 'স্ট্যাটাস: ',
        ],
        'button' => [
            'submit' => 'বুকিং করুন'
        ]
    ],
    'button' => [
        'logout' => 'লগআউট'
    ]
];
