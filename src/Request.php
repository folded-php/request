<?php

declare(strict_types = 1);

namespace Folded;

use Exception;
use InvalidArgumentException;
use Illuminate\Http\Request as IlluminateRequest;

/**
 * Represents an HTTP request.
 *
 * @since 0.1.0
 */
final class Request
{
    const OLD_VALUES_KEY_NAME = "__folded_old_values";

    /**
     * The engine that is responsible for fetching the request values.
     *
     * @since 0.1.0
     */
    private static ?IlluminateRequest $engine = null;

    /**
     * Reset the state of the properties to their initial state.
     * Useful for unit tests.
     *
     * @since 0.1.0
     *
     * @example
     * Request::clear();
     */
    public static function clear(): void
    {
        self::$engine = null;
    }

    /**
     * Returns the engine, and set it up if it has not been set up yet (acting as a singleton).
     *
     * @since 0.1.0
     *
     * @example
     * $engine = Request::engine();
     */
    public static function engine(): IlluminateRequest
    {
        if (self::$engine === null) {
            self::$engine = IlluminateRequest::capture();
        }

        return self::$engine;
    }

    /**
     * Get all the values in the request data.
     *
     * @return array<string,mixed>
     *
     * @since 0.1.0
     *
     * @example
     * $values = Request::getAllValues();
     *
     * foreach ($values as $name => $value) {
     *  echo "Value $name contains $value";
     * }
     */
    public static function getAllValues(): array
    {
        return self::engine()->request->all();
    }

    /**
     * Get the old value of a previously submited form.
     *
     * @param string $key The name of the key holding the form value.
     *
     * @throws Exception If sessions are not enabled yet.
     *
     * @return null|mixed
     *
     * @since 0.3.0
     *
     * @example
     * echo Request::getOldValue("email");
     */
    public static function getOldValue(string $key)
    {
        self::checkSessionStarted();

        return $_SESSION[self::OLD_VALUES_KEY_NAME][$key] ?? null;
    }

    /**
     * Get a single value by its key from the request.
     *
     * @param string     $name    The name of the key in the request.
     * @param null|mixed $default A fallback value in case the key is not found.
     *
     * @throws InvalidArgumentException If the key is not found in the request and no fallback value is specified.
     *
     * @return mixed
     *
     * @since 0.1.0
     *
     * @example
     * $value = Request::getValue("name");
     */
    public static function getValue(string $name, $default = null)
    {
        self::checkKeyName($name);

        $value = self::engine()->request->get($name, $default);

        if ($default === null && $value === null) {
            throw new InvalidArgumentException("key $name not found");
        }

        return $value;
    }

    /**
     * Returns true if the request contains the value, else returns false.
     *
     * @param string $name The name of the key in the request.
     *
     * @since 0.1.0
     *
     * @example
     * if (Request::hasValue("name")) {
     *  echo "Request has value name";
     * } else {
     *  echo "Request does not have value name";
     * }
     */
    public static function hasValue(string $name): bool
    {
        self::checkKeyName($name);

        return self::engine()->request->has($name);
    }

    /**
     * Stores old forms values in session for further retrieval.
     *
     * @throws Exception If sessions are not started.
     *
     * @since 0.3.0
     *
     * @example
     * Request::storeOldValues();
     */
    public static function storeOldValues(): void
    {
        self::checkSessionStarted();

        $_SESSION[self::OLD_VALUES_KEY_NAME] = self::engine()->request->all();
    }

    /**
     * Throws an exception if the key name is empty.
     *
     * @throws InvalidArgumentException If the name is empty.
     *
     * @since 0.1.0
     *
     * @example
     * Request::checkKeyName("name");
     */
    private static function checkKeyName(string $name): void
    {
        if (empty(trim($name))) {
            throw new InvalidArgumentException("key is empty");
        }
    }

    /**
     * Returns true if sessions are enabled, else returns false.
     *
     * @throws Exception If sessions are not enabled.
     *
     * @since 0.3.0
     *
     * @example
     * if (Request::sessionStarted()) {
     *  echo "session started";
     * } else {
     *  echo "session not started yet";
     * }
     */
    private static function checkSessionStarted(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            throw new Exception("session not started");
        }
    }
}
