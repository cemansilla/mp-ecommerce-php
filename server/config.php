<?php
return [
  'base_url' => ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http') . "://{$_SERVER['SERVER_NAME']}".str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']),
  'mercadopago' => [
    'integrator-id' => 'dev_24c65fb163bf11ea96500242ac130004',
    'seller' => [
      'collector_id' => '469485398',
      'public_key' => 'APP_USR-7eb0138a-189f-4bec-87d1-c0504ead5626',
      'access_token' => 'APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398'
    ],
    'customer' => [
      'id' => '471923173',
      'name' => 'Lalo',
      'last_name' => 'Landa',
      'email' => 'test_user_63274575@testuser.com',
      'password' => 'qatest2417',
      'tel_code' => '11',
      'tel' => '22223333',
      'address' => [
        'street' => 'False',
        'number' => '123',
        'zip_code' => '1111'
      ]
    ]
  ]
];
?>