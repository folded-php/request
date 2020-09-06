<?php

declare(strict_types = 1);

use Folded\Request;
use Folded\RequestValidator;
use function Folded\getRequestValidationErrors;
use function Folded\setRequestValidationLang;
use function Folded\setRequestValidationTranslationFolderPath;
use function Folded\validateRequest;

beforeEach(function (): void {
    Request::clear();
    RequestValidator::clear();
    $_POST = [];
});

it("should return the french validation error", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["email"] = "John Doe";

    setRequestValidationTranslationFolderPath(__DIR__ . "/misc/lang");
    setRequestValidationLang("fr");

    validateRequest([
        "email" => "required|email",
    ]);

    $errors = getRequestValidationErrors();

    expect($errors->first())->toBe("Le champ adresse email doit être une adresse email valide.");
});

it("should throw an exception if the lang is empty", function (): void {
    $this->expectException(InvalidArgumentException::class);

    setRequestValidationLang("");
});

it("should throw an exception message if the lang is empty", function (): void {
    $this->expectExceptionMessage("lang is empty");

    setRequestValidationLang("");
});
