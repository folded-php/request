<?php

declare(strict_types = 1);

use Folded\Request;
use function Folded\getOldRequestValue;
use function Folded\storeOldRequestValues;

beforeEach(function (): void {
    Request::clear();
    $_POST = [];

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
});

it("should get the old value", function (): void {
    $key = "email";
    $value = "contact@example.com";

    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST[$key] = $value;

    storeOldRequestValues();

    expect(getOldRequestValue($key))->toBe($value);
});
