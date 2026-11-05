# Changelog

All notable changes to RJ Nexus will be documented in this file.

## [v1.8.8] - RJ CORE 1

This update focuses on completely revamping the theme and plugin registry system, improving GitHub automation, and fixing the AI Vault integration.

### Added
- **Split Registry System:** Separated the monolithic `registry.json` into an index file (`registry.json`), `themes.json`, and `plugins.json` for faster parsing, better caching, and smaller PRs.
- **Registry JSON Schemas:** Added strict JSON schemas (`registry.schema.json`, `theme.schema.json`, `plugin.schema.json`) to validate submissions.
- **Direct Registry Submission:** Added a new GitHub Pages form (`index.html`) that submits directly to a Cloudflare Worker via `fetch`, eliminating the need for users to redirect to GitHub or create accounts.
- **Cloudflare Worker Endpoints:** Added explicit `/submit`, `/keys`, and `/health` routes to the Vault Worker. `/submit` triggers a GitHub `repository_dispatch`, `/keys` serves AI vault credentials, and `/health` monitors environment variables.
- **Registry Dispatch Workflow:** Added `.github/workflows/registry-dispatch.yml` to automatically listen for `repository_dispatch` events, validate payloads, check target repos for manifests, and open PRs automatically.
- **Animated Success UI:** Added a custom confetti animation and checkmark overlay to the registry submission form upon successful submission.

### Fixed
- **AI Vault Fallback:** Fixed the Vault worker so that AI keys can be explicitly fetched from the `/keys` endpoint, resolving the `{"error":"Failed to fetch keys"}` issue.
- **Registry CI Validation:** Updated `.github/workflows/validate.yml` to use `ajv/dist/2020` to support Draft 2020-12 JSON schemas, and added remote manifest matching checks.
- **Theme Browse Crash:** Fixed `Undefined array key "slug"` in `browse.blade.php` by restoring the dynamically generated `slug` key inside `GitHubRegistry::enrichEntry()`.

### Improved
- **GitHubRegistry Service:** Refactored `GitHubRegistry.php` to read from the split `themes.json` and `plugins.json` files. It no longer fetches the manifest on every page load; instead, it relies on the registry data and only calls the GitHub API to fetch the latest release ZIP URL.
- **Registry Automation:** Maintainers no longer need to manually update `count` and `updated_at` in `registry.json`, as the GitHub Action automatically updates these values when merging new PRs.

---

## [v1.8.7] - RJ CORE 1

This update focuses on fully restoring and stabilizing the visual Icon Picker within the RJ Builder, and adding icon support to Repeater fields.

### Added
- **Repeater Icon Support:** Added `sub.type === 'icon'` rendering logic to `repeater.blade.php`. Users can now open the visual Icon Picker directly inside repeater fields (e.g., Features, Action Grid) instead of typing raw text.
- **Icon Picker JS Logic:** Implemented the missing JavaScript functions (`fetchIcons`, `selectIcon`, `getIconSvg`, `useManualIcon`) and state variables in `scripts.blade.php` to make the Icon Picker fully functional.
- **Iconify Script:** Integrated `iconify-icon.min.js` into `edit.blade.php` to ensure icons render instantly as SVGs inside the admin panel.

### Fixed
- **Missing Icon Field:** Fixed the bug where the Icon field inside Repeaters was completely invisible due to missing Alpine.js rendering conditions.
- **Icon Picker Z-Index:** Increased the modal's z-index (`z-[99999]`) so it appears above other overlays (like the Repeater modal).
- **Unreadable Text:** Forced dark text and white background on the Icon Picker search inputs to fix the issue where text was invisible (white on white).
- **Invisible Icons:** Forced a dark color (`#1e293b`) on the icons inside the picker so they are visible against the white modal background.

## [v1.8.6] - RJ CORE 1

This update fixes plugin migration execution and automates bundled plugin activation during installation.

### Fixed
- **Plugin Migration Path:** `PluginManager::activate()` and `PluginManager::update()` no longer hardcode `database/migrations`. The migration path is now read from `plugin.json` via `provides.migrations`, so plugins with custom migration folders (like `src/Migrations`) run their migrations correctly on activation and update.
- **Form Builder Schema:** The missing `is_required`, `options`, and `settings` columns on `rj_form_fields` are now created automatically when the plugin is activated, resolving `SQLSTATE[42S22]: Unknown column 'is_required'` errors during form save and submission.

### Added
- **Bundled Plugin Auto-Activation:** The installer now automatically activates bundled plugins (currently `form-builder`) after a successful installation, including running their migrations. No manual activation step is required for first-time installs.

---

## [v1.8.5] - RJ CORE 1

This update focuses on stabilizing the core architecture, improving theme development workflows, and fixing critical bugs discovered during the creation of complex themes like Spotlight.

### Added
- **Theme Customizer Helpers:** Added `rj_theme_mod()`, `rj_theme_mod_section()`, `rj_set_theme_mod()`, and `rj_flush_theme_mods()` to `app/Helpers/rj.php`. Themes can now securely read and cache customizer values from the database.
- **Dynamic Widget Namespace Registration:** Themes can now register their own widgets automatically via `theme.json` without hardcoding their namespaces in the core `WidgetRegistry`.

### Fixed
- **Hardcoded Widget Namespace:** Fixed `WidgetRegistry::widgetSource()` which was previously hardcoded to only recognize `VelvetAura`. It now dynamically reads the `namespace` key from the active theme's `theme.json`.
- **Static Homepage Routing:** Fixed `FrontendController@home` to correctly resolve static pages by ID instead of slug, and allow draft/unpublished pages to be used as the front page without throwing a 404.
- **Reading Settings Cache:** Added `rj_flush_options()` to `ReadingSettingsController@update` to ensure frontend routing picks up homepage changes immediately.
- **Heading Widget Fatal Error:** Fixed `Undefined array key "level"` crash in `HeadingWidget.php` when rendering legacy or custom builder blocks.
- **Customizer JavaScript Crash:** Replaced raw translation strings `{{ __('...') }}` with `@js()` in `customizer.blade.php` to prevent Alpine.js from breaking when translations contain single quotes.
- **Missing Theme Service Provider Import:** Fixed a silent crash in `SpotlightServiceProvider` caused by a missing `use` statement for newly added widgets.

### Improved
- **Frontend Scroll Behavior:** Replaced `overflow-x: hidden` with `overflow-x: clip` in standard layouts to prevent unwanted secondary scrollbars on the Y-axis.
- **Theme Integration:** Improved how core builder blocks (like Container and Heading) handle missing settings gracefully, preventing fatal 500 errors on the frontend.

---

## [v1.8.4] - RJ CORE 1

This update focuses on resolving core CMS bugs, stabilizing the Theme Customizer, fixing static homepage routing, and improving Builder integration with themes.

### Added
- **Demo Import System:** Added the `importDemo` method to `ThemeController` and registered the `admin.themes.customizer.import-demo` route. Themes can now include a `demo/data.json` file to automatically generate pages and templates.
- **Customizer Import UI:** Added an "Import Demo Content" button to the Theme Customizer view with loading states and toast notifications.
- **Reading Settings Page Selector:** Replaced manual text inputs with a dropdown selector populated by all available pages for "Homepage Page" and "Posts Page".

### Fixed
- **Static Homepage Routing:** `FrontendController@home` now correctly loads the selected static page by ID instead of slug, and allows draft/unpublished pages to be used as the front page.
- **Reading Settings Cache:** Added `rj_flush_options()` to `ReadingSettingsController@update` to ensure changes apply immediately without cache clearing.
- **Heading Widget Crash:** Fixed `Undefined array key "level"` fatal error in `HeadingWidget.php` when a heading block is missing its level setting.
- **Customizer JS Syntax Error:** Replaced raw `{{ __('...') }}` strings in `customizer.blade.php` with `@js()` to prevent Alpine.js from breaking due to single quotes in translations.
- **Popup Layout Bleed:** Enforced inline `display: none` on the popup wrapper in the Spotlight theme to prevent the popup from rendering at the bottom of the page before JS loads.
- **Taxonomy URLs:** Fixed `RouteNotFoundException` in the Spotlight theme by switching `single-post.blade.php` and `loop-card.blade.php` to use query-based taxonomy links (`term` & `taxonomy`).
- **Contact Template:** Removed the hardcoded form from `templates/contact.blade.php`. It now relies on RJ Builder blocks and shows a hint if the builder is empty.

### Improved
- **Dynamic Theme CSS:** The Spotlight theme's `layout.blade.php` now uses `rj_theme_mod()` to dynamically output CSS variables (`--rj-primary`, `--rj-bg`, fonts, etc.) directly into the `:root`, ensuring Customizer changes reflect instantly.
- **Home Latest Posts Fallback:** Restored the "Latest Posts" grid in the Spotlight theme's `home.blade.php`. If "Latest posts" is selected in Reading Settings, the theme now displays a styled post grid instead of a blank page.
- **Page Route Resolution:** Updated `FrontendController@findFrontPage` to ignore pages marked as "trash" to prevent routing conflicts.
