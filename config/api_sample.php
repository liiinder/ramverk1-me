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
    "testIpstack" => [
        "url" => "http://localhost:8080/ramverk1/me/redovisa/htdocs/ipmock?ip=",
        "key" => ""
    ],
    // Darksky using it like htis -> url . lat , lon
    "darksky" => [
        "url" => "https://api.darksky.net/forecast/[xxxxxxxxxxx]/"
    ],
    // https://opencagedata.com/tutorials/geocode-in-php
    "opencage" => [
        "key" => "[xxxxxxxxxxxxxx]"
    ]
];
