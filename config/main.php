<?php

return [
    'routes' => [
        'technologist/index' => 'technologist/index',
        'technologist/install' => 'technologist/install',
        'technologist/project/(get|index|create|compute|load-economist|remove|save)/?(materials|labor-costs)?' => 'technologist/project',
        'technologist/api/fields' => 'technologist/apiGetFields',
    ],
    'bitrix_base_url' => 'https://b24-97fswd.bitrix24.ru',
    'app_title' => 'ТЕХНОЛОГ'
];