<?php

namespace App;

use App\Models\User;
//use App\Models\Post;
use App\db\DB;

use function App\db\connection\createConnection;
use function PHPUnit\Framework\isNull;

class Api
{
    public array $requestUri = [];
    public string $method = '';
    public string $api;
    public mixed $tableName;
    public int $id;
    public $data;

    public function __construct()
    {
        DB::getInstance()->setupConnection(createConnection());
        $this->db = DB::getInstance()->getConnection();

        header("Access-Control-Allow-Orgin: *");
        header("Content-Type: application/json");

        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $this->api = array_shift($this->requestUri);
        $this->tableName = array_shift($this->requestUri);
        $this->id = (int) array_shift($this->requestUri);

        $this->data = json_decode(file_get_contents('php://input'), true);
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function connection()
    {
        switch ($this->method) {
            case 'GET':
                return $this->viewOne();
            case 'PUT':
                return $this->createUser();
            default:
                return null;
        }
    }

    public function response($data, int $status = 500): void
    {
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        echo json_encode($data);
    }

    public function requestStatus(int $code): string
    {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return $status[$code] ?? $status[500];
    }

    public function viewOne()
    {
        if ($this->id) {
            $user = (array) User::findOne($this->id);
            if ($user) {
                return $this->response($user, 200);
            }
        }
        return $this->response('Data not found', 404);
    }

    public function createUser()
    {
        $user = new User();
        $user->email = $this->data['email'] ?? '';
        $user->first_name = $this->data['first_name'] ?? '';
        $user->last_name = $this->data['last_name'] ?? '';
        $user->password = $this->data['password'] ?? '';
        $id = ($user->save());
        $data = User::findOne($id);
        if (isNull($data)) {
            return $this->response($data, 200);
        }
        return $this->response("Saving error");
    }
}
