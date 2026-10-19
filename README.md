# Dianoia Marketplace

[![CI](https://github.com/scify/Dianoia-Marketplace/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/scify/Dianoia-Marketplace/actions/workflows/ci.yml)
[![Security](https://github.com/scify/Dianoia-Marketplace/actions/workflows/security.yml/badge.svg)](https://github.com/scify/Dianoia-Marketplace/actions/workflows/security.yml)
[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](LICENCE.md)
[![GitHub Issues](https://img.shields.io/github/issues/scify/Dianoia-Marketplace)](https://github.com/scify/Dianoia-Marketplace/issues)

A marketplace web application where carers create and share exercises for people with dementia. Administrators review
each exercise; approved exercises that are marked for the API also appear in the Dianoia mobile app.

[Project URL](https://dianoia.scify.org/)

## Contents

- [Tech stack](#tech-stack)
- [Requirements](#requirements)
- [Getting started](#getting-started)
  - [Everyday commands](#everyday-commands)
  - [Without DDEV](#without-ddev)
  - [npm supply-chain settings](#npm-supply-chain-settings)
- [Tests](#tests)
- [Code quality](#code-quality)
- [Continuous integration](#continuous-integration)
- [Releasing](#releasing)
- [Deployment](#deployment)
- [Cookie consent](#cookie-consent)
- [Sitemap](#sitemap)
- [Debugging](#debugging)
- [License](#license)

## Tech stack

- **Backend:** Laravel 12, PHP 8.4.1 or newer, MySQL 8.4
- **Frontend:** Vue 2.7, Vite 7, Bootstrap 5, Sass, jQuery
- **Tooling:** DDEV, PHPUnit, Laravel Pint, Larastan (PHPStan), ESLint

## Requirements

- [DDEV](https://ddev.readthedocs.io/en/stable/users/install/ddev-installation/) and Docker (on Windows, inside WSL2)
- Git

DDEV runs PHP 8.4, Composer, MySQL 8.4 and Node.js in containers, so you do not need them on your machine. The Node.js
version comes from `.nvmrc` (**24.21.0**); a DDEV start hook keeps `nodejs_version` in `.ddev/config.yaml` in sync with
it. To run the app without DDEV, see [Without DDEV](#without-ddev).

## Getting started

1. Clone the repository and start DDEV:

   ```bash
   git clone https://github.com/scify/Dianoia-Marketplace.git
   cd Dianoia-Marketplace
   ddev start
   ```

   Every `ddev start` runs `composer setup` and then the database migrations. `composer setup` creates `.env` from
   `.env.example` (only if `.env` is missing), installs the PHP dependencies and, when `package-lock.json` changed, the
   npm dependencies (`npm ci`), generates `APP_KEY` (only if it is empty), links `public/storage` to
   `storage/app/public` (a relative link, so it works on the host and in DDEV) and builds the frontend. It is safe to
   run again at any time, also by hand: `ddev composer setup`. DDEV writes the database, mail and `APP_URL` settings
   into `.env`.

2. Edit `.env`:
   - `DEFAULT_ADMIN_USER_PASSWORD_FOR_SEED` and `DEFAULT_TEST_USER_PASSWORD_FOR_SEED`: passwords for the seeded accounts
   - `MAIL_FROM_ADDRESS`: any sender address, for example `noreply@example.com`. Without it, the app cannot send its
     notification emails. DDEV catches all mail in [Mailpit](https://mailpit.axllent.org/) (`ddev mailpit`).

3. Create the starter data:

   ```bash
   ddev artisan db:seed
   ```

   The seeders create the lookup data and two accounts: `admin-dianoia@scify.org` (administrator) and `test@scify.org`.

4. For frontend work, start the Vite dev server (hot reload through port 5179):

   ```bash
   ddev npm run dev
   ```

   Talk & Play Marketplace uses the same port, so only one of the two dev servers can run at a time.

5. Open <https://dianoia-marketplace.ddev.site:8443>.

### Everyday commands

| Task | Command |
|---|---|
| Start or stop the environment | `ddev start`, `ddev stop` |
| Run Artisan, Composer or npm in the container | `ddev artisan ...`, `ddev composer ...`, `ddev npm ...` |
| Open a MySQL shell | `ddev mysql` |
| Import a database dump | `ddev import-db --file=dump.sql.gz` (runs the migrations afterwards) |
| Open Mailpit (all outgoing mail) | `ddev mailpit` |
| Show URLs and services | `ddev describe` |

### Without DDEV

You need PHP 8.4.1 or newer (with `pdo_mysql`, `pdo_sqlite` and `zip`), Composer, Node.js 24.21.0 (`nvm use`) and a
MySQL server. Then run `composer setup`, set `DB_*`, `APP_URL` and the seed passwords in `.env`, run
`php artisan migrate --seed`, and start `php artisan serve` and `npm run dev` in two terminals. DDEV rewrites
`DB_*`, `APP_URL` and the mail settings in `.env`, so keep a separate copy of `.env` for each setup. The host and DDEV
share `node_modules`: after you switch between them on a machine other than Linux (for example macOS), run `npm ci`
again in the new environment, because some packages install platform-specific binaries.

### npm supply-chain settings

`.npmrc` hardens npm for this project. CI checks these settings:

- `ignore-scripts=true`: npm does not run install scripts of dependencies
- `min-release-age=7`: npm installs only package versions that are at least 7 days old
- `engine-strict=true`: npm refuses to install with a Node or npm version outside `engines` in `package.json`

Use `npm ci` to install exactly what `package-lock.json` specifies (`composer setup` does this).

## Tests

```bash
ddev composer test   # run the test suite
ddev coverage        # the same, with a coverage summary and an HTML report in coverage/
```

The tests run on SQLite in memory (see the `<server>` values in `phpunit.xml`). They never use the DDEV MySQL database:
`<server>` values override the database variables that DDEV sets in the container, `tests/TestCase.php` refuses to
reset any database except SQLite in memory, and `composer test` clears a cached configuration first. `phpunit.xml`
also fixes `APP_URL`, so the tests do not depend on `.env`.
`ddev coverage` turns Xdebug on for the run and then restores its previous state (also when a test fails), because
Xdebug slows down every request. It runs `composer test:coverage`, which needs a coverage driver such as Xdebug or PCOV.
Without DDEV, run `composer test` and `composer test:coverage`.

## Code quality

The project uses three tools:

- [Laravel Pint](https://laravel.com/docs/pint) for the PHP code style (rules in `pint.json`)
- [Larastan](https://github.com/larastan/larastan) (PHPStan) for static analysis of `app/` (settings in `phpstan.neon`;
  known errors are in `phpstan-baseline.neon`, and new code must not add entries)
- [ESLint](https://eslint.org/) for `resources/js` (rules in `eslint.config.js`)

```bash
ddev composer lint:check   # run all three tools; report problems, change nothing
ddev composer lint:fix     # fix the PHP style and the JavaScript, then report what PHPStan still finds
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

## Releasing

Releases follow [Semantic Versioning](https://semver.org/): increase the **major** version for changes that break
users or deployments without a migration path, the **minor** version for new features and compatible changes, and the
**patch** version for bug fixes only. The version is defined only in `package.json`; the app shows it in the footer.
Releases are tagged `vX.Y.Z`. All changes are recorded in [CHANGELOG.md](CHANGELOG.md).

`master` accepts changes only through pull requests with a passing `ci / CI` check (repository ruleset), so a release
goes through a pull request. To release version `X.Y.Z` from an up-to-date `master` with green CI:

1. Create a branch, for example `git switch -c chore/release-vX.Y.Z`. In `CHANGELOG.md`, rename `## [Unreleased]`
   to `## [X.Y.Z] - YYYY-MM-DD`, add a new empty `## [Unreleased]` above it, and update the compare links at the end
   of the file.
2. Set the version (this updates `package.json` and `package-lock.json`, without a commit or tag):

   ```bash
   ddev npm version X.Y.Z --no-git-tag-version
   ```

3. Commit, push and open a pull request; merge it when CI passes:

   ```bash
   git add CHANGELOG.md package.json package-lock.json
   git commit -m "chore: release vX.Y.Z"
   git push -u origin chore/release-vX.Y.Z
   gh pr create --title "chore: release vX.Y.Z" --body "Release vX.Y.Z. See CHANGELOG.md."
   ```

4. Tag the merge commit on `master` and push the tag:

   ```bash
   git switch master && git pull --ff-only
   git tag -a vX.Y.Z -m "vX.Y.Z"
   git push origin vX.Y.Z
   ```

5. Create the GitHub release, with the changelog section as the release notes:

   ```bash
   awk '/^## \[X.Y.Z\]/{found=1; next} /^## \[/{found=0} found' CHANGELOG.md > release-notes.md
   gh release create vX.Y.Z --title "vX.Y.Z" --notes-file release-notes.md --verify-tag
   rm release-notes.md
   ```

6. Deploy the tag, not the branch (see below).

## Deployment

Deploy a release tag (`git checkout vX.Y.Z`), not `master`. A deployment needs these steps:

1. PHP 8.4.1 or newer on the server. Node.js 24.21.0 on the build machine; build the frontend with
   `npm ci && npm run build`. The build writes to `public/build`.
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

## Cookie consent

[SciFY Laravel Cookie Guard](https://github.com/scify/laravel-cookie-guard) shows the cookie consent dialog. Composer
publishes its assets to `public/vendor/scify` after every install (`post-autoload-dump`, with `--force`), so that folder
is not in git and any edit there is lost. To change the colours, override the plugin's CSS variables in
`resources/sass/main.scss`. The `html` prefix makes the rule win over the plugin's `_variables.css`, which loads later:

```scss
html #scify-cookies-consent-wrapper,
html #scify-cookie-policy-page,
html #scify-cookie-consent-floating-button {
    --scify-cookies-primary-color: #ff5722;
    --scify-cookies-primary-hover-color: #e64a19;
}
```

The full list of variables is in `vendor/scify/laravel-cookie-guard/public/_variables.css`.

## Sitemap

[Spatie Laravel Sitemap](https://github.com/spatie/laravel-sitemap) creates `public/sitemap.xml` (not in git):

```bash
php artisan sitemap:generate
```

## Debugging

Turn on Xdebug in the container with `ddev xdebug on` (and off again with `ddev xdebug off`), then start listening for
debug connections in your IDE (for example PhpStorm). Without DDEV, install Xdebug and set `xdebug.mode=debug`.

## License

Apache License 2.0. See [LICENCE.md](LICENCE.md).
