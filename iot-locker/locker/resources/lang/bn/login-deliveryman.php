<?php

return [
    'card' => [
        'header' => [
            'title' => 'ড্রপ অফ',
        ],
    ],
    'input-field' => [
        'username' => [
            'placeholder' => 'আপনার ফোন নম্বর বা ইমেল লিখুন'
        ],
        'password' => [
            'placeholder' => 'আপনার পাসওয়ার্ড লিখুন'
        ]
    ],
    'button' => [
        'back' => 'পেছনে',
        'login' => 'লগইন',
        'alternative-login' => 'বিকল্প লগইন',
    ],
    'validation' => [
        'email' => [
            'required' => 'ইমেল ফিল্ডটি প্রয়োজন',
        ],
        'username' => [
            // 'required' => 'ব্যবহারকারীর নাম ফিল্ডটি প্রয়োজন',
            'required' => 'ফোন নম্বর বা ইমেল ফিল্ডটি প্রয়োজন',
        ],
        'contact_no' => [
            'required' => 'ফোন নম্বর ফিল্ডটি প্রয়োজন',
        ],
        'password' => [
            'required' => 'পাসওয়ার্ড ফিল্ডটি প্রয়োজন',
            'min' => 'পাসওয়ার্ড কমপক্ষে 4 অক্ষরের হতে হবে',
        ],
    ],
    'error-message' => [
        'contact_no' => 'নাম্বারটি ভুল',
        'credential' => 'তথ্য পাওয়া যায়নি'
    ]
];
