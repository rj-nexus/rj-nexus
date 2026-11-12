# Changelog

All notable changes to the Spotlight theme will be documented in this file.

## [1.0.0] - 2026-11-12

This is the first official **Stable Release** of the Spotlight theme. The theme is now fully featured, highly customizable, and ready for production use.

### 🌟 Features
- **RJBuilder Integration:** 20+ custom-built interactive widgets tailored for dark SaaS/product showcases.
- **Starter Content:** Auto-generation of default pages (Home, About, Contact, Pricing), menus, and Header/Footer templates upon activation.
- **Custom 404 Page:** A beautifully animated, glassmorphism-themed 404 error page.
- **Product List Widget:** A new glassmorphism grid for showcasing products with hover effects and pricing badges.
- **Custom Templates:** Dedicated templates for Contact, Landing, and Full-Width pages.
- **Deep Customizer:** Dynamic CSS variables for colors, typography, and layout via the admin panel.

### 🐛 Bug Fixes
- Resolved all merge conflicts in Action Grid and Trustpilot widgets.
- Fixed missing views for Action Grid and Map widgets.

### ⚡ Improvements
- **Map Widget:** Switched to OpenStreetMap + CSS filters for a 100% free, API-keyless dark mode map.
- **UI Consistency:** Removed hardcoded accent colors across widgets and enforced a strict glassmorphism design system (transparent backgrounds, white borders).
- **Multilingual Support:** Fully compatible with the 38 languages added in RJ Nexus v1.9.1.

---

## [0.5.1-beta] - 2026-11-06

### 🛡️ Security Release

This update addresses critical security vulnerabilities (Stored XSS) within the theme templates and is highly recommended for all users.

### Security Fixes
- **XSS Protection in Templates:** Sanitized page content output in `contact.blade.php`, `landing.blade.php`, and `page.blade.php`. Replaced unescaped output (`{!! !!}`) with `strip_tags()` to prevent malicious script injection via the Classic Editor while maintaining safe HTML formatting.