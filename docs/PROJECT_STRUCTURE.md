# Project Structure

## Directory Layout

```
moneybag-sdk-php/
├── .github/
│   └── workflows/
│       └── tests.yml           # CI/CD pipeline
├── docs/
│   └── PROJECT_STRUCTURE.md    # This file
├── examples/
│   ├── checkout.php            # Checkout flow example
│   └── verify.php              # Payment verification example
├── src/
│   └── Moneybag/
│       ├── MoneybagClient.php  # Main SDK client
│       ├── Exceptions/
│       │   ├── MoneybagException.php    # Base exception
│       │   ├── ApiException.php         # API errors
│       │   └── ValidationException.php  # Validation errors
│       └── Models/
│           ├── CheckoutRequest.php      # Checkout request model
│           ├── CheckoutResponse.php     # Checkout response model
│           ├── VerifyResponse.php       # Verification response model
│           ├── Customer.php             # Customer information
│           ├── OrderItem.php            # Order item details
│           ├── Shipping.php             # Shipping information
│           └── PaymentInfo.php          # Payment configuration
├── tests/
│   ├── Unit/                   # Unit tests
│   ├── Functional/             # Functional tests
│   ├── Integration/            # Integration tests
│   ├── bootstrap.php           # Test bootstrap
│   └── README.md               # Test documentation
├── .editorconfig               # Editor configuration
├── .gitignore                  # Git ignore rules
├── .php-cs-fixer.php          # Code style configuration
├── CHANGELOG.md                # Version history
├── CONTRIBUTING.md             # Contribution guidelines
├── LICENSE                     # MIT License
├── README.md                   # Main documentation
├── RELEASE.md                  # Release process
├── composer.json               # Package definition
├── phpstan.neon               # Static analysis config
└── phpunit.xml.dist           # PHPUnit configuration
```

## Key Components

### Client
- `MoneybagClient` - Main entry point for API interactions

### Models
- Request/Response models with validation
- Type-safe data structures
- Automatic serialization/deserialization

### Exceptions
- Hierarchical exception structure
- Specific exceptions for different error types
- Helpful error messages

### Testing
- Unit tests with mocked dependencies
- Functional tests for validation
- Integration tests for API communication

## Development Workflow

1. Make changes in `src/`
2. Add/update tests in `tests/`
3. Run `composer test`
4. Fix code style with `composer cs-fix`
5. Run static analysis with `composer phpstan`
6. Update documentation
7. Submit pull request