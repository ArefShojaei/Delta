<?php

namespace Tests\Unit\Components;

use Delta\Components\Json\{
    Json,
    Interfaces\Json as IJson
};
use PHPUnit\Framework\TestCase;


final class JsonTest extends TestCase
{
    private function getUser()
    {
        return [
            "id" => 1,
            "name" => "Aref"
        ];
    }

    /**
     * @test
     */
    public function implementsJsonInterface(): void
    {
        $interfaces = class_implements(Json::class);

        $this->assertIsArray($interfaces);
        $this->assertNotEmpty($interfaces);
        $this->assertArrayHasKey(IJson::class, $interfaces);
    }

    /**
     * @test
     */
    public function convertDataToJson(): string
    {
        $user = $this->getUser();

        $json = Json::encode($user);

        $this->assertIsString($json);

        return $json;
    }

    /**
     * @test
     * @depends convertDataToJson
     */
    public function parseJsonDataToAnArray(string $json): void
    {
        $user = $this->getUser();

        $data = Json::decode($json, true);

        $this->assertIsNotObject($data);
        $this->assertIsNotString($data);
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
        $this->assertArrayHasKey("id", $data);
        $this->assertArrayHasKey("name", $data);
        $this->assertEquals($data["id"], $user["id"]);
        $this->assertEquals($data["name"], $user["name"]);
    }

    /**
     * @test
     * @depends convertDataToJson
     */
    public function parseJsonDataToAnObject(string $json): void
    {
        $user = $this->getUser();

        $data = Json::decode($json);

        $this->assertIsObject($data);
        $this->assertIsNotString($data);
        $this->assertNotEmpty($data);
        $this->assertIsNotArray($data);
        $this->assertObjectHasProperty("id", $data);
        $this->assertObjectHasProperty("name", $data);
        $this->assertEquals($data->id, $user["id"]);
        $this->assertEquals($data->name, $user["name"]);
    }
}
