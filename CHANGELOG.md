# Changelog

All notable changes to RJ Nexus will be documented in this file.

## [v1.8.3] - 2026-11-04 (Altair Series)

### Added
- **Theme Customizer Helpers:** Added `rj_theme_mod()`, `rj_theme_mod_section()`, `rj_set_theme_mod()`, `rj_theme_mods_all()`, and `rj_flush_theme_mods()` to `app/Helpers/rj.php`. Themes can now read customizer values declared in `theme.json` and apply them on the frontend. Values are cached under `rj_theme_customizations` and automatically flushed on save.
- **AI Context Improvements:** Enhanced `GenerateAiContext` command with additional project introspection.

### Fixed
- **Customizer Not Reflecting on Frontend:** Theme customizer settings were saved to the database but never read by any theme. Frontend layouts now have a stable helper API to consume per-theme customization values (colors, typography, layout, header, footer, social).
