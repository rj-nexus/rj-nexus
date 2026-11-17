# Changelog

All notable changes to RJ Nexus will be documented in this file.

## [v1.9.5] - 2026-11-17

### 🚀 Added
- **Core Info Panel (Updates):** Added a small informational panel in the Updates section about "Altair" (the star) and the RJ CORE 1 series, with a subtle design touch.
- **Appearance → Options Redesign:** Simplified the Appearance → Options section for a cleaner, lighter user experience.

### ⚡ Changed
- **Dependency Updates:** Upgraded Composer packages, Laravel framework, and bundled plugins to their latest stable versions.
- **Performance Optimization:** General optimization pass improving overall system responsiveness and reducing resource usage across the admin panel and frontend.

### 🐛 Fixed
- **Global Favicon Support:** Favicon set via Appearance → Options now displays correctly across all themes. Themes no longer override the admin-configured favicon.
- **Sidebar Post Type Detection:** Sidebar no longer incorrectly shows/highlights "Pages" when creating, editing, or viewing a Post. Active state is now correctly detected via route param, query string, and route name, with layout-type flag overrides for posts/pages.
- **Automatic Update Check:** Theme and plugin updates from the registry are now checked automatically every 15 minutes via pseudo-cron, guarded by an atomic cache lock to prevent duplicate requests.
- **Update Notifications:** Theme and plugin update alerts now correctly appear in the notification bell. Fixed the issue where updates were silently applied without generating a notification. Duplicate notifications are prevented and alerts are localized per admin user with JSON translation keys.
- **Update System Reliability:** Theme, plugin, and core updates now apply correctly end-to-end. Previously updates could fail silently or leave the system in an inconsistent state; the update flow is now stable and reports accurate status.
- **Theme Update Badge:** Fixed the missing "update available" badge on themes in the Themes section. The badge and update action now display correctly when a new version is available.
- **Plugin Update Badge:** Fixed the same missing "update available" badge issue on plugins. The badge and update action now display correctly when a new version is available.

## [v1.9.4] - 2026-11-16
### 🐛 Fixed
- **Sidebar Post Type Detection:** Sidebar no longer incorrectly shows/highlights "Pages" when creating, editing, or viewing a Post. Active state is now correctly detected via route param, query string, and route name, with layout-type flag overrides for posts/pages.
- **Automatic Update Check:** Theme and plugin updates from the registry are now checked automatically every 15 minutes via pseudo-cron, guarded by an atomic cache lock to prevent duplicate requests.
- **Update Notifications:** Theme and plugin update alerts now correctly appear in the notification bell. Fixed the issue where updates were silently applied without generating a notification. Duplicate notifications are prevented and alerts are localized per admin user with JSON translation keys.