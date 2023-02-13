<?php

return [
    'card' => [
        'collect-parcel' => [
            'header' => [
                'title' => 'Collect Parcel',
                'sub-title' => 'You can collect the parcel using OTP or QR code'
            ]
        ]
    ],
    'tabs' => [
        'otp' => [
            'title' => 'OTP',
        ],
        'qr-code' => [
            'title' => 'QR CODE',
        ]
    ],
    'input-field' => [
        'receiver_mobile_no' => [
            'placeholder' => 'Enter your mobile number',
        ],
        'barcode' => [
            'placeholder' => 'Scan your QR code',
            'button-label' => 'CLEAR',
        ]
    ],
    'modal' => [
        'information' => [
            'title' => 'Given Information',
            'sub-title' => 'Are you sure want to continue?',
            'label1' => 'Mobile number : ',
            'dummy-data' => 'Yet to given',
            'button-label-yes' => 'Yes',
            'button-label-no' => 'No'
        ],
        'barcode-information' => [
            'title' => 'Given Information',
            'sub-title' => 'Are you sure want to continue?',
            'label1' => 'QR code : ',
            'dummy-data' => 'Yet to given',
            'button-label-yes' => 'Yes',
            'button-label-no' => 'No'
        ]
    ],
    'validation' => [
        'receiver_mobile_no' => [
            'required' => 'The receiver mobile no. field is required',
            'digits' => 'The receiver mobile number must be 11 digits'
        ],
        'barcode' => [
            'required' => 'QR code field is required'
        ]
    ],
    'error-message' => [
        'mobile-no' => 'The parcel is not found using this mobile no. Please try again with actual information.',
        'contact_no' => 'Invalid number',
        'parcel-not-found' => 'The parcel not found',
        'collection' => 'Collection time has expired.'
    ],
    'button' => [
        'back' => 'BACK',
        'submit-find' => 'Find',
        'submit-verify' => 'Verify'
    ]
];
