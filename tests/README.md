# Moneybag PHP SDK Tests

This directory contains all tests for the Moneybag PHP SDK.

## Test Structure

```
tests/
├── Unit/              # Unit tests (no external dependencies)
│   └── ClientTest.php # Tests for Client class with mocked HTTP
├── Functional/        # Functional tests (SDK functionality)
│   ├── ValidationTest.php # Tests validation rules
│   └── DemoTest.php      # Demonstrates SDK usage
├── Integration/       # Integration tests (real API calls)
│   ├── ApiTest.php       # Basic API connectivity tests
│   └── FullFlowTest.php  # Complete checkout flow tests
└── bootstrap.php      # Test bootstrap file
```

## Running Tests

### Run all tests:
```bash
composer test
```

### Run specific test suites:
```bash
# Unit tests only
vendor/bin/phpunit tests/Unit

# Functional tests only
vendor/bin/phpunit tests/Functional

# Integration tests only (requires API key)
vendor/bin/phpunit tests/Integration
```

### Run a specific test file:
```bash
vendor/bin/phpunit tests/Unit/ClientTest.php
```

## Test Types

### Unit Tests
- Test individual components in isolation
- Mock external dependencies (HTTP client)
- Fast execution
- No network calls

### Functional Tests
- Test SDK functionality without API calls
- Validate data structures and validation rules
- Test error handling

### Integration Tests
- Test real API interactions
- Require valid API key
- Test complete workflows
- May be slower due to network calls

## Configuration

Integration tests use the API key:
```
d6e5763e.lkUS0LQi5z1qqMZ6B7Y89lgh5ZD2kuVfIsRXiH0aITo
```

To use a different API key, update the key in the integration test files.

## Writing New Tests

1. Place unit tests in `tests/Unit/`
2. Place functional tests in `tests/Functional/`
3. Place integration tests in `tests/Integration/`
4. Follow PSR-4 naming conventions
5. Use PHPUnit assertions for unit tests
6. Use descriptive test method names