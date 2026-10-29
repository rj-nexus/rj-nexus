# RJ Builder — Changelog

All notable changes to the RJ Builder core and built-in widgets will be documented in this file.

## [v1.5.0] - 2026-10-29

This is a massive stability and architecture update focusing on the Live Preview system, rendering performance, custom error handling, and deep plugin integrations.

### Added (New Widgets & Features)
- **Universal Live Preview System:** Introduced a dedicated, isolated preview route and view for both `Template` (Header/Footer/Popup) and `Post` (Pages). The preview now accurately renders theme headers/footers for pages and standalone blocks for components.
- **RJ Nexus Debug Screen (500 Errors):** Created a fully custom, premium-designed (dark mode, glassmorphism) debug screen for `APP_DEBUG=true`. It replaces the default Laravel Ignition screen for 500-level errors and includes a direct link to the GitHub Support Discussions.
- **View Page Button:** Added a dynamic "View Page" button directly in the Builder top bar for published pages and templates.
- **Widget Render Caching:** Implemented `RJ_WIDGET_CACHE` and `AbortController` to cache rendered HTML and cancel pending network requests, significantly reducing server load.

### Fixed (Bug Fixes)
- **Live Preview 404 Error:** Resolved the critical issue where the Live Preview button resulted in a 404. Fixed by passing the correct `id`, `slug`, `previewUrl`, and `viewUrl` from controllers to the builder array.
- **Infinite Render Loop / Session Lock:** Fixed the severe bug where typing in the settings panel caused hundreds of simultaneous `render-block` requests, locking the Laravel session. Implemented a robust 250ms Debounce mechanism in `updateSetting`.
- **HTML Syntax Break:** Fixed the bug where complex JSON settings broke the Alpine.js `x-data` attribute, causing raw JavaScript code to leak onto the canvas.
- **Footer Links Deterministic UID:** Fixed an issue where the `FooterLinksWidget` generated a new `uniqid()` on every render, causing DOM thrashing. The UID is now based on the settings hash.
- **Form Builder Integration:** Resolved the issue where the Form widget failed to render. Redesigned the `widget.blade.php` to use inline CSS (eliminating Tailwind conflicts), added the missing Form Title/Description, and fixed the data parsing for form fields.

### Improved (Enhancements)
- **Debounced Updates:** Settings changes are now applied smoothly after the user stops typing, drastically improving editor performance.
- **AJAX Save Flushing:** The `Save` function now forces pending debounced updates to flush immediately before saving, ensuring no data is lost.
- **Smart Error Handling:** The exception handler now strictly distinguishes between HTTP exceptions (404, 403) and internal server errors (500), only showing the custom RJ Debug screen for critical 500-level errors.
