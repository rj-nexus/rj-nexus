# RJ Builder & Theme Extensions — Changelog

## [v1.9.4] - 2026-11-20

### 🚀 Features & Improvements
- **Spotlight Theme (Documentation System):**
  - Added a fully integrated Documentation (`/docs`) page to the Spotlight theme.
  - Implemented `DirectoryController@docs` to fetch Markdown files, `menu.json`, and `search.json` directly from GitHub.
  - Built a custom, vanilla JavaScript-based fuzzy search (Fuse.js) for the Docs page with excerpt highlighting and typo tolerance.
  - Updated the GitHub Pages `generate-search.js` script to preserve code blocks, extract sub-headings, and generate fallback titles for better search indexing.
  - Improved GitHub Pages `index.html` Fuse.js configuration to match the CMS search logic.

- **Localization:**
  - Added Hebrew (`he`) and Thai (`th`) languages to the system.
  - Added corresponding translations to the Installer wizard (`he.php`, `th.php`).

### 🛠 Bug Fixes
- **Backup System:**
  - Fixed the database restore process to use chunk-based streaming (`64KB`) instead of loading the entire SQL file into memory, preventing "Allowed memory size exhausted" errors.
  - Fixed the backup progress bar blocking issue by adding `session_write_close()` to the controller, allowing asynchronous polling.
  - Added `deleteStaleProgress` to clear old progress states before starting new backups/restores.
  - Polished the backup modal UI for better success and error feedback.

- **RJBuilder (Canvas):**
  - Fixed the canvas background not matching the active theme. The builder now dynamically injects `rj_theme_mod` colors directly into the `#rj-canvas` inline styles.
  - Auto-detects dark themes (e.g., Spotlight) to apply dark backgrounds and proper text colors, ensuring transparent widgets are visible during editing.

- **Admin Sidebar:**
  - Fixed the issue where both "Posts" and "Pages" menus remained active simultaneously. The sidebar now correctly detects the post type via route parameters, query strings, and model binding.

- **Update System:**
  - Fixed the pseudo-cron auto-update mechanism to properly throttle checks to once every 15 minutes using an atomic cache lock, preventing GitHub API rate limit exhaustion.

- **Installer:**
  - Removed the dependency on `exec()` and `shell_exec()`. 
  - Implemented native PHP fallbacks for `config:clear`, `cache:clear`, `optimize:clear`, and `storage:link`.
  - Added native Laravel Kernel fallback to run `migrate` and `db:seed` without shell access, making the installer fully compatible with restrictive shared hosting environments.