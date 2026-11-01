# Changelog

All notable changes to RJ Nexus (formerly RJ CMS) will be documented in this file.

## [v1.6.0] - 2026-11-02 (Altair Series)

This is the major stable release update. We completely overhauled the installation process, introduced a keyless Dual AI engine, expanded language support to 17, and fixed critical localization and UI bugs.

### Added (New Features & Systems)
- **Setup Wizard (Visual Installer):** A brand new, standalone `install.php` with a premium UI, multi-language support, requirement checks, manual SQL import, and automated demo data loading.
- **Demo Data Seeder:** Added `rj:export-demo` command and `DemoSeeder` to bundle and import default pages, menus, headers, and builder templates automatically.
- **Free AI Bridge:** Integrated a keyless AI system (via Cloudflare Proxy) for the dashboard and search, working alongside OpenRouter.
- **Global AI Search (Ctrl+K):** Added a command palette search with AI-powered answers and dynamic menu navigation.
- **Notifications & Activity Log:** Added real-time notifications (Bell icon) and comprehensive activity logging for all system events.
- **New Languages:** Added Italian (`it`), Dutch (`nl`), Armenian (`hy`), and Georgian (`ka`). Total supported languages increased to 17.

### Fixed (Bug Fixes)
- **Language Sync:** Fixed a major bug where changing the admin language caused a 404 redirect on the frontend. Admin and frontend locales are now strictly isolated.
- **Demo Data Remapping:** Fixed menu item `object_id` and template IDs remapping so builder widgets and menus don't break after a fresh install.
- **AI Dashboard UI:** Redesigned the AI overview widgets on the admin dashboard.
- **Missing Blade Files:** Added 4 critical missing Blade views resolving multiple 500 errors.
- **Installer Memory Limits:** Fixed `ERR_CONNECTION_RESET` during installation by writing CLI output to temp files.

---

## [v1.5.0] - 2026-10-29 (Altair Series)

This was a stability and architecture update focusing on the Live Preview system, rendering performance, custom error handling, and deep plugin integrations.

### Added
- **Universal Live Preview System:** Dedicated preview routes for both Templates (Header/Footer) and Posts (Pages).
- **RJ Nexus Debug Screen:** A custom dark-mode, glassmorphism screen for 500-level errors with stack traces and GitHub support links.
- **Widget Render Caching:** Implemented `RJ_WIDGET_CACHE` to cache HTML and cancel pending requests.
- **Auto SEO:** AI-powered automatic generation of SEO titles, descriptions, and focus keywords.
- **WebP Optimization:** Automatic conversion of uploaded images to WebP format.
- **Activity Log:** Observer-based tracking for posts, users, media, and login/logout events.

### Fixed
- **Live Preview 404:** Fixed routing and data passing for the live preview button.
- **Infinite Render Loop:** Implemented a 250ms debounce in `actions.blade.php` to prevent session locks.
- **HTML Syntax Break:** Fixed JSON parsing in Alpine `x-data` attributes.
- **Footer Links UID:** Replaced random `uniqid()` with a deterministic settings hash.

---

## [v1.4.0] - 2026-10-15 (Altair Series)

### Added
- **RJ Commerce:** Full e-commerce plugin (Cart, Checkout, Stripe/PayPal/Crypto gateways).
- **VelvetAura Theme:** Premium e-commerce theme with 3 Header and 3 Footer styles.
- **RJBuilder Updates:** Added `image_select` field type, Icon Picker (Iconify), and dynamic widget categories.
- **30+ Standard Widgets:** Added Music Player, Portfolio, Multi-Chat, Google Reviews, and more.

### Fixed
- Resolved Blade `$this` errors in widgets.
- Fixed form builder styling conflicts by migrating to inline CSS.
- Replaced all emojis in UI/Builder with SVG icons.

---

## [v1.3.0] - 2026-10-10 (Altair Series)

### Added
- **Admin Settings:** Completed UI for SEO, Security, Email/SMTP, Cache, Backup, and Social Login.
- **Media Library:** Drag-and-drop uploads with image preview and search.
- **Comment System:** Pending, Approved, Spam, and Trash folders.
- **Menu Builder:** Dynamic drag-and-drop menu creation with custom locations.

---

## [v1.2.0] - 2026-10-05 (Altair Series)

### Added
- **Multi-language Support:** Initial support for AZ, EN, DE, ES, FR, PT.
- **Dynamic Categories & Tags:** Fully translatable taxonomies.
- **Page & Post Builder:** Basic RJBuilder integration for content creation.
- **SEO Settings:** Basic meta tags and sitemap generation.

---

## [v1.1.0] - 2026-10-01 (Altair Series)

### Added
- **Plugin Architecture:** Isolated routes, views, and migrations for plugins.
- **Theme Architecture:** Namespace-based view loading and theme customization.
- **Auth System:** Laravel Breeze integration with basic email verification.

---

## [v1.0.0] - 2026-09-25 (Initial Release)

### Added
- Initial release of RJ CMS (now RJ Nexus) core.
- Laravel 12 setup, MySQL database migrations.
- Basic post and page CRUD operations.
- Basic admin dashboard layout and navigation.
