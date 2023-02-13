<?php

return [
    'card' => [
        'collect-parcel' => [
            'header' => [
                'title' => 'পার্সেল সংগ্রহ করুন',
                'sub-title' => 'আপনি OTP বা QR কোড ব্যবহার করে পার্সেল সংগ্রহ করতে পারেন'
            ]
        ]
    ],
    'tabs' => [
        'otp' => [
            'title' => 'OTP',
        ],
        'qr-code' => [
            'title' => 'QR কোড',
        ]
    ],
    'input-field' => [
        'receiver_mobile_no' => [
            'placeholder' => 'আপনার মোবাইল নাম্বার প্রবেশ করুন',
        ],
        'barcode' => [
            'placeholder' => 'আপনার QR কোড স্ক্যান করুন',
            'button-label' => 'মুছে ফেলুন',
        ]
    ],
    'modal' => [
        'information' => [
            'title' => 'প্রদত্ত তথ্য',
            'sub-title' => 'আপনি কি চালিয়ে যেতে চান?',
            'label1' => 'মোবাইল নম্বর : ',
            'dummy-data' => 'এখনও দেওয়া বাকি',
            'button-label-yes' => 'হ্যাঁ',
            'button-label-no' => 'না'
        ],
        'barcode-information' => [
            'title' => 'প্রদত্ত তথ্য',
            'sub-title' => 'আপনি কি চালিয়ে যেতে চান?',
            'label1' => 'QR কোড : ',
            'dummy-data' => 'এখনও দেওয়া বাকি',
            'button-label-yes' => 'হ্যাঁ',
            'button-label-no' => 'না'
        ]
    ],
    'validation' => [
        'receiver_mobile_no' => [
            'required' => 'রিসিভার মোবাইল নম্বর ফিল্ডটি প্রয়োজন',
            'digits' => 'প্রাপকের মোবাইল নম্বরটি ১১ সংখ্যার হতে হবে'
        ],
        'barcode' => [
            'required' => 'QR কোড ফিল্ডটি প্রয়োজন'
        ]
    ],
    'error-message' => [
        'mobile-no' => 'এই মোবাইল নম্বর ব্যবহার করে পার্সেল পাওয়া যায় না। প্রকৃত তথ্য দিয়ে আবার চেষ্টা করুন',
        'contact_no' => 'নাম্বারটি ভুল',
        'parcel-not-found' => 'পার্সেলটি পাওয়া যায়নি',
        'collection' => 'পার্সেলটির সংগ্রহের সময় শেষ হয়ে গেছে।'
    ],
    'button' => [
        'back' => 'পেছনে',
        'submit-find' => 'খুঁজুন',
        'submit-verify' => 'যাচাই করুন'
    ]
];
