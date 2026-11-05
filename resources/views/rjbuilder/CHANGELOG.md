# Spotlight Theme & RJ Builder Extensions — Changelog

## [v1.8.0] - 2026-11-05

This update brings the visual Icon Picker system to full functionality, introduces new Map and Contact widgets, and redesigns the Action Grid layout.

### Added
- **Spotlight Map Widget:** Created a free, API-keyless map widget using Leaflet.js and OpenStreetMap. Features a dark mode via CSS filters and custom markers.
- **Spotlight Contact Widget:** Created a new two-column contact section with dynamic RJ Form Builder integration.
- **Iconify Script in Builder:** Added `iconify-icon.min.js` to `edit.blade.php` so SVG icons render instantly in the admin panel.

### Fixed
- **Fatal Error (Service Provider):** Removed the non-existent `SpotlightAnimatedFeaturesWidget` from `SpotlightServiceProvider.php`. This was causing the Builder to crash entirely.
- **Repeater Icon Issue:** Added `sub.type === 'icon'` support to `repeater.blade.php`. Icon selection inside repeaters (e.g., Features list) is now visible.
- **Icon Picker UI Fixes:** Increased the modal's z-index (`z-[99999]`), forced text color to black (was invisible on white background), and forced icon color to dark (`#1e293b`).
- **Invisible Icons on Frontend:** Resolved the issue where `<iconify-icon>` tags were empty. Switched to the native `rj_icon()` helper for SVG rendering on the frontend.

### Improved
- **Action Grid Redesign:** Rewrote `SpotlightActionGridWidget` to match the reference design. Added a glowing background ring, corner brackets on icons, and glassmorphism buttons.
- **Colors & Defaults:** Forced blue icons (`#3b82f6`) in Action Grid, updated default text to professional copy, and assigned unique default icons to each item.
- **Visual Picker Support:** Changed the `icon` field type from `text`/`select` to `icon` in `SpotlightFeaturesGridWidget` and `SpotlightActionGridWidget` to enable the visual picker.
