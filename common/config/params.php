<?php

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'siteName' => "Schoolingly",
    'institution' => "A2Z Systems",
    'institutionShortName' => "a2z",
    'website' => "https://www.a2z.co.zm",
    'defaultCampus' => "Main",
    'defaultCampusCode' => "Main",
    'defaultCampusAddress' => "Main campus",
    'defaultSchoolName' => "NS",
    'defaultSchoolDescription' => "Natural Sciences",
    'defaultDepartmentName' => "Information Technology",
    'defaultDepartmentCode' => "IT",
    'defaultUserFirstname' => "Francis",
    'defaultUserLastname' => "Chulu",
    'defaultUserEmail' => "admin@schoolingly.com",
    'defaultUserManNo' => "01234",
    'passwordValidity' => 3, //Number of months before user can change their password
    'btnClass' => "btn-falcon-default",
    'bsVersion' => '5',
    "host" => "http://localhost",
    "wrongPasswordCounter" => 3,
    'cacheDuration' => 60,
    'specialPermissionExpiry' => 24, //hours
    'connectionTimeout' => 90,
    'lms' => [
        'host' => 'http://localhost', //Should contain the protocol:-http or htttps
        'extension' => '/moodle/webservice/rest/server.php',
        'token' => '717452f3beb3c4a504e4f65081c67dd1',
        'timeZone' => 'Africa/Lusaka',
        'lang' => 'en',
        'countryCode' => 'ZM',
        'studentRole' => 5,
        'teacherRole' => 4,
        'functions' => [
            'createUser' => 'core_user_create_users',
            'createCourse' => "local_siscourse_create_course",
            'enrolUser' => "local_sisenrol_enrol_user",
            'unenrolUser' => "local_sisunenrol_unenrol_user",
            'studentGrades' => "local_sisresults_course_grades",
        ]
    ],
];
