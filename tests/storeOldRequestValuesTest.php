<?php

declare(strict_types = 1);

use Folded\Request;
use function Folded\storeOldRequestValues;

beforeEach(function (): void {
    Request::clear();
    $_POST = [];

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
});

it("should store old values", function (): void {
    $data = [
        "email" => "contact@example.com",
    ];

    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST = $data;

    storeOldRequestValues();

    expect($_SESSION["__folded_old_values"])->toBe($data);
});
