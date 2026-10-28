# RJ Builder — Changelog

All notable changes to the RJ Builder core and built-in widgets will be documented in this file.

## [v1.3.29] - 2026-10-28

This release focuses on significantly expanding the built-in widget library, resolving critical backend rendering issues, and drastically improving the user experience (UX) for content management.

### Added (New Widgets)
Introduced over 30 new fully functional widgets across various categories:
- **Header & Auth:** Header Login Button (with AJAX support), Header Language Switcher, Login (Section).
- **Media:** Portfolio (Filterable), Gallery (Advanced), Object 3D, Video Mask Text, Logo Grid/Carousel, Lottie Animation, Hotspot, and a Multi-source Music Player (Audius, Deezer, Jamendo, Local with Audio Visualizer).
- **Marketing & Conversion:** Call to Action (CTA), Promo Banner, Wheel of Fortune, GDPR-compliant Cookie Notice (auto-loads GA/GTM/Meta Pixel), Newsletter Signup, Social Feed (oEmbed and RSS support), Multi-Chat (18 platforms), Google Reviews (API and Manual), Currency Rates (Live API).
- **Content:** Animated Headline, Dual Color Heading, Blockquote, Step Flow, Price List, Price Table, Flip Box, Code Highlight, Business Hours, Contact Info Cards.

### Fixed (Bug Fixes)
- **Logo Widget:** Resolved the issue where the logo would become invisible on white backgrounds or fail to change sizes. Also fixed the global placeholder script that was overriding the logo inside the builder canvas.
- **Posts Widget:** Fixed a 500 Server Error caused by using `$this` within the Blade view. The rendering logic was fully refactored and moved to the Blade file.
- **Portfolio & Gallery (Advanced):** Fixed the lightbox image mismatch when filtering categories. Clicking a filtered image now correctly opens that specific image in the lightbox.
- **Missing Views:** Created the missing `google-review-card.blade.php` partial which was causing errors.
- **Broken Images:** Implemented a global fallback system (`rj-nexus-no-image.webp`) for empty or broken image sources.
- **Header Language Switcher:** The widget now respects the CMS's `frontend_locales` setting. Only languages selected in Admin → Settings → Language → Frontend Languages are shown. If only one language is available, the widget hides itself automatically.

### Improved (Enhancements)
- **Repeater Custom Categories:** Completely redesigned the category selection UI for Portfolio and Gallery. Users can now select from global categories or click "Add New Category" directly inside the dropdown. Newly created categories automatically sync with the global list.
- **Demo Data Injection:** Added default demo data to all repeater-based widgets (Portfolio, Price Table, Step Flow, etc.) so they look properly populated immediately upon being added to the page.
- **Widget List:** Reorganized and registered all old and new widgets into clean, logical categories for easier discovery.
- **Dynamic Tag Picker UI:** Updated the modal to support the Dark Theme, making it consistent with the rest of the builder and improving text readability.
