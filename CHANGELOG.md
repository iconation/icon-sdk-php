# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.2.1] - 2020-08-18
### Added
- Added a test

### Changed
- IconService::getTransactionResult returns the calculated transaction fee
- Removed unused vars from tests

## [1.2.0] - 2020-07-26
### Changed
- IconServiceHelper::sendRequest throws exception on invalid curl request
- TransactionBuilder::send() handles the exception and returns Object or null
- Removed unnecessary TODOs

## [1.1.0] - 2020-06-11
### Added
- README, added requirements and installation instructions
- composer.json, added ext-bcmath as requirement

### Changed
- Helpers::icxToHex() and Helpers::hexToIcx() refactored using bcmath and gmp
- applied stricter parameter types
- bumped required php version 7.1 -> 7.2

### Removed
- extra unused functions and variable in Transaction

## [1.0.1] - 2020-06-09

### Added
- Changelog
- Security Policy

## [1.0.0] - 2020-06-09

### Added
- Iconservice
- IRC2
- IISS
- TransactionBuilder
- Helpers
- Serializer
- Wallet