# Changelog

All notable changes to RJ Nexus will be documented in this file.

## [v1.9.7] - 2026-11-18

### 🚀 Added
- **One-Click Backup Restore:** Added a full restore functionality to the backup management page. Admins can now restore their site (Database, Files, or Full Backup) with a single click.
- **Backup Process Monitoring:** Added real-time progress tracking on the backup page, allowing admins to monitor the backup creation process live.
- **New Localizations:** Added 5 new languages (Thai `th`, Hebrew `he`, Swedish `sv`, Estonian `et`, and Kinyarwanda `rw`) to the installer and core system.

### ⚡ Changed
- **Installer Freedom (`exec` disabled):** The installation process no longer requires the `exec()` function to be enabled on the server. The system can now be installed on highly restrictive shared hostings, fully embracing the "self-hosted" philosophy.
- **Translation Completion:** Completed missing translation strings across dozens of languages in the core application.
- **Backup Engine:** Removed the dependency on `proc_open` for backup operations, making the system much more compatible with various server configurations.

### 🐛 Fixed
- **Critical: `mysqldump` Execution Error:** Fixed the critical error `mysqldump execution error: Undefined constant Illuminate\Support\Facades\Process::OUT` that occurred during database backups.
- **Critical: Empty Installer Localization (`bn`):** Fixed a critical bug in the installer where selecting Bengali (`bn`) caused an installation error due to an empty translation file.
- **Installer `exec` Error:** Fixed the execution error thrown during installation when the `exec` function was disabled on the hosting provider.