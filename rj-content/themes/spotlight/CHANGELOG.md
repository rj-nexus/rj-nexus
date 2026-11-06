# Changelog

All notable changes to the Spotlight theme will be documented in this file.

## [0.5.1-beta] - 2026-11-06

### 🛡️ Security Release

This update addresses critical security vulnerabilities (Stored XSS) within the theme templates and is highly recommended for all users.

### Security Fixes
- **XSS Protection in Templates:** Sanitized page content output in `contact.blade.php`, `landing.blade.php`, and `page.blade.php`. Replaced unescaped output (`{!! !!}`) with `strip_tags()` to prevent malicious script injection via the Classic Editor while maintaining safe HTML formatting.