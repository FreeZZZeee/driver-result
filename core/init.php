<?php
defined("ROOTPATH") OR exit('Доступ запрещен!');

$protocol = (!empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS'])?"https://":"http://");
$root = $protocol . $_SERVER['SERVER_NAME'] . ":5000" . $_SERVER['PHP_SELF'];
$root = str_replace("index.php", "", $root);

define('ROOT', $root);
define('ASSETS', $root . "assets/");


spl_autoload_register(function ($classname){

    $classname = explode('\\', $classname);
    $classname = end($classname);
    require "../models/" . ucfirst($classname) . ".php";
});

require(__DIR__ . '/../vendor/autoload.php');
require "config.php";
require "functions.php";
require "Model.php";
require "MainController.php";
require "App.php";