<?php

namespace App\Models;

use function App\db\connection\createConnection;
use App\db\DB;
use PDO;


class User
{
    public int $id;
    public string $email;
    public string $first_name;
    public string $last_name;
    public string $password;
    public int $created_at;

    public function __construct()
    {
        DB::getInstance()->setupConnection(createConnection());
    }

    public function save(): int
    {
        $db = DB::getInstance()->getConnection();
        $sql = "INSERT INTO users ('email', 'first_name', 'last_name', 'password', 'created_at') 
VALUES (:email, :first_name, :last_name, :password, :created_at)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':email' => $this->email,
            ':first_name' => $this->first_name,
            ':last_name' => $this->last_name,
            ':password' => $this->password,
            ':created_at' => time()
        ]);

        $this->id = (int) $db->lastInsertId();
        return $this->id;
    }

    public static function findLastId(): int
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->query('SELECT MAX(id) FROM users;');
        return $stmt->fetchColumn();
    }

    public static function findOne(int $id = null): self
    {
        $db = DB::getInstance()->getConnection();
        $lastId = self::findLastId();
        if (is_null($id) or $id > $lastId) {
            $id = $lastId;
        }
        $sql = 'SELECT * FROM users WHERE id = :id;';
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return self::createFromRow($row);
    }

    public static function createFromRow (array $row): ?self
    {
        if (empty($row)) {
            return null;
        }

        $user = new self();
        $user->id = $row['id'] ?? null;
        $user->email = $row['email'] ?? null;
        $user->first_name = $row['first_name'] ?? null;
        $user->last_name = $row['last_name'] ?? null;
        $user->password = $row['password'] ?? null;
        $user->created_at = $row['created_at'] ?? null;

        return $user;
    }
}
