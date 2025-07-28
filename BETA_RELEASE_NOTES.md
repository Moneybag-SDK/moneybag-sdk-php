# Moneybag PHP SDK - Beta Release Notes

## Version 1.0.0-beta.1

Thank you for trying the beta version of the Moneybag PHP SDK! This release provides early access to our payment gateway integration tools.

### 🚀 What's Included

- **Complete API Integration**
  - Checkout session creation
  - Payment verification
  - Full request/response models

- **Developer-Friendly Features**
  - Comprehensive validation
  - Helpful error messages
  - Type-safe models
  - PSR-4 autoloading

- **Production-Ready Foundation**
  - Unit and integration tests
  - CI/CD pipeline
  - Documentation and examples

### 🧪 Testing Guidelines

1. **Test Checkout Flow**
   ```php
   $client = new MoneybagClient('your_api_key');
   $request = new CheckoutRequest($data);
   $response = $client->createCheckout($request);
   ```

2. **Test Payment Verification**
   ```php
   $response = $client->verifyPayment($transactionId);
   if ($response->isSuccessful()) {
       // Handle success
   }
   ```

3. **Test Error Handling**
   - Invalid input data
   - Network errors
   - API errors

### 📝 What We Need From You

Please help us improve by testing:

1. **Integration Experience**
   - Is the API intuitive?
   - Are the examples helpful?
   - Is anything confusing?

2. **Error Handling**
   - Are error messages clear?
   - Do validations work correctly?
   - Any unexpected behaviors?

3. **Documentation**
   - Is anything missing?
   - Are examples sufficient?
   - Any unclear sections?

### 🐛 Reporting Issues

Found a bug? Please report it:

1. Check [existing issues](https://github.com/moneybag/moneybag-sdk-php/issues)
2. Create a new issue with:
   - PHP version
   - Steps to reproduce
   - Expected vs actual behavior
   - Error messages/stack traces

### 🗓️ Beta Timeline

- **Beta Period**: 2-4 weeks
- **Stable Release**: After addressing feedback
- **Breaking Changes**: Will be documented if any

### ⚠️ Important Notes

- This is a beta release for testing
- API may have minor changes before stable release
- Not recommended for production use
- Keep your test API keys separate from production

### 📧 Contact

- **Email**: developer@fitl.com.bd
- **GitHub**: [moneybag/moneybag-sdk-php](https://github.com/moneybag/moneybag-sdk-php)

Thank you for being an early adopter! Your feedback helps us build a better SDK for everyone.