<?php

define("HOST","http://".$_SERVER['HTTP_HOST'] . "/worldskills/263412-m4.wsr.ru/");

define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PASS","");
define("DB_NAME","site_2022_worldskills_fullstack_1");

session_start();

$_SESSION['error'] = [];