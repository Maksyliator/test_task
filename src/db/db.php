<?php

namespace App\db;

class DB
{
    private static $instance = null;

    public static function getInstance(): DB
    {
        if (!self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    private $db;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton class DB.");
    }

    public function setupConnection($db)
    {
        $this->db = $db;
    }

    public function getConnection()
    {
        if (!$this->db) {
            throw new \Exception("Connection is not setup");
        }

        return $this->db;
    }
}
