# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.2.0] - 2026-08-19

### Changed

- The minimum supported PHP version is now 8.2.
- `Dispatcher`, `RequestInterceptor`, and `ResponseHandler` are now readonly classes.
- The package now requires `hakone/untouchable-psr7` `^1.1`.
- GitHub source archives now exclude development files and only ship `LICENSE`, `README.md`, `composer.json`, and `src/`.

[Unreleased]: https://github.com/hakonephp/middleware-dispatcher/compare/0.2.0...HEAD
[0.2.0]: https://github.com/hakonephp/middleware-dispatcher/compare/0.1.0...0.2.0
