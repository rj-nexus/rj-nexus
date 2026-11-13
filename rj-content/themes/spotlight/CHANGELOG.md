# Changelog

All notable changes to the Spotlight theme will be documented in this file.

<<<<<<< HEAD
## [1.0.3] - 2026-11-12

### ⚡ Improvements
- **JSON Structure Update:** Replaced the `preview` key with `logo` in `theme.json` to align with the updated ecosystem standard and ensure proper rendering in the admin marketplace.
- **Preview Image:** Mapped the `logo` key directly to the actual screenshot URL for accurate visual display.

---

## [1.0.2] - 2026-11-12

### 🛡️ Security Patch & Fixes

This release addresses critical security vulnerabilities (Stored XSS) within the theme templates and fixes the default logo configuration.
=======
## [1.0.4] - 2026-11-13

### 🐛 Bug Fixes & Improvements

This release fixes favicon synchronization between the admin Site Options and the frontend, along with two minor layout corrections.
>>>>>>> 34a4bf862ff0d1f2b0926801c8cf2620aa13aa52

### Fixed
- **Favicon Not Updating:** The `layout.blade.php` now reads the favicon from `rj_site_option('favicon')` with a fallback to the legacy `rj_get_option('site_favicon')` key. This resolves the issue where favicons selected in Admin → Appearance → Options were not displaying on the frontend.

<<<<<<< HEAD
### Bug Fixes & Improvements
- **Default Logo Fixed:** Corrected the incorrect image URL in `theme.json` for the customizer's default logo setting.
- **Preview Image:** Updated the theme preview image URL to point to the correct raw GitHub asset.
=======
### Improved
- **Footer Background Color:** Replaced the hardcoded `#0a0a0f` color with the dynamic CSS variable `var(--rj-footer-bg)`. The footer background now respects the customizer settings.
- **Image Placeholder:** Replaced the external GitHub-hosted fallback image with an inline Base64 SVG data URI. This removes external CDN dependency and improves loading performance for missing images.
>>>>>>> 34a4bf862ff0d1f2b0926801c8cf2620aa13aa52
