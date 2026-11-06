# Changelog

All notable changes to RJ Nexus will be documented in this file.

## [v1.9.0] - 2026-11-06

### 🛡️ Stable Security Release

This is the first fully stable release of RJ Nexus (v1.9.0). This release is dedicated to a comprehensive security audit and the mitigation of all discovered vulnerabilities. The entire codebase has been scanned and tested using industry-standard security tools (LaraScan, Laravel Pentest, Laravel Security), and all identified risks have been resolved.

### 🔒 Security Fixes

- **Mass Assignment Protection:** 
  - Removed dangerous attributes (`status`, `role`, `password`, `user_id`, `token`) from the `$fillable` array across all sensitive models (`User`, `Post`, `Comment`, `FormSubmission`, `KycVerification`, `NewsletterSubscriber`, `CustomField`, `AiLog`, etc.).
  - Implemented manual, secure assignment of these excluded attributes within their respective Controllers and Services.
- **XSS (Cross-Site Scripting) Mitigation:**
  - Sanitized user-controllable content output using `strip_tags` in critical views (`admin/posts/show.blade.php`, `rj-default/home.blade.php`, `page.blade.php`, `post.blade.php`, `contact.blade.php`, and Spotlight theme templates).
  - Verified and secured RJBuilder widgets (`multi-chat`, `advanced-search`, etc.) using custom escaping (`esc()`) and safe URL handling.
- **Command Injection & Path Traversal Protection:**
  - Replaced vulnerable `shell_exec()` and `exec()` calls with Laravel's `Process::run()` facade in `GenerateAiContext.php`, `BackupSettingsController.php`, and `ThemeEditorService.php`.
  - Hardened `MediaCleanupController` by adding strict path validation (`realpath`, `str_starts_with`) to the `unlink()` function.
- **Host Header Injection Protection:**
  - Implemented `URL::forceRootUrl()` and `TrustHosts` middleware in `AppServiceProvider` and `bootstrap/app.php` to prevent host header spoofing.
- **Proxy/Cloudflare Lockout Protection:**
  - Introduced `rj_proxy_status()` helper and applied a fail-open mechanism in `AdminMiddleware` to prevent administrators from locking themselves out when behind Cloudflare or proxies.
- **Environment Variable Hardening:**
  - Fixed `.env` injection vulnerability in the `rj_set_env()` helper. Removed `shell_exec` and added strict regex validation for keys and values.
- **Session Security:**
  - Added `ForceHttps` middleware to redirect HTTP to HTTPS automatically.
  - Added automatic SSL detection for `SESSION_SECURE_COOKIE`.
  - Added a global `SecurityHeaders` middleware to inject `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, and `HSTS` into all responses, including error pages.

### 🛑 Rate Limiting & Middleware
- **Authentication Routes:** Applied dynamic `RateLimiter` (throttle) rules to Login, Register, 2FA, and Password update routes.
- **Admin Panel:** Secured all Admin resource routes (`posts`, `users`, `media`, `rjbuilder`, etc.) against DoS attacks using `throttle:60,1` and `throttle:120,1`.
- **SEO & Utility Routes:** Added rate limiting to `sitemap.xml`, `robots.txt`, and `pentest` (testing tool) routes.

### 🐛 Bug Fixes & Improvements
- **Admin Post View:** Fixed the "View Site" button in `admin/posts/show.blade.php`. It now correctly uses the `$post->public_url` attribute, ensuring that both Posts and Pages redirect to their correct frontend URLs (instead of always appending `/blog/`).
- **Theme & Plugin Updates:** 
  - Updated **Form Builder** plugin to `v1.2.1` (Security Release).
  - Updated **Spotlight** theme to `v0.5.1-beta` (Security Patch).
  - Updated **RJ Default** theme to `v1.0.0` (Stable).
- **Dependencies:** Executed `composer update` and `npm audit fix` to resolve known CVEs in Symfony components and `follow-redirects`.
- **Testing Tools Cleanup:** Removed all security scanning tools (`LaraScan`, `Laravel Pentest`, `Laravel Security`) and their configs/reports from the production codebase.