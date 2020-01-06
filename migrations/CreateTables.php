<?php

namespace migrations;

use pl\core\{DB, Config};

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/webkadiz/php-lite/framework/bootstrap.php';

class CreateTables {

  function up() {
    Config::init();
    DB::connect();

    DB::query("CREATE TABLE IF NOT EXISTS `project` (
      `project_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `project_name` varchar(50) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


    DB::query("CREATE TABLE IF NOT EXISTS `hardware` (
      `hardware_id` int(11) NOT NULL PRIMARY KEY,
      `project_id` int(11) NOT NULL,
      `name` varchar(20) DEFAULT NULL,
      `gost` varchar(20) DEFAULT NULL,
      `amount` double DEFAULT NULL,
      `weight` double DEFAULT NULL,
      `weight_thousand` double DEFAULT NULL,
      `note` varchar(200) DEFAULT NULL,
      FOREIGN KEY (hardware_id) REFERENCES project (project_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


    DB::query("CREATE TABLE IF NOT EXISTS `detail` (
      `detail_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `project_id` int(11) NOT NULL,
      `scheme` varchar(70) DEFAULT NULL,
      `category` varchar(30) DEFAULT NULL,
      `name` varchar(50) DEFAULT NULL,
      `stuff` varchar(30) DEFAULT NULL,
      `thickness` varchar(20) DEFAULT NULL,
      `profile` varchar(30) DEFAULT NULL,
      `amount` double DEFAULT NULL,
      `length` double DEFAULT NULL,
      `width` double DEFAULT NULL,
      `height` double DEFAULT NULL,
      `steel` varchar(15) DEFAULT NULL,
      `perimeter` double DEFAULT NULL,
      `perimeter_all` double DEFAULT NULL,
      `weight` double DEFAULT NULL,
      `weight_all` double DEFAULT NULL,
      `square` double DEFAULT NULL,
      `square_all` double DEFAULT NULL,
      FOREIGN KEY (project_id) REFERENCES project (project_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


    DB::query("CREATE TABLE IF NOT EXISTS `assembly` (
      `assembly_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `project_id` int(11) NOT NULL ,
      `scheme` varchar(70) DEFAULT NULL,
      `name` varchar(20) DEFAULT NULL,
      `category` varchar(20) DEFAULT NULL,
      `detail_name` varchar(20) DEFAULT NULL,
      `profile` varchar(30) DEFAULT NULL,
      `amount` double DEFAULT NULL,
      `length` double DEFAULT NULL,
      `width` double DEFAULT NULL,
      `height` double DEFAULT NULL,
      `weight` double DEFAULT NULL,
      `weight_all` double DEFAULT NULL,
      FOREIGN KEY (project_id) REFERENCES project (project_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


    DB::query("CREATE TABLE IF NOT EXISTS `hole` (
      `hole_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `detail_id` int(11) NOT NULL,
      `hole_diameter` double DEFAULT NULL,
      `hole_oval_x` double DEFAULT NULL,
      `hole_oval_y` double DEFAULT NULL,
      `hole_amount` double DEFAULT NULL,
      `hole_amount_all` double DEFAULT NULL,
      `hole_length` double DEFAULT NULL,
      `hole_length_all` double DEFAULT NULL,
      FOREIGN KEY (detail_id) REFERENCES detail (detail_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


    DB::query("CREATE TABLE IF NOT EXISTS `seam` (
      `seam_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `assembly_id` int(11) NOT NULL,
      `seam_side` double DEFAULT NULL,
      `seam_length` double DEFAULT NULL,
      `seam_length_all` double DEFAULT NULL,
      FOREIGN KEY (assembly_id) REFERENCES assembly (assembly_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

  }
}

(new CreateTables())->up();