# Changelog

All notable changes to RJ Nexus will be documented in this file.

## [v1.9.6] - 2026-11-17

### 🚀 Added
- **One-Click Core Auto-Updater:** The "Install Update Now" button now performs a full in-place update — downloads the release ZIP from GitHub, verifies `public/build/manifest.json`, replaces application files, runs migrations, and clears caches. No manual installation required.
- **Pre-Update Code Backup:** Before replacing files, the updater creates a ZIP snapshot of the current codebase (excluding `.env`, `storage/`, `vendor/`, user themes/plugins) so the system can roll back on failure.
- **Database Rollback:** If the update fails after migrations run, the database is automatically restored from the pre-update backup alongside the code rollback.
- **Update Settings Card:** Added `update_repo` input and `auto_check` toggle directly on the Updates page, so admins can change the GitHub source and disable automatic checks without editing files.

### ⚡ Changed
- **Update Button:** Renamed from "Prepare Update" to "Install Update Now" with a confirmation dialog and loading state ("Updating, please wait…").
- **Asset Selection:** Download now prefers `.zip` assets from the GitHub release, and skips prerelease versions when picking the latest stable release.
- **Download Request:** Added `User-Agent` and full redirect handling to GitHub downloads to avoid rate-limit and redirect failures.
- **Auto-Check Middleware:** `CheckForUpdates` now respects the `auto_check` setting and releases the cache lock on failure.
- **CheckUpdates Command:** Now uses the correct option keys (`last_release`/`last_checked`), reads `update_repo`, adds `download_url`, filters prereleases, and calls `GitHubService` instead of hitting the GitHub API directly.
- **GitHubService:** Added a fallback to the direct GitHub API when the proxy `/releases` endpoint is unavailable or returns invalid data.

### 🐛 Fixed
- **"Manual Installation Required" Message:** Removed. The updater now installs updates automatically; the message was a leftover placeholder that never performed a real update.
- **Missing Manifest Check:** Updates are aborted with a clear error if the release ZIP does not include `public/build/manifest.json`, preventing broken CSS/JS after install.
- **Stale Update Notifications:** After a successful update, all core update notifications are cleared from the admin bell.
- **Cache Invalidation:** `github_releases_*` and `rj_options` caches are cleared after an update so the next check returns fresh data.