<?php

namespace Tests\Unit\Components;

use Delta\Components\Json\Json;
use Delta\Components\Json\Interfaces\Json as JsonInterface;

use Tests\Support\TestCase;

final class JsonTest extends TestCase
{
    public function testImplementsJsonInterface(): void
    {
        $interfaces = class_implements(Json::class);

        $this->assertArrayHasKey(JsonInterface::class, $interfaces);
    }

    public function testEncodeAndDecodeArrayPayload(): void
    {
        $payload = [
            "id" => 1,
            "name" => "Aref",
            "meta" => ["active" => true],
        ];

        $json = Json::encode($payload);
        $decoded = Json::decode($json, true);

        $this->assertIsString($json);
        $this->assertSame($payload, $decoded);
    }

    public function testDecodeToObjectPayload(): void
    {
        $decoded = Json::decode('{"id":2,"name":"Delta"}');

        $this->assertIsObject($decoded);
        $this->assertSame(2, $decoded->id);
        $this->assertSame("Delta", $decoded->name);
    }
}
