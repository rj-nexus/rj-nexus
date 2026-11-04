# Changelog

All notable changes to the Spotlight theme will be documented in this file.

## [0.1.0-beta] - 2026-11-04

This is the initial beta release of the Spotlight theme. A dark-first, builder-focused theme designed for modern product showcases and content delivery.

### Added
- **Theme Manifest:** Created `theme.json` with a comprehensive dark color palette, typography options, layout settings, and customizer support.
- **Glassmorphism Header Widget:** Added a sticky, transparent header widget with dynamic navigation, language switcher, and an inline login modal.
- **Cinematic Hero Widget:** Added a full-screen hero widget with background video support, overlay opacity control, and staggered fade-up animations.
- **Service Provider:** Implemented `SpotlightServiceProvider` to automatically register custom theme widgets with RJBuilder.
- **Custom Templates:** Added dedicated templates for Contact, Landing, and Full-Width pages.
- **Dynamic CSS Variables:** The `layout.blade.php` now reads Customizer values (`rj_theme_mod`) to dynamically output colors, fonts, and spacing.
- **Post Grid Fallback:** The `home.blade.php` now displays a styled "Latest Stories" grid when a static front page is not selected.

### Fixed
- **Taxonomy Routing:** Updated `single-post` and `loop-card` partials to use query-based URLs (`?term=...&taxonomy=...`) to prevent routing errors.
- **Contact Form:** Replaced the hardcoded form with a Builder-first approach, showing a hint if the user hasn't added a Form widget.
- **Popup Layout Bleed:** Enforced inline `display: none` on the popup wrapper to prevent it from bleeding into the footer before JavaScript loads.

### Improved
- **Builder Integration:** Fully integrated with RJBuilder. Page rendering now strictly respects builder mode, block content, and classic mode fallbacks.
