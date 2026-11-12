# Changelog

All notable changes to the Spotlight theme will be documented in this file.

## [1.0.3] - 2026-11-12

### ⚡ Improvements
- **JSON Structure Update:** Replaced the `preview` key with `logo` in `theme.json` to align with the updated ecosystem standard and ensure proper rendering in the admin marketplace.
- **Preview Image:** Mapped the `logo` key directly to the actual screenshot URL for accurate visual display.

---

## [1.0.2] - 2026-11-12

### 🛡️ Security Patch & Fixes

This release addresses critical security vulnerabilities (Stored XSS) within the theme templates and fixes the default logo configuration.

### Security Fixes
- **XSS Protection in Templates:** Sanitized page content output in `contact.blade.php`, `landing.blade.php`, and `page.blade.php`. Replaced unescaped output (`{!! !!}`) with `strip_tags()` to prevent malicious script injection via the Classic Editor while maintaining safe HTML formatting.

### Bug Fixes & Improvements
- **Default Logo Fixed:** Corrected the incorrect image URL in `theme.json` for the customizer's default logo setting.
- **Preview Image:** Updated the theme preview image URL to point to the correct raw GitHub asset.