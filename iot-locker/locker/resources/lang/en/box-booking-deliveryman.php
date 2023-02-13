<?php

return [
    'card' => [
        'header' => [
            'title' => 'Box Booking',
        ]
    ],
    'input-field' => [
        'parcel_no' => [
            'placeholder' => 'Enter Parcel Number',
            'button-label' => 'CLEAR',
        ],
        'receiver_mobile_no' => [
            'placeholder' => 'Enter Receiver Mobile No'
        ]
    ],
    'modal' => [
        'details' => [
            'title' => 'Box Details',
            'label1' => 'Number: ',
            'label2' => 'Size: ',
            'label3' => 'Status: ',
        ],
        'information' => [
            'title' => 'Given Information',
            'sub-title' => 'Are you sure want to continue?',
            'label1' => 'Parcel number : ',
            'label2' => 'Mobile number : ',
            'dummy-data' => 'Yet to given',
            'button-label-yes' => 'Yes',
            'button-label-no' => 'No'
        ]
    ],
    'button' => [
        'back' => 'BACK',
        'logout' => 'Logout',
        'submit' => 'Booking',
    ],
    'validation' => [
        'parcel_no' => [
            'required' => 'The parcel number field is required'
        ],
        'receiver_mobile_no' => [
            'required' => 'Mobile number is required',
            'digits' => 'Mobile number length is not valid.'
        ]
    ],
    'error-message' => [
        'receiver_mobile_no' => 'Invalid number',
        'parcel_booked' => 'The parcel is already booked',
    ]
];
