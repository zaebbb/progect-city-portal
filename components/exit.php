<?php

include_once "./config.php";
include_once "./functions.php";

$_SESSION["user"] = [];

header("Location: " . $get_url_page(""));