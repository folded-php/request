<?php

declare(strict_types = 1);

use Folded\Request;

if (!function_exists("Folded\hasRequestValue")) {
    /**
     * Returns true if the request contains the value, else returns false.
     *
     * @param string $name The name of the key in the request.
     *
     * @since 0.1.0
     *
     * @example
     * if (hasRequestValue("name")) {
     *  echo "Request has value name";
     * } else {
     *  echo "Request does not have value name";
     * }
     */
    function hasRequestValue(string $name): bool
    {
        return Request::hasValue($name);
    }
}
