<?php

return [
    'card' => [
        'header' => [
            'title' => 'ALTERNATIVE LOGIN',
        ],
    ],
    'input-field' => [
        'contact_no' => [
            'placeholder' => 'Enter your mobile number'
        ]
    ],
    'button' => [
        'back' => 'BACK',
        'submit' => 'Send OTP'
    ],
    'validation' => [
        'contact_no' => [
            'required' => 'The mobile number field is required.'
        ]
    ],
    'error-message' => [
        'contact_no' => 'Invalid number',
        'credential' => 'The user account was not found using this mobile number. Please try again with other information.'
    ],
    'success-message' => [
        'send-otp' => 'OTP has been sent to this number :contact_no successfully'
    ]
];
