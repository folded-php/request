<?php

declare(strict_types = 1);

use Folded\FolderNotFoundException;
use Folded\NotAFolderException;
use Folded\RequestValidator;
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

it("should throw an exception if the path is not a folder", function (): void {
    $this->expectException(NotAFolderException::class);

    setRequestValidationTranslationFolderPath(__DIR__ . "/misc/lang/en/validation.php");
});
