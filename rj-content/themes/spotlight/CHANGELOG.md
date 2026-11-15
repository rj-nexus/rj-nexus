# Changelog

All notable changes to the Spotlight theme will be documented in this file.

## [1.1.1] - 2026-11-16

### 🚀 Patch Release: New Widgets & Fixes

This release introduces 5 powerful new widgets designed for modern SaaS and AI landing pages, fixes view rendering errors, and ensures all widgets have default demo content.

### Added
- **Bento Grid Widget:** A masonry-style grid with varying box sizes (1x1, 2x1, 1x2, 2x2) to showcase features and stats in a modern layout.
- **Stats Widget:** A counter section with scroll-triggered animations to display key metrics (e.g., "10K+ Users").
- **CTA Banner Widget:** A high-impact call-to-action section with a glowing grid background and gradient buttons.
- **Video Showcase Widget:** A sleek browser mockup layout with a lightbox play button to present product videos (YouTube, Vimeo, or MP4).
- **Comparison Table Widget:** A responsive, side-by-side pricing/feature comparison table with "Popular" plan highlighting.

### Fixed
- **View Namespace Error:** Fixed the `No hint path defined for [spotlight]` error by registering the theme's view namespace in `SpotlightServiceProvider`.
- **Demo Content:** Added default demo data to the schemas of the new widgets so they look great right out of the box.

### Improved
- **Branding:** Updated the default logo image to reflect the latest version.