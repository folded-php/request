<?php

declare(strict_types = 1);

use Folded\Request;
use Folded\RequestValidator;
use function Folded\requestValidationSucceeded;
use function Folded\validateRequest;

beforeEach(function (): void {
    Request::clear();
    RequestValidator::clear();
    $_POST = [];
});

it("should return true if the request validation succeeded", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["email"] = "contact@example.com";

    validateRequest([
        "email" => "required|email",
    ]);

    expect(requestValidationSucceeded())->toBeTrue();
});

it("should return false if the request validation failed", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["email"] = "John doe";

    validateRequest([
        "email" => "required|email",
    ]);

    expect(requestValidationSucceeded())->toBeFalse();
});
