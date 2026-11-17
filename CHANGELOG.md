# Changelog

All notable changes to RJ Nexus will be documented in this file.

## [v1.9.5] - 2026-11-17

### ⚡ Changed
- **Dependency Updates:** Upgraded Composer packages, Laravel framework, and bundled plugins to their latest stable versions.
- **Performance Optimization:** General optimization pass improving overall system responsiveness and reducing resource usage across the admin panel and frontend.

## [v1.9.4] - 2026-11-17

### 🐛 Fixed
- **Sidebar Post Type Detection:** Sidebar no longer incorrectly shows/highlights "Pages" when creating, editing, or viewing a Post. Active state is now correctly detected via route param, query string, and route name, with layout-type flag overrides for posts/pages.
- **Automatic Update Check:** Theme and plugin updates from the registry are now checked automatically every 15 minutes via pseudo-cron, guarded by an atomic cache lock to prevent duplicate requests.
- **Update Notifications:** Theme and plugin update alerts now correctly appear in the notification bell. Fixed the issue where updates were silently applied without generating a notification. Duplicate notifications are prevented and alerts are localized per admin user with JSON translation keys.