<?php

declare(strict_types = 1);

use Folded\Request;
use Folded\RequestValidator;
use function Folded\validateRequest;
use function Folded\getRequestValidationErrors;
use function Folded\setRequestValidationTranslationFolderPath;

beforeEach(function (): void {
    Request::clear();
    RequestValidator::clear();

    $_POST = [];
});

it("should return the error if the request validation failed", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["email"] = "John Doe";

    setRequestValidationTranslationFolderPath(__DIR__ . "/misc/lang");

    validateRequest([
        "email" => "required|email",
    ]);

    $errors = getRequestValidationErrors();

    expect($errors->first())->toBe("The email must be a valid email address.");
});

it("should return an empty array if the request validation succeeded", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["email"] = "contact@email.com";

    validateRequest([
        "email" => "required|email",
    ]);

    expect(getRequestValidationErrors())->toBeEmpty();
});
