<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);




define("ROOT_DIR", __DIR__ . '/');
define("PROJECTS_DIR", ROOT_DIR . 'projects/');
define('FRAMEWORK_DIR', ROOT_DIR . 'framework/');
require FRAMEWORK_DIR . 'bootstrap.php';


Config::set('routes', [
  '' => 'tech_main/technologist/index',
  'technologist/install' => 'tech_install/technologist/install',
  'technologist/project/(get|index|create|compute|load-economist|remove|save)/?(materials|labor-costs)?' => 'tech_project/technologist/project/-/$1/$2',
  'technologist/config/(fields)' => 'tech_config/technologist/config/-/$1',
  //'~^technologist/project~' => 'tech_group/technologist/group',

]);

///Config::set('file_log_dir', ROOT_DIR.'logs');

// Config::set('static', 'const');

Config::set('custom_paths', []);

Config::set('excelDetailAlias', [
  'scheme',
  'name',
  'category',
  'profile',
  'amount',
  'length',
  'width',
  'height',
  'steel',
  'perimeter',
  'perimeter_all',
  'weight',
  'weight_all',
  'square',
  'square_all',
  'hole_diameter',
  'hole_oval_x',
  'hole_oval_y',
  'hole_amount',
  'hole_amount_all',
  'hole_length',
  'hole_length_all',
]);

Config::set('excelAssemblyAlias', [
  'scheme',
  'name',
  'category',
  'detail_name',
  'profile',
  'amount',
  'length',
  'width',
  'height',
  'weight',
  'weight_all',
  'seam_side',
  'seam_length',
  'seam_length_all',
]);

Config::set('excelEconomistAlias', [
  'empty',
  'type',
  'stuff',
  'refusal',
  'operation',
  'plot',
  'work_rate_hour',
  'work_rate_unit',
  'amount_workers',
  'labor_operation',
  'consumption_electricity',
  'consumption_dril',
  'consumption_circle',
  'consumption_sand',
  'consumption_nozzle',
  'consumption_electrode',
  'consumption_coolant',
  'consumption_oxygen',
  'consumption_propane',
  'overhead'
]);

Config::set('excelHardwareAlias', [
  'name',
  'gost',
  'amount',
  'weight',
  'weight_thousand',
  'note',
]);

Config::set('fields', [

  'detail' => [
    ['label' => "материал", 'field' => "stuff"],
    ['label' => "толщина", 'field' => "thickness"],
    ['label' => "профиль", 'field' => "profile"],
    ['label' => "длина (мм)", 'field' => "length"],
    ['label' => "ширина (мм)", 'field' => "width"],
    ['label' => "высота (мм)", 'field' => "height"],
    ['label' => "марка стали", 'field' => "steel"],
    ['label' => "масса (кг)", 'field' => "weight"],
    ['label' => "периметр (м)", 'field' => "perimeter"],
    ['label' => "площадь (м кв.)", 'field' => "square"],
    ['label' => "катет сварки 1 (мм)", 'field' => "seamSide1"],
    ['label' => "L шва сварки 1 (м)", 'field' => "seamLength1"],
    ['label' => "катет сварки 2 (мм)", 'field' => "seamSide2"],
    ['label' => "L шва сварки 2 (м)", 'field' => "seamLength2"],
    ['label' => "катет сварки 3 (мм)", 'field' => "seamSide3"],
    ['label' => "L шва сварки 3 (м)", 'field' => "seamLength3"],
    ['label' => "катет сварки 4 (мм)", 'field' => "seamSide4"],
    ['label' => "L шва сварки 4 (м)", 'field' => "seamLength4"],
    ['label' => "отверстия круглые, диаметр 1", 'field' => "holeDiameter1"],
    ['label' => "отверстия овальные, по оси X 1", 'field' => "holeOvalX1"],
    ['label' => "отверстия овальные, по оси Y 1", 'field' => "holeOvalY1"],
    ['label' => "количество отверстий 1", 'field' => "holeAmount1"],
    ['label' => "длина реза 1", 'field' => "holeLength1"],
    ['label' => "отверстия круглые, диаметр 2", 'field' => "holeDiameter2"],
    ['label' => "отверстия овальные, по оси X 2", 'field' => "holeOvalX2"],
    ['label' => "отверстия овальные, по оси Y 2", 'field' => "holeOvalY2"],
    ['label' => "количество отверстий 2", 'field' => "holeAmount2"],
    ['label' => "длина реза 2", 'field' => "holeLength2"],
    ['label' => "отверстия круглые, диаметр 3", 'field' => "holeDiameter3"],
    ['label' => "отверстия овальные, по оси X 3", 'field' => "holeOvalX3"],
    ['label' => "отверстия овальные, по оси Y 3", 'field' => "holeOvalY3"],
    ['label' => "количество отверстий 3", 'field' => "holeAmount3"],
    ['label' => "длина реза 3", 'field' => "holeLength3"],
    ['label' => "отверстия круглые, диаметр 4", 'field' => "holeDiameter4"],
    ['label' => "отверстия овальные, по оси X 4", 'field' => "holeOvalX4"],
    ['label' => "отверстия овальные, по оси Y 4", 'field' => "holeOvalY4"],
    ['label' => "количество отверстий 4", 'field' => "holeAmount4"],
    ['label' => "длина реза 4", 'field' => "holeLength4"],
    ['label' => "отверстия круглые, диаметр 5", 'field' => "holeDiameter5"],
    ['label' => "отверстия овальные, по оси X 5", 'field' => "holeOvalX5"],
    ['label' => "отверстия овальные, по оси Y 5", 'field' => "holeOvalY5"],
    ['label' => "количество отверстий 5", 'field' => "holeAmount5"],
    ['label' => "длина реза 5", 'field' => "holeLength5"],
    ['label' => "количество деталей", 'field' => "amount"],

  ],
  'assembly' => [
    ['label' => "материал", 'field' => "category"],
    ['label' => "количество деталей", 'field' => "amount"],
    ['label' => "длина (мм)", 'field' => "length"],
    ['label' => "ширина (мм)", 'field' => "width"],
    ['label' => "высота (мм)", 'field' => "height"],
    ['label' => "масса (кг)", 'field' => "weight"]
  ],
  'hardware' => [
    ['label' => "гост", 'disabled' => true, 'field' => "gost"],
    ['label' => "количество", 'disabled' => true, 'field' => "amount"],
    ['label' => "масса", 'disabled' => true, 'field' => "weight"],
    [
      'label' => "масса (1000 кг)",
      'disabled' => true,
      'field' => "weightThousand"
    ],
    ['label' => "примечания", 'disabled' => true, 'field' => "note"]
  ]

]);

// Config::set('static_layouts', [
// 	'default'
// ]);

// Config::set('css_dir', '/public/');
// Config::set('js_dir', '/public/build/');
// Config::set('img_dir', '/public/build/img/');

// Config::set('css', [
// 	'tech_main' => ['style.css']
// ]);

Config::set('js', [
  'tech_main' => ["//api.bitrix24.com/api/v1/"],
  'tech_project' => ['technologist.js']
]);

Config::set('css', [
  'permament' => ['https://fonts.googleapis.com/icon?family=Material+Icons']
]);


//unC0J8I0

Config::set('db', [
  'dbserver' => 'mysql',
  'host' => 'localhost',
  'dbname' => 'bitrix24',
  'user' => 'root',
  'password' => '',
  'charset' => 'utf8',
]);


$app = new App();
$app->run($_SERVER['REQUEST_URI']);
