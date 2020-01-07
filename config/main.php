<?php

return [
    'routes' => [
        'technologist/index' => 'technologist/index',
        'technologist/install' => 'technologist/install',
        'technologist/project/index' => 'technologist/indexProject',
        'technologist/project/create' => 'technologist/createProject',
        'technologist/project/get' => 'technologist/getProject',
        'technologist/project/save' => 'technologist/saveProject',
        'technologist/project/remove' => 'technologist/removeProject',
        'technologist/project/load-economist' => 'technologist/loadEconomist',
        'technologist/project/compute-materials' => 'technologist/computeMaterials',
        'technologist/project/compute-labor-costs' => 'technologist/computeLaborCosts',        
        'technologist/project/(get|index|create|compute|load-economist|remove|save)/?(materials|labor-costs)?' => 'technologist/project',
        'technologist/api/fields' => 'technologist/apiGetFields',
    ],
    'bitrix_base_url' => 'https://b24-97fswd.bitrix24.ru',
    'app_title' => 'ТЕХНОЛОГ'
];