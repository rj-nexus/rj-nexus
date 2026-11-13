# Changelog

All notable changes to the RJ Default theme will be documented in this file.

## [1.0.2] - 2026-11-13

### 🐛 Bug Fixes & Improvements

This release fixes favicon synchronization with the new Site Options system and removes external CDN dependency for the image placeholder.

### Fixed
- **Favicon Not Updating:** The `layout.blade.php` now reads the favicon from `rj_site_option('favicon')` with a fallback to the legacy `rj_get_option('site_favicon')` key. This resolves the issue where favicons selected in Admin → Appearance → Options were not displaying on the frontend.

### Improved
- **Image Placeholder:** Replaced the external GitHub-hosted fallback image (`raw.githubusercontent.com/mr-ruhid/...`) with an inline Base64 SVG data URI. This removes external CDN dependency and improves loading performance for missing images.

---

## [1.0.1] - 2026-11-12

### ⚡ Improvements
- **JSON Structure Update:** Replaced the `preview` key with `logo` in `theme.json` to align with the updated ecosystem standard and ensure proper rendering in the admin marketplace.
- **Default Logo Fixed:** Updated the default logo image URL to point to the correct raw GitHub asset.

---

## [1.0.0] - 2026-11-06

### 🎉 Initial Stable Release

This is the first official stable release of the RJ Default theme. A clean, minimal, and fast theme built for blogs and content sites.

### Added
- **Theme Manifest:** Created `theme.json` with a clean color palette, typography options, and layout settings.
- **Glassmorphism Header Widget:** Sticky, transparent header with dynamic navigation and login modal.
- **Custom Templates:** Dedicated templates for Contact, Landing, and Full-Width pages.
- **Dynamic CSS Variables:** The `layout.blade.php` reads Customizer values to dynamically output colors, fonts, and spacing.
- **Post Grid Fallback:** Displays a styled grid when no static front page is selected.
- **Builder Integration:** Fully integrated with RJBuilder.