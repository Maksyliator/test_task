<?php

namespace App\Tests;

use App\db\connection;
use App\db\DB;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    public function setUp(): void
    {
        $db = connection\createConnection();

        DB::getInstance()->setupConnection($db);
    }
}
