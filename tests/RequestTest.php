<?php

declare(strict_types = 1);

use Folded\Request;

function activateSession(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

beforeEach(function (): void {
    Request::clear();
    $_POST = [];

    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
});

it("should return the request value", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["search"] = "foo";

    expect(Request::getValue("search"))->toBe("foo");
});

it("should return all the request values", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["search"] = "foo";
    $_POST["filter"] = "bar";

    expect(Request::getAllValues())->toBe([
        "search" => "foo",
        "filter" => "bar",
    ]);
});

it("should return true if the request is present", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["search"] = "foo";

    expect(Request::hasValue("search"))->toBeTrue();
});

it("should return false if the request is not present", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["search"] = "foo";

    expect(Request::hasValue("filter"))->toBeFalse();
});

it("should return the old request value", function (): void {
    $email = "contact@example.com";

    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["email"] = $email;

    activateSession();

    Request::storeOldValues();

    expect(Request::getOldValue("email"))->toBe($email);
});

it("should throw an exception if the session is not started before getting an old value", function (): void {
    $this->expectException(Exception::class);

    Request::getOldValue("foo");
});

it("should throw an exception message if the session is not started before getting an old value", function (): void {
    $this->expectExceptionMessage("session not started");

    Request::getOldValue("foo");
});

it("should throw an exception if session is not started before storing old values", function (): void {
    $this->expectException(Exception::class);

    Request::storeOldValues();
});

it("should throw an exception message if session is not started before storing old values", function (): void {
    $this->expectExceptionMessage("session not started");

    Request::storeOldValues();
});
