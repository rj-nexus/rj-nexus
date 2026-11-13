# Changelog

All notable changes to the Spotlight theme will be documented in this file.

## [1.0.4] - 2026-11-13

### 🐛 Bug Fixes & Improvements

This release fixes favicon synchronization between the admin Site Options and the frontend, along with two minor layout corrections.

### Fixed
- **Favicon Not Updating:** The `layout.blade.php` now reads the favicon from `rj_site_option('favicon')` with a fallback to the legacy `rj_get_option('site_favicon')` key. This resolves the issue where favicons selected in Admin → Appearance → Options were not displaying on the frontend.

### Improved
- **Footer Background Color:** Replaced the hardcoded `#0a0a0f` color with the dynamic CSS variable `var(--rj-footer-bg)`. The footer background now respects the customizer settings.
- **Image Placeholder:** Replaced the external GitHub-hosted fallback image with an inline Base64 SVG data URI. This removes external CDN dependency and improves loading performance for missing images.