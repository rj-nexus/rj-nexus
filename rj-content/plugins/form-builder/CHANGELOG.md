# Changelog

All notable changes to this project will be documented in this file.

## [1.2.1] - 2026-11-06

### 🛡️ Security Patch

This patch release adds an additional layer of security to the admin routes to prevent DoS (Denial of Service) and brute-force attacks.

- **Rate Limiting Added:** Applied `throttle:60,1` middleware to all admin routes (`admin/plugin/forms/*`) in `routes/admin.php` to restrict excessive requests.
