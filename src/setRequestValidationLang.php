<?php

declare(strict_types = 1);

namespace Folded;

if (!function_exists("Folded\setRequestValidationLang")) {
    /**
     * Set the lang that is used to return the validation error messages.
     * By default, the "en" lang is used.
     *
     * @param string $lang The lang to use to display the error messages.
     *
     * @since 0.1.0
     *
     * @example
     * setRequestValidationLang("fr");
     */
    function setRequestValidationLang(string $lang): void
    {
        RequestValidator::setLang($lang);
    }
}
