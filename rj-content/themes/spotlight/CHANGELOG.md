# Changelog

All notable changes to the Spotlight theme will be documented in this file.

## [1.0.1] - 2026-11-12

### 🛡️ Security Patch & Improvements

This release addresses critical security vulnerabilities (Stored XSS) within the theme templates and applies minor configuration updates.

### Security Fixes
- **XSS Protection in Templates:** Sanitized page content output in `contact.blade.php`, `landing.blade.php`, and `page.blade.php`. Replaced unescaped output (`{!! !!}`) with `strip_tags()` to prevent malicious script injection via the Classic Editor while maintaining safe HTML formatting.

### Improvements
- **Default Logo:** Updated `theme.json` to include a default logo image URL for the customizer.