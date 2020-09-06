<?php

declare(strict_types = 1);

use Folded\Request;
use function Folded\getRequestValue;

beforeEach(function (): void {
    Request::clear();
    $_POST = [];
});

it("should return the value of the request key", function (): void {
    $email = "contact@example.com";

    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["email"] = $email;

    expect(getRequestValue("email"))->toBe($email);
});

it("should return the fallback value if the key is not found", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_SERVER["CONTENT_TYPE"] = "multipart/form-data";
    $fallbackEmail = "john@doe.com";

    expect(getRequestValue("email", $fallbackEmail))->toBe($fallbackEmail);
});

it("should throw an exception if the value is not found and no fallback is specified", function (): void {
    $this->expectException(InvalidArgumentException::class);

    $_SERVER["REQUEST_METHOD"] = "POST";

    getRequestValue("email");
});

it("should throw an exception message if the value is not found and no fallback is specified", function (): void {
    $key = "email";

    $this->expectExceptionMessage("key $key not found");

    $_SERVER["REQUEST_METHOD"] = "POST";

    getRequestValue($key);
});

it("should throw an exception if the request key is empty", function (): void {
    $this->expectException(InvalidArgumentException::class);

    $_SERVER["REQUEST_METHOD"] = "POST";

    getRequestValue("");
});

it("should throw an exception message if the request key is empty", function (): void {
    $this->expectExceptionMessage("key is empty");

    $_SERVER["REQUEST_METHOD"] = "POST";

    getRequestValue("");
});
