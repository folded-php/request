<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("Folded\getOldRequestValue")) {
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
     * echo getOldRequestValue("email");
     */
    function getOldRequestValue(string $key)
    {
        return Request::getOldValue($key);
    }
}
