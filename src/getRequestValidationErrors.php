<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("getRequestValidationErrors")) {
    /**
     * Returns an object that is traversable, containing the errors messages.
     *
     * @since 0.1.0
     * @see https://laravel.com/docs/7.x/validation#working-with-error-messages For more information about how to traverse this object.
     *
     * @example
     * $errors = getRequestValidationErrors();
     *
     * foreach ($errors as $error) {
     *  echo $error->message();
     * }
     */
    function getRequestValidationErrors()
    {
        return RequestValidator::getErrors();
    }
}
