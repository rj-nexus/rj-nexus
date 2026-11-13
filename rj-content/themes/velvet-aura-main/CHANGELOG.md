# Changelog

All notable changes to the VelvetAura theme will be documented in this file.

## [1.0.3-beta] - 2026-11-13

### 🐛 Bug Fixes & Improvements

This release synchronizes the theme with the new Site Options system for favicon and OG image handling.

### Fixed
- **Favicon Not Updating:** The `layout.blade.php` now reads the favicon from `rj_site_option('favicon')` with a fallback to the legacy `rj_get_option('site_favicon')` key. This resolves the issue where favicons selected in Admin → Appearance → Options were not displaying on the frontend.
- **OG Image Meta:** Added `og:image` meta tag support driven by `rj_site_option('og_image')` for improved social media previews.

---

## [1.0.2-beta] - 2026-11-12

### ⚡ Improvements
- **JSON Structure Update:** Replaced the `preview` key with `logo` in `theme.json` to align with the updated ecosystem standard and ensure proper rendering in the admin marketplace.
- **Default Logo Fixed:** Updated the default logo image URL to point to the correct raw GitHub asset for the theme header and customizer.

---

## [1.0.1-beta] - 2026-11-12

### Added
- **Default Logo:** Added a default logo image URL for the theme header and customizer.