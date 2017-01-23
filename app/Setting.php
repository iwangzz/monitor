<?php

namespace App;

class Setting
{
    public static $timezones = [
        '-8.00' => 'GMT -8',
        '-5.00' => 'GMT -5',
        '0.00' => 'GMT +0',
        '5.50' => 'GMT +5.5', 
        '8.00' => 'GMT +8',
        '9.00' => 'GMT +9',
    ];

    public static $devices = [
        'Phone',
        'Tablet'
    ];
}
