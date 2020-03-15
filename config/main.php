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
        'technologist/economist/load-economist' => 'technologist/loadEconomist',
        'technologist/economist/compute-materials' => 'technologist/computeMaterials',
        'technologist/economist/compute-labor-costs' => 'technologist/computeLaborCosts',        
        'technologist/fields' => 'technologist/getFields',
    ],
    'project_handle_url' => '/technologist/project/index',
    'bitrix_base_url' => 'https://b24-97fswd.bitrix24.ru',
    'app_title' => 'ТЕХНОЛОГ'
];