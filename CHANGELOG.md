# Changelog

All notable changes to RJ Nexus will be documented in this file.

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
