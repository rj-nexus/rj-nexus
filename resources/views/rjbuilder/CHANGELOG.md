## [v1.10.0] - 2026-11-23

> RJ Builder is a standalone page builder. It runs inside RJ Nexus CMS and is also developed in its own repository, so it keeps its own changelog and versioning, separate from the CMS core.

### 🚀 Added

**New widgets**
- **Prayer Times:** A dedicated widget for daily prayer times.
- **Shabbat Times:** A dedicated widget for Jewish communities, showing Shabbat times.
- **Christian Festivals:** A widget for Christian holidays and festivals.
- **Hindu Festivals:** A widget covering Sanātana Dharma and Buddha Dharma festivals. The label can be switched between **Sanātana Dharma (सनातन धर्म)**, **Vaidika Dharma (वैदिक धर्म)** and **Hindu (हिन्दू)**.
- **中国节日 (Chinese Festivals):** Countdown to upcoming Chinese festivals, today's lunar date, 宜 / 忌 (auspicious / avoid activities of the day), and the current Shi Chen (Chinese hour). Calculated offline, no external API.
- **Timeline:** A widget for building timelines.
- **Product Compare:** Add products and generate a comparison table.
- **Cost Calculator:** Define fields and values in the admin panel. Visitors enter their own values on the frontend and get the calculated result instantly.
- **Age Verification (age selector):** A second age verification widget. Visitors select their age instead of typing it. The admin sets a minimum age (for example 16), and anyone below it is blocked. As the selected age changes, the animation ages or rejuvenates to match.
- **Bento Grid Showcase:** A bento-style grid widget for showcasing content.
- **PDF Reader:** A built-in PDF viewer for displaying PDF files on the page.

**New plugins**
- **Share Widget:** A new plugin for sharing pages.
- **Hexagon Story:** A hexagon-shaped story plugin with rounded corners and an original design.

**Text widget**
- **Links in text:** The Text widget now understands links. Use Markdown (`[text](url)`), HTML (`<a href>`) or plain URLs. Includes link color and open-in-new-tab settings, with unsafe tags and URL schemes sanitized.
- **Markdown text field:** A dedicated Markdown text field for writing Markdown content.

**PDF widget**
- **Select from device:** Upload a PDF from your device and store it on your own site, instead of relying only on an external URL.
- **Media picker integration:** The PDF widget now works with the built-in media picker.

### 🎨 Changed

- **Prayer Times:** Redesigned with a glass-style look.
- **PDF "Select from device":** Improved the upload and selection flow.

### 🐛 Fixed

- **Widgets missing from the list:** `IconBoxWidget`, `ImageBoxWidget` and `AdvancedSearchWidget` were not visible because they were never registered in the widget list. All three now appear.
- **PDF widget:** Fixed the issue where the PDF was not displayed.
- **Chinese Festivals:** Fixed a wrong calendar library namespace that caused a false "Calendar library is not installed" error, and added a dedicated error screen. The widget cache is now locale-aware, so festival names are shown in the visitor's language.
- **Cookie widget:** Fixed the design and the mobile layout.