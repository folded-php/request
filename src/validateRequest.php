<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("validateRequest")) {
    /**
     * Validate the request data.
     *
     * @param array $rules An associative array, which link a request key name and its validation rules.
     *
     * @see https://laravel.com/docs/7.x/validation#available-validation-rules To get a list of all available validation.
     *
     * @example
     * validateRequest([
     *  "email" => "required|filled",
     * ]);
     */
    function validateRequest(array $rules): void
    {
        RequestValidator::validate($rules);
    }
}
