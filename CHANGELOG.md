# Changelog

All notable changes to the Moneybag PHP SDK will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0-beta.1] - 2025-01-27

### Added
- Initial beta release of the Moneybag PHP SDK
- `MoneybagClient` class for API interactions
- Checkout session creation with `createCheckout()` method
- Payment verification with `verifyPayment()` method
- Comprehensive request/response models:
  - `CheckoutRequest` with full validation
  - `CheckoutResponse` for checkout session details
  - `VerifyResponse` for payment verification
  - Supporting models: `Customer`, `OrderItem`, `Shipping`, `PaymentInfo`
- Custom exception hierarchy:
  - `MoneybagException` - Base exception
  - `ApiException` - API communication errors
  - `ValidationException` - Input validation errors
- Input validation for all required fields
- Support for optional fields (shipping, order items, metadata)
- Flexible base URL configuration
- PSR-4 autoloading compliance
- Comprehensive test suite (unit, functional, integration)
- Usage examples for checkout and verification flows
- Full documentation with code examples

### Security
- SSL certificate verification enabled by default
- API key header authentication
- Input sanitization and validation

### Known Issues
- This is a beta release for testing and feedback
- API may undergo minor changes before stable release
- Not recommended for production use yet

[Unreleased]: https://github.com/moneybag/moneybag-sdk-php/compare/v1.0.0-beta.1...HEAD
[1.0.0-beta.1]: https://github.com/moneybag/moneybag-sdk-php/releases/tag/v1.0.0-beta.1