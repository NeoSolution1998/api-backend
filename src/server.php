<?php

use App\Api;
use App\db\connection;
use App\db\DB;

header("Content-Type: application/json");

require 'vendor/autoload.php';
require_once "api.php";

$db = connection\createConnection();

DB::getInstance()->setupConnection($db);

$api = new Api();
$api->connection();

