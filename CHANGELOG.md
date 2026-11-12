# Changelog

All notable changes to RJ Nexus will be documented in this file.

## [v1.9.3] - 2026-11-13

This update focuses on theme portability, marketplace UI stability, and enhancing the core exception handler.

### 🚀 Added
- **Theme Demo Export Command:** Added the `rj:export-theme-demo` Artisan command. Developers can now export current database content (pages, menus, templates, customizer settings) directly into the active theme's `demo/data/` directory, making themes fully portable with starter content.
- **Custom Theme Error Pages:** Updated the exception handler in `bootstrap/app.php`. The core now automatically checks if the active theme provides a custom error view (e.g., `theme::errors.404`) before falling back to the default system error pages.
- **Marketplace Details View:** Created the missing `show.blade.php` view for Themes and Plugins.

### 🐛 Fixed
- **Critical Marketplace Error (Details Page):** Resolved a critical exception that crashed the admin panel when clicking on a theme or plugin to view its details. The missing details view is now fully functional.
- **Critical GitHub Hotlink Issue:** Fixed the critical bug where theme and plugin images were broken (not loading) in the Admin marketplace. Added `referrerpolicy="no-referrer"` to all external image tags to bypass GitHub's hotlink protection.
- **Registry Schema Alignment:** Updated the core to properly parse the `logo` key from the registry and theme manifests. Implemented a cascading image logic (`screenshots` -> `screenshot` -> `logo` -> `preview`) across the Browse, Index, and Show views to ensure thumbnails always display correctly.