<?php
/**
 * Config-file for different api_keys.
 * Change [xxxx] for your api-key
 */
return [
    // Ipstack
    // Its concatenated in this order -> url . ip . key
    "ipstack" => [
        "url" => "http://api.ipstack.com/",
        "key" => "?access_key=[xxxxxxxxxxx]"
    ],

    // Darksky using it like this -> url . ["lat,lon"] . single / multi.
    "darksky" => [
        "url" => "https://api.darksky.net/forecast/[xxxxxxxx]/",
        "single" => "?lang=sv&units=si",
        "multi" => "?exclude=currently,flags&lang=sv&units=si"
    ],

    // https://opencagedata.com/tutorials/geocode-in-php
    "opencage" => "[xxxxxxxxxxxxxx]"
];
