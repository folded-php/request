<?php

declare(strict_types = 1);

use Folded\Request;
use function Folded\getAllRequestValues;

beforeEach(function (): void {
    Request::clear();
    $_POST = [];
});

it("should return all the request values", function (): void {
    $data = [
        "email" => "contact@example.com",
        "name" => "John Doe",
    ];

    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST = $data;

    expect(getAllRequestValues())->toBe($data);
});

it("should return an empty array if no values in request", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_SERVER["CONTENT_TYPE"] = "multipart/form-data";

    expect(getAllRequestValues())->toBe([]);
});
