<?php

return [
    'card' => [
        'header' => [
            'title' => 'পার্সেল সংগ্রহ করুন',
            'sub-title' => 'নির্বাচিত পার্সেলের ডিজিবক্স OTP লিখুন',
        ],
    ],
    'input-field' => [
        'parcel_digit' => [
            'placeholder' => 'শেষ :digit সংখ্যা'
        ],
        'iotLocker_otp' => [
            'placeholder' => 'ডিজিবক্স OTP'
        ],
        'company_otp' => [
            'placeholder' => ':digit সংখ্যার দারাজ OTP লিখুন'
        ]
    ],
    'modal' => [
        'information' => [
            'title' => 'প্রদত্ত তথ্য',
            'sub-title' => 'আপনি কি চালিয়ে যেতে চান?',
            'label1' => 'ডিজিবক্স OTP :',
            'label2' => 'দারাজ OTP :',
            'dummy-data' => 'এখনও দেওয়া বাকি',
            'button-label-yes' => 'হ্যাঁ',
            'button-label-no' => 'না'
        ]
    ],
    'button' => [
        'cancel' => 'বাতিল',
        'submit' => 'জমা দিন'
    ],
    'validation' => [
        'parcel_digit' => [
            'required' => 'পার্সেলের শেষ :digit টি সংখ্যা প্রয়োজন',
            'digits' => 'পার্সেলের শেষ :digit টি সংখ্যা লিখুন'
        ],
        'iotLocker_otp' => [
            'required' => 'নির্বাচিত পার্সেলের ডিজিবক্স OTP প্রয়োজন',
            'digits' => 'ডিজিবক্স OTP মেলেনি'
        ],
        'company_otp' => [
            'required' => 'দারাজ OTP প্রয়োজন',
            'digits' => 'দারাজ OTP অবশ্যই :digit সংখ্যার হতে হবে'
        ]
    ],
    'error-message' => [
        'parcel_digit' => 'পার্সেল নম্বরের শেষ :digit টি সংখ্যা মেলে না...!',
        'iotLocker_otp' => 'ডিজিবক্স OTP মেলেনি'
    ]
];
