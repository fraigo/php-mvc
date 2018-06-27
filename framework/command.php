<?php

require_once("index.php");

$app = new \lib\App();
$app->executeCommand($_SERVER["argv"]);