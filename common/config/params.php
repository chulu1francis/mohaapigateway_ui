<?php

return [
    'adminEmail' => 'admin@gov.zm',
    'supportEmail' => 'allapps.noreply@gmail.com',
    'senderEmail' => 'allapps.noreply@gmail.com',
    'senderName' => 'DNRPC INRIS API Manager',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'siteName' => "DNRPC INRIS API Manager",
    'shortSiteName' => "INRIS API",
    'institutionSupportContact' => "+260975981190",
    'institutionSupportEmail' => "support@gov.zm",
    'institution' => "Department of National Registration, Passport and Citizenship",
    'institutionShortName' => "DNRPC",
    'institutionDescription' => "Government of the Republic of Zambia, Minstry of Home Affairs(MOHA),Department of National Registration, Passport and Citizenship",
    'portalDescription' => "DNRPC INRIS API Manager",
    'website' => "https://www.mohais.gov.zm",
    'passwordValidity' => 3, //Number of months before user can change their password
    'btnClass' => "btn-danger",
    'btnClassFalcon' => "btn btn-falcon-danger",
    'bsVersion' => '5',
//    "host" => "http://localhost",
//    "port" => "4005",
    "host" => "http://10.21.8.80",
    "port" => "80",
    "wrongPasswordCounter" => 3,
    'cacheDuration' => 60,
    'specialPermissionExpiry' => 24, //hours
    'connectionTimeout' => 90,
    'baseAPIUrl' => "http://localhost:7250/moha/v1/auth/",
    'encryptEndpoint' => "encrypt/",
    'encodeEndpoint' => "encode/",
];
