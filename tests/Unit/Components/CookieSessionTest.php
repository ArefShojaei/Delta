<?php

namespace Tests\Unit\Components;

use Delta\Components\Cookie\Cookie;
use Delta\Components\Session\Session;

use Tests\Support\TestCase;

final class CookieSessionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $_COOKIE = [];
        $_SESSION = [];
    }

    public function testCookieSetGetRemoveAndClean(): void
    {
        Cookie::set("token", "abc");

        $this->assertSame("abc", Cookie::get("token"));
        $this->assertSame(["token" => "abc"], Cookie::all());
        $this->assertTrue(Cookie::remove("token"));
        $this->assertNull(Cookie::get("token"));
    }

    public function testSessionSetGetRemoveAndAll(): void
    {
        Session::set("user", "delta");

        $this->assertSame("delta", Session::get("user"));
        $this->assertSame(["user" => "delta"], Session::all());
        $this->assertTrue(Session::remove("user"));
        $this->assertFalse(Session::remove("user"));
        $this->assertNull(Session::get("user"));
    }
}
