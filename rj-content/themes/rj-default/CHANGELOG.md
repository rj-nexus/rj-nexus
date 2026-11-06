# RJ Nexus — Changelog

All notable changes to this project will be documented in this file.

## [1.0.0] - 2026-11-06

### 🎉 Initial Stable Release

This is the first fully stable release of RJ Nexus. This release is primarily dedicated to a **comprehensive security audit** and the mitigation of all discovered vulnerabilities. The application has been thoroughly scanned and tested using industry-standard security tools (LaraScan, Laravel Pentest, Laravel Security), and all identified risks have been resolved.

### 🛡️ Security Fixes & Enhancements

#### Mass Assignment Protection
- **Models:** Removed dangerous attributes (`status`, `role`, `password`, `user_id`, `token`) from the `$fillable` array across all sensitive models, including `User`, `Post`, `Comment`, `FormSubmission`, `KycVerification`, `NewsletterSubscriber`, `CustomField`, and `AiLog`.
- **Controllers & Services:** Implemented manual, secure assignment of these excluded attributes within `PostController`, `PostService`, `CommentService`, `KycManager`, and `NewsletterSubscriber` to ensure functionality remains intact.

#### XSS (Cross-Site Scripting) Protection
- **Admin & Frontend Views:** Sanitized user-controllable content output using `strip_tags` in critical views such as `posts/show.blade.php`, `rj-default/home.blade.php`, `page.blade.php`, `post.blade.php`, and `contact.blade.php`. This mitigates Stored XSS attacks via page and post content.
- **Widgets & Builder:** Verified and secured RJBuilder widgets (`multi-chat`, `advanced-search`, etc.) using custom escaping (`esc()`) and safe URL handling (`safeUrl()`) to prevent script injection.

#### Command Injection & Path Traversal Protection
- **Symfony Process:** Replaced vulnerable `shell_exec()` and `exec()` calls with Laravel's `Process::run()` facade in `GenerateAiContext.php`, `BackupSettingsController.php`, and `ThemeEditorService.php`.
- **File Deletion:** Hardened `MediaCleanupController` by adding strict path validation (`realpath`, `str_starts_with`) to the `unlink()` function, preventing path traversal attacks.

#### Network & Host Security
- **Host Header Injection:** Implemented `URL::forceRootUrl()` and `TrustHosts` middleware in `AppServiceProvider` and `bootstrap/app.php` to prevent host header spoofing.
- **Proxy/Cloudflare Support:** Introduced `rj_proxy_status()` to detect proxies. Implemented a fail-open mechanism in `AdminMiddleware` to prevent administrators from locking themselves out when behind Cloudflare or a proxy.
- **HTTP Headers:** Added a `SecurityHeaders` middleware to apply critical headers (`X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, `HSTS`) to all responses, including error pages.
- **Force HTTPS:** Added `ForceHttps` middleware to automatically redirect HTTP requests to HTTPS when an SSL certificate is active.

#### Authentication & Rate Limiting
- **Brute-Force Protection:** Applied dynamic `RateLimiter` (throttle) rules to Login, Register, 2FA, and Password update routes.
- **Admin Panel Limits:** Secured all Admin resource routes (`posts`, `users`, `media`, `rjbuilder`, etc.) against DoS attacks using `throttle:60,1` and `throttle:120,1`.
- **Session Security:** Added automatic SSL detection for the `SESSION_SECURE_COOKIE` configuration.

#### Dependencies & Plugins
- **Composer & NPM:** Executed `composer update` and `npm audit fix` to resolve known CVEs in Symfony components and `follow-redirects`.
- **Form Builder Plugin:** Updated the plugin to `v1.2.0` (Security Release) to fix Mass Assignment and frontend validation vulnerabilities.

---

**Note:** Following this release, the application is fully secure at the code level. For production deployment, it is highly recommended to configure server-level settings such as `.env` file permissions and restricted MySQL user privileges.