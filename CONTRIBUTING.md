# Contributing to Moneybag PHP SDK

We love your input! We want to make contributing to the Moneybag PHP SDK as easy and transparent as possible, whether it's:

- Reporting a bug
- Discussing the current state of the code
- Submitting a fix
- Proposing new features
- Becoming a maintainer

## Development Process

We use GitHub to host code, to track issues and feature requests, as well as accept pull requests.

1. Fork the repo and create your branch from `main`.
2. If you've added code that should be tested, add tests.
3. If you've changed APIs, update the documentation.
4. Ensure the test suite passes.
5. Make sure your code follows the existing style.
6. Issue that pull request!

## Code Style

- Follow PSR-12 coding standards
- Use meaningful variable and method names
- Add PHPDoc comments for all public methods
- Keep methods focused and small

### Running Code Style Checks

```bash
composer cs-fix
```

## Testing

### Running Tests

```bash
# Run all tests
composer test

# Run only unit tests
vendor/bin/phpunit tests/Unit

# Run only integration tests (requires API key)
vendor/bin/phpunit tests/Integration
```

### Writing Tests

- Write unit tests for new functionality
- Mock external dependencies in unit tests
- Integration tests should be idempotent
- Use descriptive test method names

## Pull Request Process

1. Update the README.md with details of changes to the interface, if applicable.
2. Update the CHANGELOG.md with notes on your changes.
3. The PR will be merged once you have the sign-off of at least one maintainer.

## Any contributions you make will be under the MIT Software License

In short, when you submit code changes, your submissions are understood to be under the same [MIT License](LICENSE) that covers the project. Feel free to contact the maintainers if that's a concern.

## Report bugs using GitHub's [issue tracker](https://github.com/moneybag/moneybag-sdk-php/issues)

We use GitHub issues to track public bugs. Report a bug by [opening a new issue](https://github.com/moneybag/moneybag-sdk-php/issues/new).

**Great Bug Reports** tend to have:

- A quick summary and/or background
- Steps to reproduce
  - Be specific!
  - Give sample code if you can.
- What you expected would happen
- What actually happens
- Notes (possibly including why you think this might be happening, or stuff you tried that didn't work)

## License

By contributing, you agree that your contributions will be licensed under its MIT License.