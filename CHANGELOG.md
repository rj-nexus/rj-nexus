## [v1.9.8] - 2026-11-19

### 🚀 Added
- **New Color Presets:** Added four new color schemes (Fuchsia, Lime, Sunset, and Noir), available in Settings → Colors.

### 🐛 Fixed
- **Core Update Extraction Failure:** Fixed the critical error `Update aborted: the release package must have files at the ZIP root (no wrapper folder) and include public/build/manifest.json` that occurred even when the archive was correctly structured. The updater now scans every ZIP entry instead of relying on `ZipArchive::getFromName()` with an exact path, accepts both `/` and `\` as path separators (Windows-created archives), handles archives with a wrapper folder automatically, and writes each file individually via `File::put()` instead of `ZipArchive::extractTo()`, bypassing PHP archive extraction permission issues entirely.
- **Missing Manifest No Longer Aborts Update:** If `public/build/manifest.json` is absent or unreadable, the updater logs a warning and continues instead of blocking the entire installation.
- **Rollback Message Accuracy:** The failure message now clearly distinguishes between a successful rollback and a failed database restore, so admins know exactly which state the site is in.