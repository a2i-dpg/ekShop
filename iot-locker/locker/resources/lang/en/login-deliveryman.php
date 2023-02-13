<?php

return [
    'card' => [
        'header' => [
            'title' => 'DROP OFF',
        ],
    ],
    'input-field' => [
        'username' => [
            'placeholder' => 'Enter your phone number or email'
        ],
        'password' => [
            'placeholder' => 'Enter your password'
        ]
    ],
    'button' => [
        'back' => 'BACK',
        'login' => 'Log In',
        'alternative-login' => 'Alternative Login',
    ],
    'validation' => [
        'email' => [
            'required' => 'The email field is required.',
            'string' => 's',
            'email' => 's',
        ],
        'username' => [
            'required' => 'The username field is required.',
            'string' => 't',
        ],
        'contact_no' => [
            'required' => 'The phone number field is required.',
            'digits' => 't'
        ],
        'password' => [
            'required' => 'The password field is required.',
            'min' => 'The password must be at least 4 characters',
            'string' => 't'
        ],
    ],
    'error-message' => [
        'contact_no' => 'Invalid number',
        'credential' => 'Credentials not match'
    ]
];
