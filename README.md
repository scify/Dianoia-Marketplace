# Dianoia Marketplace

[![CI](https://github.com/scify/Dianoia-Marketplace/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/scify/Dianoia-Marketplace/actions/workflows/ci.yml)
[![Security](https://github.com/scify/Dianoia-Marketplace/actions/workflows/security.yml/badge.svg)](https://github.com/scify/Dianoia-Marketplace/actions/workflows/security.yml)
[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](LICENCE.md)
[![GitHub Issues](https://img.shields.io/github/issues/scify/Dianoia-Marketplace)](https://github.com/scify/Dianoia-Marketplace/issues)

A marketplace web application where carers create and share exercises for people with dementia. Administrators review
each exercise; approved exercises that are marked for the API also appear in the Dianoia mobile app.

[Project URL](https://dianoia.scify.org/)

## Tech stack

- **Backend:** Laravel 12, PHP 8.2 or newer (CI runs PHP 8.4), MySQL
- **Frontend:** Vue 2.7, Vite 7, Bootstrap 5, Sass, jQuery
- **Tooling:** PHPUnit, Laravel Pint, Larastan (PHPStan), ESLint

## Requirements

- PHP 8.2 or newer, with the extensions that Laravel needs, plus `pdo_mysql`, `pdo_sqlite` (for tests) and `zip`
- [Composer](https://getcomposer.org/)
- Node.js **24.21.0** and npm 11.19 or newer. The version is pinned in `.nvmrc`; with
  [nvm](https://github.com/nvm-sh/nvm), run `nvm use`
- MySQL (or MariaDB)

## Getting started

1. Install everything with one command:

   ```bash
   composer setup
   ```

   It creates `.env` from `.env.example` (only if `.env` is missing), installs the PHP and npm dependencies, generates
   `APP_KEY` (only if it is empty), links `public/storage` to `storage/app/public` and builds the frontend. You can run it
   again at any time.

2. Edit `.env`:
   - `DB_*`: the connection to an existing, empty MySQL database
   - `APP_URL`: the URL you use to open the app, for example `http://localhost:8000`
   - `DEFAULT_ADMIN_USER_PASSWORD_FOR_SEED` and `DEFAULT_TEST_USER_PASSWORD_FOR_SEED`: passwords for the seeded accounts

3. Create the tables and the starter data:

   ```bash
   php artisan migrate --seed
   ```

   The seeders create the lookup data and two accounts: `admin-dianoia@scify.org` (administrator) and `test@scify.org`.

4. Start the app and the Vite dev server in two terminals:

   ```bash
   php artisan serve
   npm run dev
   ```

### npm supply-chain settings

`.npmrc` hardens npm for this project. CI checks these settings:

- `ignore-scripts=true`: npm does not run install scripts of dependencies
- `min-release-age=7`: npm installs only package versions that are at least 7 days old
- `engine-strict=true`: npm refuses to install with a Node or npm version outside `engines` in `package.json`

Use `npm ci` to install exactly what `package-lock.json` specifies.

## Tests

```bash
composer test            # run the test suite
composer test:coverage   # the same, with a coverage summary and an HTML report in coverage/
```

The tests run on SQLite in memory (see `phpunit.xml`). They never use the database in `.env`: `tests/TestCase.php`
refuses to reset any database except SQLite in memory, and `composer test` clears a cached configuration first.
`composer test:coverage` needs [PCOV](https://github.com/krakjoe/pcov) or [Xdebug](https://xdebug.org/).

## Code quality

The project uses three tools:

- [Laravel Pint](https://laravel.com/docs/pint) for the PHP code style (rules in `pint.json`)
- [Larastan](https://github.com/larastan/larastan) (PHPStan) for static analysis of `app/` (settings in `phpstan.neon`;
  known errors are in `phpstan-baseline.neon`, and new code must not add entries)
- [ESLint](https://eslint.org/) for `resources/js` (rules in `eslint.config.js`)

```bash
composer lint:check   # run all three tools; report problems, change nothing
composer lint:fix     # fix the PHP style and the JavaScript, then report what PHPStan still finds
```

`lint:check` stops at the first tool that reports a problem. PHPStan cannot fix code, so after `lint:fix` you fix the
remaining PHPStan errors by hand. CI runs the same checks.

## Continuous integration

The repository uses the shared [SciFY workflows](https://github.com/scify/.github):

- `ci.yml` (`laravel-ci.yml`) runs on pull requests and on pushes to `master`: Pint, PHPStan, ESLint, the frontend
  build and the tests. The required check is **`ci / CI`**.
- `security.yml` runs on pull requests and every Monday: secret scanning, npm supply-chain checks, `composer audit`
  and `npm audit`.

Dependabot opens pull requests for security updates only. `dependabot_auto_merge.yml` merges the minor and patch
updates after the required checks pass.

## Deployment

A deployment needs these steps:

1. Node.js 24.21.0 on the build machine; build the frontend with `npm ci && npm run build`. The build writes to
   `public/build`.
2. `composer install --no-dev --optimize-autoloader`
3. `.env` for production:
   - `APP_ENV=production`, `APP_DEBUG=false`
   - `APP_URL` must match the host name that users open. Outside the `local` environment, `TrustHosts` accepts only
     the `APP_URL` host and its subdomains, and answers other hosts with HTTP 400. If a reverse proxy is in front of
     the app, make sure that it forwards the original `Host` header.
   - `MAIL_*`: the app sends notifications (approvals, rejections, reports) by email.
   - `SENTRY_LARAVEL_DSN` for backend error reporting.
   - `VITE_SENTRY_DSN_PUBLIC` for frontend error reporting. Vite reads `VITE_*` values at build time, so set them
     before `npm run build`.
4. `php artisan migrate --force`, `php artisan storage:link`, then `php artisan config:cache`, `route:cache` and
   `view:cache`.
5. The web server's user must be able to write to `storage/` and `bootstrap/cache/`.
   `sudo ./set-file-permissions.sh www-data <deploy-user> .` sets the owner group and the permissions.
6. The web server's document root is `public/`.
7. Run the scheduler every minute (it prunes stale cache tags every hour):

   ```text
   * * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1
   ```

8. If you set `QUEUE_CONNECTION` to anything other than `sync`, run a queue worker (`php artisan queue:work`) under a
   process manager such as Supervisor. The email notifications are queued.

## Sitemap

[Spatie Laravel Sitemap](https://github.com/spatie/laravel-sitemap) creates `public/sitemap.xml` (not in git):

```bash
php artisan sitemap:generate
```

## Debugging

Install [Xdebug](https://xdebug.org/), set `xdebug.mode=debug`, and start listening for debug connections in your IDE
(for example PhpStorm). A browser extension such as Xdebug Helper starts the debug session for a page.

## License

Apache License 2.0. See [LICENCE.md](LICENCE.md).
