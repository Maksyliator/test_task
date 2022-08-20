<?php

namespace App\Tests;

class ApiTest extends BaseTest
{
    private \GuzzleHttp\Client | null $http;

    public function setUp(): void
    {
        $this->http = new \GuzzleHttp\Client(['base_uri' => 'http://localhost:8081/']);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    public function testGetUser()
    {
        $response = $this->http->get("/api/users/1");

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $userId = json_decode($response->getBody())->{"id"};
        $userName = json_decode($response->getBody())->{"first_name"};

        $this->assertEquals(1, $userId);
        $this->assertEquals("SomeName", $userName);
    }

    public function testCreateUser()
    {
        $response = $this->http->put("/api/users", [
            'json' => [
                "email" => "api-email@mail.com",
                "first_name" => "ApiName",
                "last_name" => "ApiLastName",
                "password" => 'ApiPassword',
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $userId = json_decode($response->getBody())->{"id"};
        $userName = json_decode($response->getBody())->{"first_name"};

        $this->assertTrue($userId > 0);
        $this->assertEquals("ApiName", $userName);
    }
}
