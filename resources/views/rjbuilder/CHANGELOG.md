# RJ Builder — Changelog

All notable changes to the RJ Builder core and built-in widgets will be documented in this file.

## [v1.4.0] - 2026-10-29

This is a major feature update introducing structural layout builders, dedicated footer widgets, advanced responsive controls, and critical bug fixes.

### Added (New Widgets & Features)
- **Footer Widget Suite:** Introduced 6 dedicated footer widgets for complete layout control:
  - `Footer About` (Logo, title, description, social links).
  - `Footer Badges` (Payment gateway logos with original, white, black, and grayscale color modes).
  - `Footer Contact` (Contact info with Iconify support).
  - `Footer Copyright` (Dynamic year and privacy links).
  - `Footer Links` (Custom vertical/horizontal link blocks).
  - `Footer Newsletter` (Compact AJAX subscription form).
- **Flex Container (`structure-container`):** Added a new structural layout widget specifically designed for Header, Footer, Block, and Popup templates. Supports up to 5 columns, advanced Flexbox controls (justify, align, direction), and automatic element centering.
- **Responsive Ordering:** Added Desktop, Tablet, and Mobile ordering controls (`_order_desktop`, `_order_tablet`, `_order_mobile`) to the Motion tab. Users can now reorder or hide elements on specific devices using modern CSS Container Queries.
- **Payment Logo Integration:** Integrated the `rare-logos-vault` repository to provide 22 official payment gateway and trust badge logos (Visa, Mastercard, PayPal, M10, Leobank, etc.) directly from a CDN.

### Fixed (Bug Fixes)
- **Missing Classes:** Resolved the `Class not found` error by correctly generating and registering all 6 new Footer Widget PHP classes in the `WidgetList`.
- **Header Language Switcher:** The widget now strictly respects the `frontend_locales` setting. If only one language is active, the widget automatically hides itself.
- **Posts Widget:** Fixed the 500 Server Error caused by using `$this` inside the Blade view. The rendering logic was refactored and moved back to the Blade file.
- **Logo Widget:** Fixed the issue where the logo became invisible on white backgrounds, failed to change sizes, and was being overridden by the global placeholder script inside the canvas.
- **Portfolio & Gallery (Advanced):** Fixed the lightbox image mismatch when filtering categories. Clicking a filtered image now correctly opens that specific image.
- **Missing Views:** Created the missing `google-review-card.blade.php` partial which was causing fatal errors.
- **Broken Images:** Implemented a global fallback system (`rj-nexus-no-image.webp`) for empty or broken image sources.

### Improved (Enhancements)
- **Widget List Organization:** Completely reorganized `WidgetList.php` into logical categories (Header, Footer, Core, Media, Content, Marketing, etc.) for easier discovery in the builder panel.
- **Repeater Custom Categories:** Redesigned the category selection UI. Users can select from global categories or click "+ Add New Category" directly inside the dropdown. Newly created categories automatically sync with the global list.
- **Demo Data Injection:** Added default demo data to all repeater-based widgets so they look properly populated immediately upon being added to the page.
- **Dynamic Tag Picker UI:** Updated the modal to support the Dark Theme, making it consistent with the rest of the builder and improving text readability.
