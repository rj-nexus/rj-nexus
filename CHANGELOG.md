## [v1.9.9] - 2026-11-19

### 🚀 Added
- **504 Gateway Timeout Page:** Added a fully animated, branded 504 error page (`resources/views/errors/504.blade.php`) matching the existing 503 maintenance design — rotating loader, glitch digit, terminal typing effect, sparks, and auto-refresh countdown.
- **Four New Color Presets:** Added four new admin color schemes — **Cyan**, **Pink**, **Red**, and **Copper & Mint** — available in Settings → Colors.

### 🐛 Fixed
- **Menu Translation Locale Leak:** Menu item translation forms (both in the "Add Menu Item" panel and in per-item edit panels) were listing all 40+ available locales instead of only the active frontend locales. They now respect `rj_frontend_locales()`, matching the behavior of the Post/Page editor.