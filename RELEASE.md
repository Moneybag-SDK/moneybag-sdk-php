# Release Process

This document describes the process for releasing a new version of the Moneybag PHP SDK.

## Pre-release Checklist

- [ ] All tests pass locally
- [ ] Code follows PSR-12 standards (run `composer cs-fix`)
- [ ] PHPStan analysis passes (run `composer phpstan`)
- [ ] Documentation is up to date
- [ ] CHANGELOG.md is updated with the new version
- [ ] Examples work with the latest code
- [ ] No hardcoded API keys or sensitive data

## Release Steps

1. **Update Version**
   - Update version in CHANGELOG.md
   - Create a new section for the release with date

2. **Create Release Branch**
   ```bash
   git checkout -b release/v1.0.0
   ```

3. **Final Checks**
   ```bash
   composer validate
   composer test
   composer cs-fix
   composer phpstan
   ```

4. **Commit Changes**
   ```bash
   git add .
   git commit -m "Prepare release v1.0.0"
   ```

5. **Create Pull Request**
   - Create PR from release branch to main
   - Wait for CI/CD to pass
   - Get approval from maintainers

6. **Merge and Tag**
   ```bash
   git checkout main
   git merge --no-ff release/v1.0.0
   git tag -a v1.0.0 -m "Release version 1.0.0"
   git push origin main --tags
   ```

7. **Create GitHub Release**
   - Go to GitHub releases page
   - Create new release from tag
   - Copy release notes from CHANGELOG.md
   - Publish release

8. **Submit to Packagist**
   - If not auto-synced, update on packagist.org
   - Verify package is available via Composer

## Post-release

- [ ] Announce release on relevant channels
- [ ] Update documentation site if needed
- [ ] Close related issues and PRs
- [ ] Plan next release milestones

## Version Numbering

We follow [Semantic Versioning](https://semver.org/):

- **MAJOR** version for incompatible API changes
- **MINOR** version for backwards-compatible functionality
- **PATCH** version for backwards-compatible bug fixes

Examples:
- Breaking change: 1.0.0 → 2.0.0
- New feature: 1.0.0 → 1.1.0
- Bug fix: 1.0.0 → 1.0.1