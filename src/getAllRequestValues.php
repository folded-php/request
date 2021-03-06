<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("Folded\getAllRequestValues")) {
    /**
     * Get all the values in the request data.
     *
     * @return array<string, mixed>
     *
     * @since 0.1.0
     *
     * @example
     * $values = getAllRequestValues();
     *
     * foreach ($values as $name => $value) {
     *  echo "Value $name contains $value";
     * }
     */
    function getAllRequestValues(): array
    {
        return Request::getAllValues();
    }
}
