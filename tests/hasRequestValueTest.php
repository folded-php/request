<?php

declare(strict_types = 1);

use Folded\Request;

beforeEach(function (): void {
    Request::clear();
    $_POST = [];
});

it("should return true if the request contains the value", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["email"] = "contact@example.com";

    expect(hasRequestValue("email"))->toBeTrue();
});

it("should return false if the request do not contains the value", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["email"] = "contact@example.com";

    expect(hasRequestValue("name"))->toBeFalse();
});

it("should throw an exception if the name is empty", function (): void {
    $this->expectException(InvalidArgumentException::class);

    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["email"] = "contact@example.com";

    hasRequestValue("");
});
