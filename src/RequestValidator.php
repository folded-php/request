<?php

declare(strict_types = 1);

namespace Folded;

use InvalidArgumentException;
use Illuminate\Validation\Factory;
use Illuminate\Container\Container;
use Illuminate\Validation\Validator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Folded\Exceptions\NotAFolderException;
use Folded\Exceptions\FolderNotFoundException;

/**
 * Represent the logic for validating request data.
 *
 * @since 0.1.0
 */
final class RequestValidator
{
    /**
     * @since 0.1.0
     */
    const DEFAULT_LANG = "en";

    /**
     * The engine that holds the logic for validating request data.
     *
     * @since 0.1.0
     */
    private static ?Factory $engine = null;

    /**
     * The lang to use for the validation error messages.
     *
     * @since 0.1.0
     */
    private static string $lang = self::DEFAULT_LANG;

    /**
     * The path to the folder containing the files that holds validation error messages translated for a given language.
     *
     * @since 0.1.0
     */
    private static string $translationFolderPath = "";

    /**
     * The result of a request validation, which will tell if the validation succeeded or not, and contains the errors messages.
     *
     * @since 0.1.0
     */
    private static ?Validator $validator = null;

    /**
     * Reset the state of the properties.
     * Useful for unit tests.
     *
     * @since 0.1.0
     *
     * @example
     * RequestValidator::clear();
     */
    public static function clear(): void
    {
        self::$engine = null;
        self::$validator = null;
        self::$translationFolderPath = "";
        self::$lang = self::DEFAULT_LANG;
    }

    /**
     * Returns an object that is traversable, containing the errors messages.
     *
     * @since 0.1.0
     * @see https://laravel.com/docs/7.x/validation#working-with-error-messages For more information about how to traverse this object.
     *
     * @example
     * $errors = RequestValidator::getErrors();
     *
     * foreach ($errors as $error) {
     *  echo $error->message();
     * }
     */
    public static function getErrors()
    {
        return self::$validator instanceof Validator ? self::$validator->errors() : [];
    }

    /**
     * Get the translation folder path.
     *
     * @since 0.1.0
     *
     * @example
     * $path = RequestValidator::getTranslationFolderPath();
     */
    public static function getTranslationFolderPath(): string
    {
        return self::$translationFolderPath;
    }

    /**
     * Set the lang that is used to return the validation error messages.
     * By default, the "en" lang is used.
     *
     * @param string $lang The lang to use to display the error messages.
     *
     * @since 0.1.0
     *
     * @example
     * RequestValidator::setLang("fr");
     */
    public static function setLang(string $lang): void
    {
        if (empty(trim($lang))) {
            throw new InvalidArgumentException("lang is empty");
        }

        self::$lang = $lang;
    }

    /**
     * Set the translation folder path.
     *
     * @param string $path The path to the folder that contains a folder for each lang and their validation.php file.
     *
     * @since 0.1.0
     *
     * @example
     * RequestValidator::setTranslationFolderPath(__DIR__ . "/lang");
     */
    public static function setTranslationFolderPath(string $path): void
    {
        if (!file_exists($path)) {
            throw (new FolderNotFoundException("folder $path does not exist"))->setFolder($path);
        }

        if (!is_dir($path)) {
            throw (new NotAFolderException("$path is not a folder"))->setFolder($path);
        }

        self::$translationFolderPath = $path;
    }

    /**
     * Returns true if the last validation succeeded, else returns false.
     *
     * @since 0.1.0
     *
     * @example
     * if (RequestValidation::succeeded()) {
     *  echo "request validation succeeded";
     * } else {
     *  echo "request validation failed";
     * }
     */
    public static function succeeded(): bool
    {
        return self::$validator instanceof Validator && self::$validator->passes();
    }

    /**
     * Validate the request data.
     *
     * @param array $rules An associative array, which link a request key name and its validation rules.
     *
     * @see https://laravel.com/docs/7.x/validation#available-validation-rules To get a list of all available validation.
     *
     * @example
     * RequestValidator::validate([
     *  "email" => "required|filled",
     * ]);
     */
    public static function validate(array $rules): void
    {
        self::$validator = self::engine()->make(getAllRequestValues(), $rules);
    }

    /**
     * Returns the engine that is responsible for validating the request data, if not set up yet (acting as a singleton).
     *
     * @since 0.1.0
     *
     * @example
     * $engine = RequestValidator::engine();
     */
    private static function engine(): Factory
    {
        if (!(self::$engine instanceof Factory)) {
            $loader = new FileLoader(new Filesystem(), self::$translationFolderPath);
            $translator = new Translator($loader, self::$lang);
            self::$engine = new Factory($translator, new Container());
        }

        return self::$engine;
    }
}
