<?php

use App\db\connection;
use App\db\initial;

require 'vendor/autoload.php';

$db = connection\createConnection();
initial\initializeDb($db);