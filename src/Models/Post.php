<?php

namespace App\Models;

use App\db\DB;
use PDO;
use function App\db\connection\createConnection;

class Post
{
    public int $id;
    public string $title;
    public string $body;
    public int $creator_id;
    public int $created_at;

    public function __construct()
    {
        DB::getInstance()->setupConnection(createConnection());
    }

    public function save(): int
    {
        $db = DB::getInstance()->getConnection();
        $sql = "INSERT INTO post ('title', 'body', 'creator_id', 'created_at') 
VALUES (:title, :body, :creator_id, :created_at)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':title' => $this->title,
            ':body' => $this->body,
            ':creator_id' => $this->creator_id,
            ':created_at' => time()
        ]);

        $this->id = (int) $db->lastInsertId();
        return $this->id;
    }

    public static function findLastId(): int
    {
        $db = DB::getInstance()->getConnection();
        $stmt = $db->query('SELECT MAX(id) FROM post;');
        return $stmt->fetchColumn();
    }

    public static function findOne(int $id = null): self
    {
        $db = DB::getInstance()->getConnection();
        $lastId = self::findLastId();
        if (is_null($id) or $id > $lastId) {
            $id = $lastId;
        }
        $sql = 'SELECT * FROM post WHERE id = :id;';
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

        $post = new self();
        $post->id = $row['id'] ?? null;
        $post->title = $row['title'] ?? null;
        $post->body = $row['body'] ?? null;
        $post->creator_id = $row['creator_id'] ?? null;
        $post->created_at = $row['created_at'] ?? null;

        return $post;
    }
}
