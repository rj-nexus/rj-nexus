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
- **Theme/Plugin Metadata Wipe:** Fixed the bug where `ThemeManager::update` and `PluginManager::update` replaced the entire metadata array with the incoming manifest, erasing `repo`, `customizer`, `settings_schema`, and update-tracking keys.
- **Silent Theme Loss on Update Failure:** Fixed the bug where a failed directory move during a theme update left the theme completely deleted instead of restored from a backup.

### 🛡️ Security
- **SSRF Protection (`SafeHttpService`):** All theme, plugin, and core update downloads now pass through a dedicated service that blocks `file://`, `php://`, and other non-HTTP schemes, rejects any URL that resolves to a private or reserved IP (localhost, `10.x`, `172.16.x`, `192.168.x`, `169.254.x` cloud metadata, IPv6 private ranges), and enforces strict redirect handling.
- **Origin Domain Lock:** Each installed theme or plugin now remembers the domain it was installed from (`origin_domain`). Future updates are only accepted from the same domain (or the same trusted group — GitHub, `codeload.github.com`, `objects.githubusercontent.com` are treated as one origin). This prevents a poisoned manifest from redirecting updates to an attacker's server. Legacy installs without an `origin_domain` are adopted on their next successful update.
- **ZIP Bomb & ZIP Slip Protection (`ZipGuard`):** Theme, plugin, and core update archives are now inspected before extraction. Blocks: absolute paths (`/etc/passwd`), directory traversal (`../../`), Windows drive letters (`C:`), symlinks (`0xA000` external attributes), archives exceeding 500 MB uncompressed, and archives with more than 10,000 files.
- **Update Rollback via `.bak`:** Both `ThemeManager::update` and `PluginManager::update` now move the existing directory to a `.bak` location before replacing files. If the new files fail to move, the `.bak` directory is restored automatically, preventing the theme/plugin from being lost on disk errors.
- **Metadata Preservation:** During theme and plugin updates, sensitive metadata keys (`latest_version`, `download_url`, `is_prerelease`, `origin_domain`) are preserved instead of being overwritten by the incoming manifest. Prevents a poisoned release from hijacking the update source for the next cycle.
- **Slug Hijack Protection:** `ThemeManager::discover` and `PluginManager::discover` no longer allow a newly added folder to overwrite an existing theme/plugin that still has its original folder on disk. Prevents accidental or malicious slug collisions.