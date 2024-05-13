<?php

return [
    'middleware' => ['web'],
    'prefix' => 'order-tracker',

//    Add any validation rule to apply to API Key Fields
    'validation' => [
        'name' => 'required|max:50|string',
        'email' => 'required|email'
    ],
//    Modify product being purchased
    'price' => 3.14,
    'product' => 'API KEY'
];
