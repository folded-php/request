# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.3.3] 2020-10-03

### Fixed

- Updated dependency `folded/exception` to version 0.4.\*.

## [0.3.2] 2020-10-01

### Fixed

- Added missing namespace `Folded` in the `function_exists` statements.

## [0.3.1] 2020-09-22

### Fixed

- Updated dependencies.

## [0.3.0] 2020-09-18

### Added

- New method `storeOldRequestValues()` to store form values (and being able to retreive them later).
- New method `getOldRequestValue("email")` to get a previously submitted form value.

## [0.2.0] 2020-09-06

### Breaking

- Exception `Folded\FolderNotFoundException` namespace renamed for `Folded\Exceptions\FolderNotFoundException`.
- Exception `Folded\NotAFolderException` namespace renamed for `Folded\Exceptions\NotAFolderException`.

## [0.1.0] 2020-09-06

### Added

- First working version.
