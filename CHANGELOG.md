# Changelog

All notable changes to RJ Nexus will be documented in this file.

## [v1.9.1] - 2026-11-12

This update significantly expands the system's localization capabilities and optimizes the installer interface for a larger dataset.

### 🌍 Added
- **21 New Languages:** Expanded the installer and system support from 17 to 38 languages. Added Bengali (`bn`), Persian (`fa`), Hausa (`ha`), Haitian Creole (`ht`), Hungarian (`hu`), Kazakh (`kk`), Korean (`ko`), Kurdish (`ku`), Kyrgyz (`ky`), Maori (`mi`), Marathi (`mr`), Polish (`pl`), Quechua (`qu`), Romanian (`ro`), Swahili (`sw`), Telugu (`te`), Tagalog (`tl`), Ukrainian (`uk`), Urdu (`ur`), Uzbek (`uz`), and Vietnamese (`vi`).
- **RTL Support:** Added Kurdish (`ku`) to the RTL (Right-to-Left) languages list.

### ⚡ Improved
- **Installer UI Optimization:** Updated the 3D planet animation logic in the language selection step. The system now dynamically calculates planet density, size, and stagger speed based on the number of available languages, ensuring a smooth experience with 38 languages.
- **Language Helper:** Updated `installer/helpers.php` to reflect the complete list of 38 languages and their aliases for the search functionality.

### 🧹 Cleanup
- Deleted obsolete SQL backup files from the database directory to reduce project size.