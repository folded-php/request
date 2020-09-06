# folded/request

Request utilities, including a request validator, for your PHP web app.

[![Packagist License](https://img.shields.io/packagist/l/folded/request)](https://github.com/folded-php/request/blob/master/LICENSE) [![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/folded/request)](https://github.com/folded-php/request/blob/master/composer.json#L14) [![Packagist Version](https://img.shields.io/packagist/v/folded/request)](https://packagist.org/packages/folded/request) [![Build Status](https://travis-ci.com/folded-php/request.svg?branch=master)](https://travis-ci.com/folded-php/request) [![Maintainability](https://api.codeclimate.com/v1/badges/a00ce29a5b549d6f2ba4/maintainability)](https://codeclimate.com/github/folded-php/request/maintainability)

## Summary

- [About](#about)
- [Requirements](#requirements)
- [Installation](#installation)
- [Examples](#examples)
- [Version support](#version-support)

## About

I need a way to pull a simple library to validate my request data when a form is submited. This library hopefuly solves this by faciliting the set up to be ready to validate request values.

Folded is a constellation of packages to help you setting up a web app easily, using ready to plug in packages.

- [folded/config](https://github.com/folded-php/config): Configuration and environment utilities for your PHP web app.
- [folded/routing](https://github.com/folded-php/routing): Routing functions for your PHP web app.
- [folded/view](https://github.com/folded-php/view): View utilities for your PHP web app.

## Requirements

- PHP version >= 7.4.0
- Composer installed

## Installation

- [1. Install the package](#1-install-the-package)
- [2. Set up the library](#2-set-up-the-library)

### 1. Install the package

In your root folder directory, run this command:

```bash
composer require folded/request
```

### 2. Set up the library

If you want to use the request validation functions, use this code before validating your form data:

```php
use function Folded\setRequestValidationTranslationFolderPath;

setRequestValidationTranslationFolderPath(__DIR__ . "/lang");
```

The lang folder should contain an arborescence made of folders named with the lang (like "en", "fr", "es", ...), which themselves contain a file named `validation.php` containing the translation of the validation error message.

As this library relies on Laravel's validation system, the validation errors messages are pulled from these files.

Here is [the content](https://github.com/laravel/laravel/blob/v7.25.0/resources/lang/en/validation.php) of `en/validation.php` for example. You can start from this file to create translation for other languages.

## Examples

- [1. Get a request value by its key](#1-get-a-request-value-by-its-key)
- [2. Check if a request key is present](#2-check-if-a-request-key-is-present)
- [3. Get all the request values](#3-get-all-the-request-values)
- [4. Validate a request](#4-validate-a-request)
- [5. Check if a request validation succeeded](#5-check-if-a-request-validation-succeeded)
- [6. Get error messages after a request validation](#6-get-error-messages-after-a-request-validation)
- [7. Choosing the validation error language before validating request](#7-choosing-the-validation-error-language-before-validating-request)

### 1. Get a request value by its key

In this example, we will get the value of a request key after a post request has been submitted.

```php
use function Folded\getRequestValue;

echo getRequestValue("name");
```

### 2. Check if a request key is present

In this example, we will check first if a key is present before echoing its content.

```php
use function Folded\getRequestValue;
use function Folded\hasRequestValue;

if (hasRequestValue("name")) {
  echo getRequestValue("name");
} else {
  echo "Request does not have key name.";
}
```

### 3. Get all the request values

In this example, we will get all the request value key-pairs in an array.

```php
use function Folded\getAllRequestValues;

$values = getAllRequestValues();

foreach ($values as $name => $value) {
  echo "Post value for $name is $value";
}
```

### 4. Validate a request

In this example, we will validate form request data.

```php
use function Folded\validateRequest;

validateRequest([
  "name" => "required|filled",
]);
```

For more information about the available validation, check [Laravel's validation documentation](https://laravel.com/docs/7.x/validation#available-validation-rules), as this library relies on this system.

### 5. Check if a request validation succeeded

In this example, we will check if a request succeeded after validating it.

```php
use function Folded\validateRequest;
use function Folded\requestValidationSucceeded;

validateRequest([
  "name" => "required|filled",
]);

if (requestValidationSucceeded()) {
  echo "it worked!";
} else {
  echo "some errors occured...";
}
```

### 6. Get error messages after a request validation

In this example, we will get the errors messages of a failed request validation.

```php
use function Folded\validateRequest;
use function Folded\requestValidationSucceeded;
use function Folded\getRequestValidationErrors;

validateRequest([
  "email" => "required|filled",
]);

if (!requestValidationSucceeded()) {
  $errors = getRequestValidationErrors();

  foreach ($errors as $error) {
    echo "error: {$error->message()}";
  }
}
```

For more information about how to manipulate the errors, see [Laravel's validation error documentation](https://laravel.com/docs/7.x/validation#working-with-error-messages), as this library relies on this system.

### 7. Choosing the validation error language before validating request

In this example, before validating the request, we will change the language for the validation erorrs. Note that you should do it ideally right after the code from the Installation section: [2. Set up the library](#2-set-up-the-library) section.

```php
use function Folded\setRequestValidationLang;
use function Folded\setRequestValidationTranslationFolderPath;

setRequestValidationTranslationFolderPath(__DIR__ . "/lang");
setRequestValidationLang("fr");
```

## Version support

|        | 7.3 | 7.4 | 8.0 |
| ------ | --- | --- | --- |
| v0.1.0 | ❌  | ✔️  | ❓  |
