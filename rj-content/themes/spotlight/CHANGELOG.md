# Changelog

All notable changes to the Spotlight theme will be documented in this file.

## [0.4.0-beta]

This update introduces several new, highly requested widgets and significantly improves the Builder integration, specifically the visual Icon Picker and Form Builder compatibility.

### Added
- **Spotlight Action Grid:** A 3-column layout with cornered icons, titles, text, and buttons. Perfect for Contact pages with a premium glassmorphism hover effect.
- **Spotlight Contact (Form):** A two-column contact layout featuring contact info on the left and seamless integration with the RJ Form Builder plugin on the right, styled in dark mode.
- **Spotlight Divider:** A clean, customizable divider widget to elegantly separate page sections.
- **Spotlight Features Grid:** A compact split layout with an animated rotating core and sleek glass feature cards.
- **Spotlight Map:** A fully customizable dark-mode map widget using Leaflet.js and OpenStreetMap. API-keyless and features custom markers.
- **Spotlight Team:** A grid layout to showcase team members, their roles, and social links with hover animations.
- **Spotlight Trustpilot:** A dedicated widget to dynamically fetch and display real Trustpilot reviews and ratings.

### Fixed
- **Service Provider Fatal Error:** Removed the non-existent `SpotlightAnimatedFeaturesWidget` from the Service Provider which previously caused the Builder to crash entirely.
- **Repeater Icon Field:** Fixed the issue where the Icon field inside Repeaters was invisible. Added `sub.type === 'icon'` rendering logic to `repeater.blade.php`.
- **Icon Picker UI:** Increased the z-index to `z-[99999]` so the Icon Picker modal appears above the Repeater modal. Fixed unreadable text (white on white) and forced a dark color on icons for visibility.
- **Form Builder Fallback:** Added a fallback UI with a download link and support links for when the Form Builder plugin is not installed or a form is not selected.

### Improved
- **Visual Icon Integration:** Replaced hardcoded icon selects with visual Icon Pickers in `SpotlightActionGridWidget` and `SpotlightFeaturesGridWidget`.
- **Unique Default Icons:** Assigned distinct, professional default icons and placeholder text to Action Grid items so the widget looks complete upon insertion.
- **Dark Mode Map:** Utilized CSS filters (`invert`, `hue-rotate`) to convert standard OpenStreetMap tiles into a sleek dark mode without requiring paid API keys like CARTO.
- **Action Grid Redesign:** Completely rewrote the Action Grid view to match the reference layout with glowing background rings, corner brackets on icons, and glassmorphism buttons.

---

## [0.3.0-beta]

This update transforms Spotlight into a complete, premium SaaS/product showcase theme. We added 9 new fully custom, interactive widgets and heavily optimized the layout and UI.

### Added
- **Spotlight Showcase:** A centered text and image showcase with an upward glowing effect and a shine hover animation.
- **Spotlight Tabs:** Animated glassmorphism tabs with a dynamic background planet that changes colors and position based on the active tab.
- **Spotlight Features:** A 3-column feature grid with Iconify integration, custom top visual support, and glowing active states.
- **Spotlight Steps:** A split-layout "How to use" section with a sticky left visual that changes as the user scrolls through the right text steps.
- **Spotlight Pricing:** Premium glass pricing cards with a monthly/yearly toggle, rotating border beams, and floating 3D elements.
- **Spotlight Testimonials:** Infinite scrolling marquee rows (left-to-right and right-to-left) with a rotating background globe and dark glass cards.
- **Spotlight FAQ:** An interactive accordion with glowing icons, animated dividers, and a smooth height transition.
- **Spotlight Newsletter:** A glass form with an advanced "Black Hole" button animation that swallows the form upon successful subscription.
- **Spotlight Footer:** A highly structural footer with perfect CSS grid lines, `+` intersection marks, and dynamic CMS menu integration.

### Fixed
- **Double Scrollbar Issue:** Replaced `overflow-x: hidden` with `overflow-x: clip` in `layout.blade.php` to fix the unwanted secondary scrollbar.
- **Footer Starfield Bleed:** Enforced a solid `#0a0a0f` background and `z-index` on the footer wrapper to prevent the global starfield from bleeding through.
- **Missing Use Statement:** Added the missing `use Spotlight\Widgets\SpotlightStepsWidget;` in `SpotlightServiceProvider` which previously broke the widget registry.
- **Pricing Widget Crash:** Added array-to-string conversion fallback for the `plans` field to prevent 500 errors on legacy data.
- **Taxonomy Routing:** Updated `single-post.blade.php` and `loop-card.blade.php` to use query-based URLs (`?term=...&taxonomy=...`) to prevent `RouteNotFoundException`.

### Improved
- **Hero Widget:** Added Ping-Pong video reverse playback, external video URLs, color grading filters (hue, saturate, contrast), and HUD elements.
- **Logos Widget:** Added infinite marquee support, jsDelivr CDN fallback for SVG MIME issues, and editable HUD lines.
- **Header Widget:** Added dynamic CMS menu fallback logic and integrated a glassmorphism login modal directly into the header.
- **Builder Integration:** Fully polished the UI to be 100% transparent where needed (to show the starfield) and solid where it matters (footer), perfectly matching the premium dark aesthetic.

---

## [0.2.0-beta]

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