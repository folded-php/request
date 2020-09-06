<?php

declare(strict_types = 1);

use Folded\RequestValidator;
use Folded\Exceptions\NotAFolderException;
use Folded\Exceptions\FolderNotFoundException;
use function Folded\setRequestValidationTranslationFolderPath;

beforeEach(function (): void {
    RequestValidator::clear();
});

it("should set the translation folder", function (): void {
    $translationFolderPath = __DIR__ . "/misc/lang";

    setRequestValidationTranslationFolderPath($translationFolderPath);

    expect(RequestValidator::getTranslationFolderPath())->toBe($translationFolderPath);
});

it("should throw an exception if the folder is not found", function (): void {
    $this->expectException(FolderNotFoundException::class);

    setRequestValidationTranslationFolderPath(__DIR__ . "/misc/not-found");
});

it("should set the folder path if the exception when the folder is not found", function (): void {
    $folder = __DIR__ . "/misc/not-found";

    try {
        setRequestValidationTranslationFolderPath($folder);
    } catch (FolderNotFoundException $exception) {
        expect($exception->getFolder())->toBe($folder);
    }
});

it("should throw an exception if the path is not a folder", function (): void {
    $this->expectException(NotAFolderException::class);

    setRequestValidationTranslationFolderPath(__DIR__ . "/misc/lang/en/validation.php");
});

it("should set the folder path in the exception when the path is not a folder", function (): void {
    $folder = __DIR__ . "/misc/lang/en/validation.php";

    try {
        setRequestValidationTranslationFolderPath($folder);
    } catch (NotAFolderException $exception) {
        expect($exception->getFolder())->toBe($folder);
    }
});
