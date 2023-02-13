<?php

return [
    'card' => [
        'header' => [
            'title' => 'collect parcel',
            'sub-title' => 'Enter iotLocker OTP of selected parcel',
        ],
    ],
    'input-field' => [
        'parcel_digit' => [
            'placeholder' => ':digit digits'
        ],
        'iotLocker_otp' => [
            'placeholder' => 'iotLocker OTP'
        ],
        'company_otp' => [
            'placeholder' => 'Enter :digit digits Daraz OTP'
        ]
    ],
    'modal' => [
        'information' => [
            'title' => 'Given Information',
            'sub-title' => 'Are you sure want to continue?',
            'label1' => 'iotLocker OTP :',
            'label2' => 'Daraz OTP :',
            'dummy-data' => 'Yet to given',
            'button-label-yes' => 'Yes',
            'button-label-no' => 'No'
        ]
    ],
    'button' => [
        'cancel' => 'Cancel',
        'submit' => 'Submit'
    ],
    'validation' => [
        'parcel_digit' => [
            'required' => 'Last :digit digits of the parcel is required',
            'digits' => 'Enter last :digit digits of the parcel'
        ],
        'iotLocker_otp' => [
            'required' => 'iotLocker OTP of the selected parcel is required',
            'digits' => 'iotLocker OTP not matched'
        ],
        'company_otp' => [
            'required' => 'Daraz OTP is required',
            'digits' => 'Daraz OTP must be :digit digits'
        ]
    ],
    'error-message' => [
        'parcel_digit' => 'Last :digit digits of Parcel number not match...!',
        'iotLocker_otp' => 'iotLocker OTP not matched'
    ]
];
