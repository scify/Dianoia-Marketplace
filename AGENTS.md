# AGENTS.md

Guidance for AI coding agents working in this repository. `CLAUDE.md` imports this file. Commands, setup and
deployment are in `README.md`; changes are recorded in `CHANGELOG.md`.

## Project

Dianoia Marketplace (<https://dianoia.scify.org/>): a Laravel 12 app where carers create and share exercises for people
with dementia. Administrators approve exercises; approved exercises marked `display_in_api` also reach the Dianoia
mobile app through `routes/mobile.php`. Default branch: `master`.

## Working rules

- **Run everything in DDEV** (`ddev composer …`, `ddev artisan …`, `ddev npm …`, `ddev exec …`). The host may have a
  different PHP; the project needs PHP 8.4.1 (`composer.lock` contains Symfony 8.1). `ddev start` runs
  `composer setup` and `php artisan migrate` on the DDEV database (post-start hook).
- `ddev start`, `ddev restart` and `ddev import-db` run the migrations, and `ddev import-db` also replaces the
  database: ask before each one.
- **The developer's databases hold real local data** (the DDEV database, and possibly a host MySQL). Ask before
  `migrate`, `db:seed` or tinker writes. For browser checks, create temporary users and data, and delete them
  afterwards.
- **Commit gate**: run each tool as its own command and read its exit code, then commit in a separate command:
  `ddev composer lint:check`, `ddev npm run build`, and the tests (`ddev exec php artisan config:clear`, then
  `ddev exec php artisan test --compact`). Chained commits went in with failing tests and a PHPStan error before.
- `phpstan-baseline.neon`: new code adds no entries. When a change removes code that an entry ignores, lower or
  remove that entry in the same commit (PHPStan fails on unmatched entries). Fix types instead of suppressing.
- `composer require` / `composer update` without `-W`; use `-w` with the exact packages instead. New npm packages:
  pick versions released at least 7 days ago (`.npmrc` `min-release-age`); npm 12 `install-scripts` warnings are
  expected (`ignore-scripts=true`).
- `master` accepts only pull requests with a passing `ci / CI` check (ruleset `master-branch-require-ci`). Work on a
  branch; ask before every push, force push, tag and release.
- Commits are authored by Paul only, without `Co-Authored-By` lines. Pull request descriptions have no "Test plan"
  section and no mention of AI tools.
- Every user-visible change gets an entry under `## [Unreleased]` in `CHANGELOG.md`; deployment-relevant changes also
  get an upgrade note. Releases follow "Releasing" in `README.md`.
- Production still runs an old version deployed with `git pull`. The next deployment is a fresh setup of a release
  tag (checklist in `README.md`). Never suggest `git pull` on production.

## Tests

- **Tests must run on SQLite in memory only.** On 2026-10-16 a `RefreshDatabase` test reset the developer's MySQL.
  DDEV sets `DB_CONNECTION=mysql` and `DB_HOST=db` as container variables, which `<env>` lines in `phpunit.xml`
  would not override; the `<server>` lines do. `tests/TestCase.php` throws before any database trait runs on another
  database (the check is in `setUpTraits()`; the `RefreshDatabase` trait's own `beforeRefreshingDatabase()` would
  override an inherited guard). Keep both. `phpunit.xml` also fixes `APP_URL`, because the console request takes its
  scheme from it.
- Helpers in `tests/TestCase.php`: `seedLookupTables()` (silences the seeders' output), `createUserWithRole()`,
  `createResource($creator, $statusId)`.
- Write the test first and watch it fail; for access rules, also remove the check once and watch the test fail.
- Without a terminal, a failing `ddev composer test` prints no test output. For scripted runs use
  `ddev exec php artisan test --compact`.
- Laravel skips CSRF in tests: check CSRF-relevant changes in a browser with a real session.
- A test that sets `$this->app['env']` for `TrustHosts` resets `Request::setTrustedHosts([])` in `tearDown()`
  (the trusted hosts are static and leak into later tests).

## Domain and architecture

- Controllers → `app/BusinessLogicLayer/*Manager` → `app/Repository/*Repository`. `Repository::where()` returns the
  first match or `null`. Middleware and route registration use the old structure (`app/Http/Kernel.php`,
  `RouteServiceProvider`).
- An exercise is a `Resource` (soft deletes). Statuses (`ResourceStatusesLkp`): 1 pending, 2 approved, 3 rejected.
  Roles (`UserRolesLkp`): 1 admin; 2-4 are the registered user types (`REGISTERED_USER_TYPES`) a user may choose.
  `User::$with = ['roles']` loads the roles on every user query. `Reports` uses the column `resource_id`.
- Access: gate `manage-platform` (admin); `ResourcePolicy::manage` (creator or admin) for edit, update and delete.
  Profile updates (`UserController::updateProfile`) never change the admin role. Ids come from the route and the
  session user, never from the request body; the server computes `avg_rating`.
- `routes/metadata.php` has three tiers: public lookups; `/metadata/resources` in `web` (session, no login, so
  non-approved exercises are visible only to admins and their creator); ratings in `web` + `auth`; users, reports and
  report responses in `web` + `auth` + `can:manage-platform`. Public payloads show a creator by `id` and `name` only.
- `routes/mobile.php` has no login by design: approved exercises with `display_in_api`, anonymous ratings of approved
  exercises.
- `TrustHosts` is on outside `local` and outside tests: only the `APP_URL` host and its subdomains (others get
  HTTP 400).
- `public/storage` is a relative link (`composer setup` creates it), so it works on the host and in DDEV.

## Frontend

- Vite entries are listed in `vite.config.js`; Blade loads them with `@vite()`. A new page asset needs an `input`
  entry. The Vite dev server runs in DDEV on port 5179 (the same port as Talk & Play Marketplace).
- `#app` wraps the layout with in-DOM Vue 2.7 templates, so `vue` resolves to the full build. `@vitejs/plugin-vue2`
  supports Vite ≤ 7.
- jQuery: `resources/js/jquery-global.js` sets `window.$`; modules import `$`. Inline Blade scripts that use jQuery
  must be `type="module"` (`tests/Unit/InlineScriptsTest.php` enforces it).
- `common/footer-scripts.blade.php` sets `window.Laravel` (`csrfToken`, `baseUrl`, route map); the frontend calls
  routes by name through `window.route()`, so keep route names stable. Use `window.Laravel.baseUrl` for URLs;
  `VITE_*` values are fixed at build time.
- `public/vendor/scify` is published by Composer on every install (`--force`) and is not in git. Cookie dialog colours
  are CSS-variable overrides in `resources/sass/main.scss` (README "Cookie consent").

## Known issues

- Web ratings (by `resources_id`) and mobile ratings (by slug) compute `avg_rating` from different rows; the last
  writer wins. No unique key per voter and exercise.
- `ResourceManager::getReportedExercises()` replaces `creator` with the reporting user, so the admin reports list
  shows the reporter as "Created by".
- The mobile rating `update` path lets any client change an anonymous rating with a given value.
- `user-role-mapping` is public and shows which user ids are admins.
- `ResourceManager::getTransformExercisesForMobileApp()`: the `stories` case has no `break`.
