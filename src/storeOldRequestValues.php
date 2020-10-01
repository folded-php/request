<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("Folded\storeOldRequestValues")) {
    /**
     * Stores old forms values in session for further retrieval.
     *
     * @throws Exception If sessions are not started.
     *
     * @since 0.3.0
     *
     * @example
     * storeOldRequestValues();
     */
    function storeOldRequestValues(): void
    {
        Request::storeOldValues();
    }
}
