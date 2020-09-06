<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("requestValidationSucceeded")) {
    /**
     * Returns true if the last validation succeeded, else returns false.
     *
     * @since 0.1.0
     *
     * @example
     * if (requestValidationSucceeded()) {
     *  echo "request validation succeeded";
     * } else {
     *  echo "request validation failed";
     * }
     */
    function requestValidationSucceeded(): bool
    {
        return RequestValidator::succeeded();
    }
}
