---
name: UI and Structure Refactor
overview: Refactor the current Laravel app in 7 phases to standardize UI, routes, naming, permissions, and cleanup while minimizing regressions. Prioritize foundational standards and shared components first, then migrate high-traffic modules.
todos:
  - id: phase-1-standards
    content: Freeze conventions for naming, routes, and UI tokens in a short standards document
    status: pending
  - id: phase-2-css-foundation
    content: Consolidate CSS source flow and remove inline layout styles from blade layout
    status: pending
  - id: phase-3-layout-shell
    content: Unify app shell by standardizing one navigation/layout pattern
    status: pending
  - id: phase-4-first-wave-modules
    content: Refactor users/departments/branches views to shared UI pattern
    status: pending
  - id: phase-5-route-normalization
    content: Normalize route patterns and names with compatibility strategy
    status: pending
  - id: phase-6-validation-permission
    content: Harden FormRequest authorization and align permission middleware
    status: pending
  - id: phase-7-cleanup
    content: Remove duplicate backup files
    status: pending
---

# 7-Phase Refactor Plan

## Scope and Goal
Make the app consistent and maintainable without rewriting: unify UI patterns, route naming, and module structure.

## Phase 1 — Lock standards (1-2 days)
- Define and freeze conventions before touching many files:
  - Route naming/resource conventions (`index/create/store/show/edit/update/destroy`)
  - Controller/view naming conventions (remove mixed patterns like `usersUser` for new work)
  - UI tokens: primary color, spacing rhythm, button/input/table patterns
- Create a short project standards doc and use it as a gate for all refactors.
- Key files to align with current state:
  - [D:/WebApp/backofficealcohol/tailwind.config.js](D:/WebApp/backofficealcohol/tailwind.config.js)
  - [D:/WebApp/backofficealcohol/resources/css/main.css](D:/WebApp/backofficealcohol/resources/css/main.css)
  - [D:/WebApp/backofficealcohol/routes/web.php](D:/WebApp/backofficealcohol/routes/web.php)

## Phase 2 — Frontend foundation cleanup (2-3 days)
- Consolidate CSS source of truth:
  - Keep authored styles in one flow (avoid maintaining generated-style file as source)
  - Keep `app.css` as entrypoint and simplify imports
- Move inline layout style into CSS layer.
- Start shared UI primitives for consistent reuse.
- Target files:
  - [D:/WebApp/backofficealcohol/resources/css/app.css](D:/WebApp/backofficealcohol/resources/css/app.css)
  - [D:/WebApp/backofficealcohol/resources/css/main.css](D:/WebApp/backofficealcohol/resources/css/main.css)
  - [D:/WebApp/backofficealcohol/resources/css/maints.css](D:/WebApp/backofficealcohol/resources/css/maints.css)
  - [D:/WebApp/backofficealcohol/resources/views/layouts/app.blade.php](D:/WebApp/backofficealcohol/resources/views/layouts/app.blade.php)

## Phase 3 — Unify layout/navigation shell (2-4 days)
- Choose one navigation shell and normalize page chrome:
  - header, content container width, page actions slot
  - consistent sidebar/top nav behavior
- Remove mixed/legacy nav usage per page.
- Target files:
  - [D:/WebApp/backofficealcohol/resources/views/layouts/app.blade.php](D:/WebApp/backofficealcohol/resources/views/layouts/app.blade.php)
  - [D:/WebApp/backofficealcohol/resources/views/layouts/navigation.blade.php](D:/WebApp/backofficealcohol/resources/views/layouts/navigation.blade.php)
  - [D:/WebApp/backofficealcohol/resources/views/template/sidebar.blade.php](D:/WebApp/backofficealcohol/resources/views/template/sidebar.blade.php)

## Phase 4 — Refactor highest-traffic modules first (week 2-3)
- Migrate `users`, `departments`, `branches` screens to a single page pattern:
  - List page: search + actions + table + empty state + flash messages
  - Form page: consistent labels, validation error display, action buttons
- Replace ad-hoc utility class mixtures with shared component patterns.
- Target files (first wave):
  - [D:/WebApp/backofficealcohol/resources/views/users/index.blade.php](D:/WebApp/backofficealcohol/resources/views/users/index.blade.php)
  - [D:/WebApp/backofficealcohol/resources/views/users/_form.blade.php](D:/WebApp/backofficealcohol/resources/views/users/_form.blade.php)
  - [D:/WebApp/backofficealcohol/resources/views/departments/index.blade.php](D:/WebApp/backofficealcohol/resources/views/departments/index.blade.php)
  - [D:/WebApp/backofficealcohol/resources/views/departments/_form.blade.php](D:/WebApp/backofficealcohol/resources/views/departments/_form.blade.php)
  - [D:/WebApp/backofficealcohol/resources/views/branches/_form.blade.php](D:/WebApp/backofficealcohol/resources/views/branches/_form.blade.php)

## Phase 5 — Route and naming normalization (week 3-4)
- Normalize route declarations and names in groups:
  - Standardize admin/user prefixes and naming style
  - Ensure `show` routes carry identifiers consistently
- Add compatibility redirects/aliases.
- Target files:
  - [D:/WebApp/backofficealcohol/routes/web.php](D:/WebApp/backofficealcohol/routes/web.php)
  - Controllers linked by renamed routes (e.g. [D:/WebApp/backofficealcohol/app/Http/Controllers/UsersController.php](D:/WebApp/backofficealcohol/app/Http/Controllers/UsersController.php), [D:/WebApp/backofficealcohol/app/Http/Controllers/DepartmentController.php](D:/WebApp/backofficealcohol/app/Http/Controllers/DepartmentController.php))

## Phase 6 — Validation and permission hardening (week 4-5)
- Standardize FormRequest usage and authorization checks.
- Audit permission strings per module so middleware matches actual resources.
- Reduce controller bloat (query/filter logic cleanup) only where needed for clarity.
- Target files:
  - [D:/WebApp/backofficealcohol/app/Http/Requests/DepartmentRequest.php](D:/WebApp/backofficealcohol/app/Http/Requests/DepartmentRequest.php)
  - [D:/WebApp/backofficealcohol/app/Http/Controllers/UsersController.php](D:/WebApp/backofficealcohol/app/Http/Controllers/UsersController.php)
  - [D:/WebApp/backofficealcohol/routes/web.php](D:/WebApp/backofficealcohol/routes/web.php)

## Phase 7 — Cleanup
- Remove duplicate backup files and stale view variants.
- Known cleanup targets:
  - [D:/WebApp/backofficealcohol/resources/views/users/_form.blade copy.php](D:/WebApp/backofficealcohol/resources/views/users/_form.blade copy.php)
  - [D:/WebApp/backofficealcohol/resources/views/usersUser/_form.blade copy.php](D:/WebApp/backofficealcohol/resources/views/usersUser/_form.blade copy.php)
  - [D:/WebApp/backofficealcohol/resources/views/testhistorys/_form.blade copy.php](D:/WebApp/backofficealcohol/resources/views/testhistorys/_form.blade copy.php)
  - [D:/WebApp/backofficealcohol/resources/views/welcome.blade copy.php](D:/WebApp/backofficealcohol/resources/views/welcome.blade copy.php)

## Sequencing rule
- Complete each phase with acceptance checks before moving on.
- Do not mass-edit all modules at once; migrate module-by-module

## Acceptance checks by phase
- Phase 1-3: visual consistency baseline in shared layout and components
- Phase 4-5: no broken links/routes, consistent CRUD patterns in first-wave modules
- Phase 6: requests validated + permission behavior predictable
- Phase 7: no stale duplicate files
