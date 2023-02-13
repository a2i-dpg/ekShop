<?php

return [
    'card' => [
        'header' => [
            'title' => 'বক্স বুকিং',
        ]
    ],
    'input-field' => [
        'parcel_no' => [
            'placeholder' => 'পার্সেল নম্বর লিখুন',
            'button-label' => 'মুছে ফেলুন',
        ],
        'receiver_mobile_no' => [
            'placeholder' => 'রিসিভার মোবাইল নম্বর লিখুন'
        ]
    ],
    'modal' => [
        'details' => [
            'title' => 'বক্সের বিবরণ',
            'label1' => 'নম্বর: ',
            'label2' => 'আকার: ',
            'label3' => 'স্ট্যাটাস: ',
        ],
        'information' => [
            'title' => 'প্রদত্ত তথ্য',
            'sub-title' => 'আপনি কি চালিয়ে যেতে চান?',
            'label1' => 'পার্সেল নম্বর : ',
            'label2' => 'মোবাইল নম্বর : ',
            'dummy-data' => 'এখনও দেওয়া বাকি',
            'button-label-yes' => 'হ্যাঁ',
            'button-label-no' => 'না'
        ]
    ],
    'button' => [
        'back' => 'পেছনে',
        'logout' => 'লগআউট',
        'submit' => 'বুকিং করুন',
    ],
    'validation' => [
        'parcel_no' => [
            'required' => 'পার্সেল নম্বর ফিল্ডটি প্রয়োজন'
        ],
        'receiver_mobile_no' => [
            'required' => 'মোবাইল নম্বর ফিল্ডটি প্রয়োজন',
            'digits' => 'মোবাইল নম্বরটি দৈর্ঘ্য সঠিক নয়'
        ]
    ],
    'error-message' => [
        'receiver_mobile_no' => 'মোবাইল নম্বরটি সঠিক নয়',
        'parcel_booked' => 'পার্সেল ইতিমধ্যে বুক করা আছে',
    ]
];
