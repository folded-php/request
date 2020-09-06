<?php

declare(strict_types = 1);

use Folded\Request;
use Folded\RequestValidator;
use Folded\Exceptions\NotAFolderException;
use Folded\Exceptions\FolderNotFoundException;

beforeEach(function (): void {
    // Clearing Request object
    // as well, because
    // RequestValidator relies
    // on the function
    // getALlRequestValues,
    // which itself relies on
    // the Request object. If
    // not cleared, it might
    // keep the data from past
    // tests.
    Request::clear();
    RequestValidator::clear();
    $_POST = [];
});

it("should set the translation folder path", function (): void {
    $translationFolderPath = __DIR__ . "/misc/lang";

    RequestValidator::setTranslationFolderPath($translationFolderPath);

    expect(RequestValidator::getTranslationFolderPath())->toBe($translationFolderPath);
});

it("should throw an exception if the translation folder does not exist", function (): void {
    $this->expectException(FolderNotFoundException::class);

    RequestValidator::setTranslationFolderPath(__DIR__ . "/misc/not-found");
});

it("should set the folder in the exception if the translation folder does not exist", function (): void {
    $folder = __DIR__ . "/misc/not-found";

    try {
        RequestValidator::setTranslationFolderPath($folder);
    } catch (FolderNotFoundException $exception) {
        expect($exception->getFolder())->toBe($folder);
    }
});

it("should throw an exception if the path to the translation folder is not a folder", function (): void {
    $this->expectException(NotAFolderException::class);

    RequestValidator::setTranslationFolderPath(__DIR__ . "/misc/lang/en/validation.php");
});

it("should set the folder in the exception if the path to the translation folder is not a folder", function (): void {
    $folder = __DIR__ . "/misc/lang/en/validation.php";

    try {
        RequestValidator::setTranslationFolderPath($folder);
    } catch (NotAFolderException $exception) {
        expect($exception->getFolder())->toBe($folder);
    }
});

it("should return true if the validation succeeded", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["email"] = "contact@example.com";

    RequestValidator::setTranslationFolderPath(__DIR__ . "/misc/lang");

    RequestValidator::validate([
        "email" => "required|email",
    ]);

    expect(RequestValidator::succeeded())->toBeTrue();
});

it("should return false if the validation did not succeeded", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["email"] = "John Doe";

    RequestValidator::setTranslationFolderPath(__DIR__ . "/misc/lang");

    RequestValidator::validate([
        "email" => "required|email",
    ]);

    expect(RequestValidator::succeeded())->toBeFalse();
});

it("should return errors if the validation failed", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["email"] = "John Doe";

    RequestValidator::setTranslationFolderPath(__DIR__ . "/misc/lang");

    RequestValidator::validate([
        "email" => "required|email",
    ]);

    $errors = RequestValidator::getErrors();

    expect($errors->first())->toBe("The email must be a valid email address.");
});

it("should return the translated validation error", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["email"] = "John Doe";

    RequestValidator::setTranslationFolderPath(__DIR__ . "/misc/lang");
    RequestValidator::setLang("fr");

    RequestValidator::validate([
        "email" => "required|email",
    ]);

    $errors = RequestValidator::getErrors();

    expect($errors->first())->toBe("Le champ adresse email doit être une adresse email valide.");
});

it("should throw an exception if the lang is empty", function (): void {
    $this->expectException(InvalidArgumentException::class);

    RequestValidator::setLang("");
});
