<?php

return [
    'routes' => [
        '' => 'technologist/index',
        'technologist/install' => 'technologist/install',
        'technologist/project/(get|index|create|compute|load-economist|remove|save)/?(materials|labor-costs)?' => 'technologist/project',
        'technologist/api/fields' => 'technologist/apiGetFields',
    ]
];