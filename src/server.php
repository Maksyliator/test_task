<?php

use App\Api;
use App\db\connection;
use App\db\DB;

require 'vendor/autoload.php';

$db = connection\createConnection();

DB::getInstance()->setupConnection($db);

$api = new Api();

$api->connection();
