<?php

declare(strict_types = 1);

use Folded\Request;

beforeEach(function (): void {
    Request::clear();
    $_POST = [];
});

it("should return the request value", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["search"] = "foo";

    expect(Request::getValue("search"))->toBe("foo");
});

it("should return all the request values", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["search"] = "foo";
    $_POST["filter"] = "bar";

    expect(Request::getAllValues())->toBe([
        "search" => "foo",
        "filter" => "bar",
    ]);
});

it("should return true if the request is present", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["search"] = "foo";

    expect(Request::hasValue("search"))->toBeTrue();
});

it("should return false if the request is not present", function (): void {
    $_SERVER["REQUEST_METHOD"] = "POST";
    $_POST["search"] = "foo";

    expect(Request::hasValue("filter"))->toBeFalse();
});
