<?php
define('DS', DIRECTORY_SEPARATOR);
define("SITE_ROOT", 'C:\xampp\htdocs\test_work' . DS);
define("LIB_ROOT", SITE_ROOT . 'include' . DS);

require_once(LIB_ROOT . 'config.php');
require_once(LIB_ROOT . 'database.php');
require_once(LIB_ROOT . 'Categories.php');
require_once(LIB_ROOT . 'News.php');