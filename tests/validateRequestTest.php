<?php

declare(strict_types = 1);

use Folded\Request;
use function Folded\validateRequest;
use Folded\RequestValidator;

beforeEach(function (): void {
    Request::clear();
    RequestValidator::clear();
    $_POST = [];
});

it("should validate the request", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["email"] = "contact@example.com";

    validateRequest([
        "email" => "required|email",
    ]);

    expect(RequestValidator::succeeded())->toBe(true);
});
