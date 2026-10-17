# AGENTS.md

Guidance for AI coding agents (and humans) working in this repository. `CLAUDE.md` imports this file.

## Project

Dianoia Marketplace: a Laravel 12 web application where carers create and share exercises for people with dementia.
Administrators review each exercise; approved exercises marked `display_in_api` also appear in the Dianoia mobile
app through `routes/mobile.php`. Production: <https://dianoia.scify.org/>. Default branch: `master`.

Stack: PHP ^8.2 (CI uses 8.4), MySQL, Vue 2.7 (end of life), Vite 7, Bootstrap 5, Sass, jQuery, Laravel Fortify for
authentication. Node **24.21.0** (`.nvmrc`), npm ≥ 11.19.

## Commands

| Task | Command |
|---|---|
| Install everything (safe to re-run; no DB step) | `composer setup` |
| Create tables and starter data (after editing `DB_*` in `.env`) | `php artisan migrate --seed` |
| Run locally | `php artisan serve` and `npm run dev` |
| Tests | `composer test` |
| Tests with coverage (PCOV or Xdebug) | `composer test:coverage` |
| Pint + PHPStan + ESLint, no changes | `composer lint:check` |
| Fix style (Pint, ESLint), then PHPStan report | `composer lint:fix` |
| Production frontend build | `npm ci && npm run build` (writes `public/build`) |

Before every commit, all of these must pass (check each exit code; do not chain a commit after a test run):
`vendor/bin/pint --test`, `vendor/bin/phpstan analyse`, `npm run lint`, `npm run build`, and the test suite.

## Safety rules (from real incidents)

- **Tests must never touch the developer's MySQL database.** `phpunit.xml` forces SQLite in memory, and
  `tests/TestCase.php` refuses to reset any other database (the check runs in `setUpTraits()`, because the
  `RefreshDatabase` trait's own `beforeRefreshingDatabase()` would override an inherited guard). A cached config or a
  `DATABASE_URL` can override `phpunit.xml`; `composer test` runs `config:clear` first. When in doubt, run
  `env DB_HOST=192.0.2.1 php artisan test` so a wrong target fails instead of wiping data. (On 2026-10-16 a
  `RefreshDatabase` test ran against the local MySQL and deleted all data.)
- Do not run `migrate`, `db:seed` or tinker writes against the developer's database without asking. For manual
  checks, create temporary users/data and delete them afterwards.
- `composer require` without `-W` (it upgrades unrelated packages).
- Never suggest `git pull` on production (see Deployment).
- Ask before pushing, tagging or releasing. Commits are authored by Paul only: no `Co-Authored-By` lines. Pull request
  descriptions: no "Test plan" section and no mention of AI tools.

## Architecture

- `app/Http/Controllers` → `app/BusinessLogicLayer/*Manager` (business logic) → `app/Repository/*Repository`
  (Eloquent access; base class `Repository` with `find`, `where` (first match), `allWhere`, `update`, …).
- `app/ViewModels` + `app/BusinessLogicLayer/ViewModelProviders`: data for Blade pages.
- `app/Models`: `User` (relation `roles()` to `UserRoleLkp` via `user_roles`; `$with = ['roles']`),
  `Resource\Resource` (an exercise; soft deletes), `Resource\ResourcesRating`, `Reports` (column `resource_id`).
- Old Laravel structure: middleware and groups in `app/Http/Kernel.php`, routes registered in
  `app/Providers/RouteServiceProvider.php`.

### Routes

- `routes/web.php` (`web`, `set.locale`): pages, auth, exercise CRUD, admin pages under `administration/`
  (`can:manage-platform`), `js/translations.js`.
- `routes/metadata.php` (prefix `metadata`, middleware `metadata` = throttle + bindings). Three tiers:
  public read-only lookups; `/metadata/resources` in `web` (session, no login, so visibility can depend on the viewer);
  ratings in `web` + `auth`; users, reports and report responses in `web` + `auth` + `can:manage-platform`.
  Route names are used by the frontend through `window.route()`; keep them stable.
- `routes/mobile.php` (prefix `mobile`, throttled, no auth by design): exercise list (approved + `display_in_api`
  only), anonymous ratings (approved exercises only), analytics.

### Access control

- Roles (`App\Repository\User\UserRole\UserRolesLkp`): `ADMIN = 1`, `PRIVATE_CARER = 2`, `PROFESSIONAL_CARER = 3`,
  `ORGANIZATION = 4`; `REGISTERED_USER_TYPES = [2, 3, 4]` (users may choose only these).
- Gate `manage-platform` (admin) in `UserRoleManager::registerUserPolicies()`.
- `App\Policies\ResourcePolicy::manage`: creator or admin may edit, update and delete an exercise.
- Profile updates (`users.update` → `UserController::updateProfile`) change only the logged-in user's name, email,
  password and registered type, never the admin role. Admin user management uses `administration.users.*`.
- Non-admins see only approved exercises, except in their own list. Public payloads expose a creator's `id` and
  `name` only. Ratings use `Auth::id()`, never a user id from the request; the server computes `avg_rating`.
- `TrustHosts` is on: outside `local`/testing, only the `APP_URL` host and its subdomains are accepted (HTTP 400).

## Frontend

- Vite entries are listed in `vite.config.js` (5 JS files, 12 Sass files); Blade loads them with `@vite()`. Adding a
  page asset means adding it to `input` as well.
- `#app` wraps the whole layout and uses in-DOM Vue templates, so `vue` is aliased to the full build
  (`vue/dist/vue.esm.js`). `@vitejs/plugin-vue2` supports Vite ≤ 7; Vue 3 would be a separate migration.
- jQuery: `resources/js/jquery-global.js` sets `window.$`/`window.jQuery` (needed by `jquery-ui-dist` and inline
  scripts). Import `$` explicitly in modules. **Inline Blade `<script>` blocks that use jQuery must be
  `type="module"`** (`tests/Unit/InlineScriptsTest.php` enforces this).
- `common/footer-scripts.blade.php` sets `window.Laravel` (`csrfToken`, `baseUrl`, route map) and loads
  `/js/translations.js` (`window.i18n`, `window.translate`). Use `window.Laravel.baseUrl` for runtime URLs; `VITE_*`
  values are fixed at build time (only `VITE_SENTRY_DSN_PUBLIC` is used).
- axios sends the CSRF header from the `XSRF-TOKEN` cookie; forms posted from Vue add `_token`.
- ESLint flat config (`flat/vue2-essential`): tabs, double quotes, semicolons.

## Tests

PHPUnit 11 (`tests/Feature`, `tests/Unit`), SQLite in memory, `withoutVite()`. Helpers in `tests/TestCase.php`:
`seedLookupTables()`, `createUserWithRole(int)`, `createResource(User, int $statusId)`. Write the test first and
watch it fail. Laravel skips CSRF checks in tests, so check CSRF-sensitive changes in a browser. A test that changes
`$this->app['env']` for `TrustHosts` must reset `Request::setTrustedHosts([])` in `tearDown`.

## Code quality

Pint (`pint.json`: braces on the same line, Laravel preset), Larastan level 5 with `phpstan-baseline.neon` — new
code must not add baseline entries; lowering a count after a fix is fine. Fix types instead of suppressing errors
(for example generic `@return BelongsToMany<…>` on relations).

## npm supply chain

`.npmrc`: `ignore-scripts=true`, `min-release-age=7`, `engine-strict=true` (CI checks them). Use `npm ci`; choose
new package versions released at least 7 days ago. npm 12 may print `install-scripts` warnings; that is expected.

## CI

Shared SciFY workflows (`scify/.github@v0.1`): `ci.yml` (pull requests + pushes to `master`; required check
`ci / CI`) and `security.yml` (pull requests + weekly). Dependabot: security updates only;
`dependabot_auto_merge.yml` merges minor/patch updates after the required checks.

## Releasing

Semantic Versioning; the version is defined only in `package.json` (`config/app.php` reads it; the footer shows it).
Record changes in `CHANGELOG.md` (Keep a Changelog) under `[Unreleased]`. Release steps are in `README.md`
("Releasing"): `npm version X.Y.Z --no-git-tag-version`, commit `chore: release vX.Y.Z`, annotated tag `vX.Y.Z`,
`git push origin master --follow-tags`, `gh release create` with the CHANGELOG section. First release: `v1.1.0`
(2026-10-17).

## Deployment

Production still runs an old version deployed with `git pull`; the current code needs a **fresh deployment** of a
release tag (checklist in `README.md`: Node 24, `npm ci && npm run build`, `VITE_*` keys, `APP_URL`/proxy `Host` for
TrustHosts, mail and Sentry settings, permissions, scheduler, queue worker). The access-control fixes of v1.1.0 are not
live until then; after migrating old data, check `user_roles` for unexpected admins (role 1).

## Known issues (not fixed yet)

- Web ratings (by `resources_id`) and mobile ratings (by slug) compute `avg_rating` from different rows; the last
  writer wins. No unique key per voter and exercise.
- `ResourceManager::getReportedExercises()` replaces `creator` with the reporting user (admin reports list shows the
  reporter as "Created by").
- The mobile rating `update` path lets any client change an anonymous rating with a given value (by design so far).
- `user-role-mapping` is public and shows which user ids are admins.
- `ResourceManager::getTransformExercisesForMobileApp()`: the `stories` case has no `break`.
- Sass prints `@import` and division deprecations (Bootstrap 5.3); seeders print to stdout.
