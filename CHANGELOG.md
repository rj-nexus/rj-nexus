# Changelog

All notable changes to RJ Nexus will be documented in this file.

## [v1.9.2] - 2026-11-12

This update improves the core exception handling to allow active themes to provide their own custom error pages.

### ⚡ Improved
- **Theme Error Page Support:** Updated the exception handler in `bootstrap/app.php`. The system now checks if the active theme has a custom error view (e.g., `theme::errors.404`) before falling back to the default core error pages. This allows themes to fully customize the look and feel of 404, 403, and other HTTP error screens.