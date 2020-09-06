<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("setRequestValidationTranslationFolderPath")) {
    /**
     * Set the translation folder path.
     *
     * @param string $path The path to the folder that contains a folder for each lang and their validation.php file.
     *
     * @since 0.1.0
     *
     * @example
     * setRequestValidationTranslationFolderPath(__DIR__ . "/lang");
     */
    function setRequestValidationTranslationFolderPath(string $path): void
    {
        RequestValidator::setTranslationFolderPath($path);
    }
}
