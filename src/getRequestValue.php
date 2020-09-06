<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("getRequestValue")) {
    /**
     * Get a single value by its key from the request.
     *
     * @param string     $name    The name of the key in the request.
     * @param null|mixed $default A fallback value in case the key is not found.
     *
     * @throws InvalidArgumentException If the key is not found in the request and no fallback value is specified.
     *
     * @since 0.1.0
     *
     * @example
     * $value = getRequestValue("name");
     */
    function getRequestValue(string $name, $default = null)
    {
        return Request::getValue($name, $default);
    }
}
