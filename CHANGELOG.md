# Changelog

## [v1.12.1] - 2026-11-27

### 🚀 Added

- **Direct Edit / Show links on Posts and Pages:** the post and page list now includes a direct link button for each item, so you can jump straight to the **Edit** or **Show** view without opening the row first.

### ✨ Improved

- **User management (index, edit, create):** refreshed design. These pages previously ignored the active system color preset and rendered with fixed colors — they now follow the admin color theme correctly.
- **Posts and Pages — Edit and Create:** character limits added for the **name** and **slug** fields, preventing very long values from breaking the layout.
- **Posts and Pages — Show page:** long titles and slugs no longer stretch the layout. Text is now truncated cleanly.
- **Marketing Post Generator:** UI refinements across the design studio for a smoother workflow.
- **General UI polish** across the admin panel — small spacing, alignment and color consistency fixes throughout.
- **RJ Builder:** has its own set of changes for this release — see `resources/views/rjbuilder/CHANGELOG.md`.

### 🐛 Fixed

- **Marketing Post Generator — image download:** after preparing a design, the exported image could not be downloaded. PNG, JPG, WebP and ZIP export is now fully working.