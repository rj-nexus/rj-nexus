# Changelog

All notable changes to the Spotlight theme will be documented in this file.

## [0.5.0-beta]

This update focuses on resolving critical Git merge conflicts, stabilizing the widget registration, and heavily refining the visual design of the Action Grid and Contact Form widgets.

### Fixed
- **Git Merge Conflicts:** Resolved critical merge conflict markers (`<<<<<<< HEAD`) that caused PHP syntax errors and broken layouts in `SpotlightActionGridWidget.php`, `spotlight-action-grid.blade.php`, and `spotlight-trustpilot.blade.php`.
- **Service Provider Crash:** Removed the non-existent `SpotlightAnimatedFeaturesWidget` from `SpotlightServiceProvider`, which was previously causing a fatal error and preventing all Builder widgets from loading.
- **Trustpilot Widget Cleanup:** Cleaned up redundant comments and fixed the HTTP request timeout logic in the Trustpilot widget.

### Improved
- **Widget Registration:** Updated `SpotlightServiceProvider` to properly register all newly added widgets (`SpotlightMapWidget`, `SpotlightContactWidget`, `SpotlightActionGridWidget`, `SpotlightFeaturesGridWidget`, etc.).
- **Contact Form Design:** Completely bypassed the default Form Builder plugin view. The Contact widget now manually renders the form fields to perfectly match the dark, glassmorphism 2-column design without relying on external plugin CSS.
- **Action Grid Refinement:** Polished the Action Grid widget with blue accent colors, a glowing background ring, and interactive corner brackets on hover.
