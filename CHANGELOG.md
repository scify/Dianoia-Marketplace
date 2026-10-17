# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project adheres to
[Semantic Versioning](https://semver.org/spec/v2.0.0.html). The version is defined in `package.json`; see
"Releasing" in `README.md`.

## [Unreleased]

### Added

- `AGENTS.md` with guidance for AI coding agents; `CLAUDE.md` imports it.

### Changed

- The README has a table of contents.

## [1.1.0] - 2026-10-17

### Upgrade notes

This release changes how the application is built and configured. Before you deploy it:

- Install Node.js 24.21.0 on the build machine and build with `npm ci && npm run build` (Vite writes to
  `public/build`; the `npm run prod` script no longer exists).
- In `.env`, rename `MIX_SENTRY_DSN_PUBLIC` to `VITE_SENTRY_DSN_PUBLIC`, and delete `MIX_APP_URL`, `VITE_APP_URL`
  and `APP_VERSION`.
- Make sure that `APP_URL` matches the host name that users open: requests for other hosts now get HTTP 400.
- Check the `user_roles` table for unexpected administrators (role 1). Earlier versions let any member grant
  themselves the admin role.

### Added

- Composer scripts: `setup`, `test`, `test:coverage`, `lint:check` and `lint:fix`.
- Feature tests for pages, access control, metadata endpoints, ratings, the mobile API and the profile forms. They
  run on SQLite in memory, with a guard that refuses to reset any other database.
- CI and security checks through the shared SciFY workflows (`ci.yml`, `security.yml`).
- Larastan (PHPStan) static analysis with a baseline, and an ESLint flat configuration with Vue 2 rules.
- npm supply-chain settings in `.npmrc` (`ignore-scripts`, `min-release-age=7`, `engine-strict`).
- This changelog and a documented release process.

### Changed

- The frontend is built with Vite 7 instead of Laravel Mix and webpack.
- Node.js 24.21.0 is required (`.nvmrc`, `engines` in `package.json`).
- The application version comes from `package.json` instead of the `APP_VERSION` environment variable.
- The frontend builds API URLs from the runtime base URL instead of a build-time `VITE_APP_URL`.
- The server, not the browser, calculates the average rating of an exercise.
- Deleting an exercise is a `DELETE` request.
- The README is rewritten around the Composer scripts, with a deployment checklist.
- The PHP code is formatted with Pint, and `phpunit.xml` uses the PHPUnit 11 schema.

### Removed

- Laravel Mix, webpack and their loaders.
- Routes to controller methods that did not exist (they returned HTTP 500).
- The public endpoint that set an exercise's average rating.
- The StackShare files `techstack.md` and `techstack.yml`.

### Fixed

- Deleting an exercise without an image failed with HTTP 500.
- Uploading a PDF to an exercise without one failed.
- An admin who saved their own profile lost the admin role.
- An admin edit made the admin the owner of the exercise.
- The profile forms showed the wrong user type for admins.
- Registration with an unknown role failed with HTTP 500.
- Mobile ratings by exercise id failed, and rating updates without a matching previous rating failed with HTTP 500.
- `/js/translations.js` cleared the whole application cache on every page view.
- Inline scripts that use jQuery ran before jQuery was loaded.

### Security

- Users can update only their own profile and cannot change their own role (privilege escalation).
- Only the creator or an administrator can edit or delete an exercise; deletion requires CSRF protection.
- Only administrators can approve or reject exercises.
- User lists, reports and report responses require an administrator; public exercise data contains only the
  creator's id and name.
- Ratings require a login and use the logged-in user; the mobile API accepts ratings only for approved exercises.
- Pending and rejected exercises are visible only to administrators and to their creator, also in the mobile API.
- `TrustHosts` accepts only the application host and its subdomains.
- Composer and npm packages with security advisories are updated.

## [1.0.0]

The state of the application before release tags were introduced. It is not tagged.

[Unreleased]: https://github.com/scify/Dianoia-Marketplace/compare/v1.1.0...HEAD
[1.1.0]: https://github.com/scify/Dianoia-Marketplace/compare/57960ac...v1.1.0
