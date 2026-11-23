## [v1.11.1] - 2026-11-23

### 🚀 Added
- **Danish Language & Flag (`da`):** Added Danish (`da`) language support along with its flag to both the core system and the installer.

---

## [v1.11.0] - 2026-11-23

### 🚀 Added
- **Media Picker: PDF Upload:** PDF files can now be uploaded directly from the media picker.
- **Media Picker: Wider File Support:** The media picker now supports many more file types. PDF and archives also have their own filters.
  - **Video:** mp4, webm, mov, avi, mkv, m4v, wmv, flv, 3gp, mpeg, mpg, ogv
  - **Audio:** mp3, wav, ogg, m4a, aac, flac, opus, wma
  - **Image:** jpg, jpeg, png, gif, webp, svg, bmp, ico, avif, tiff, heic
  - **Documents:** doc, docx, xls, xlsx, ppt, pptx, txt, csv, rtf, odt, ods, odp
  - **PDF:** separate filter
  - **Archives:** zip, rar, 7z, tar, gz (separate filter)
- **New Languages:** Added **Traditional Chinese (zh_TW)**, **Malay** and **Tamil** to the core system and the installer, including their flags.
- **New Translation Keys:** Added new translation keys to all existing language files.

### 🧩 RJBuilder
RJBuilder has its own version and changelog. This update brings **13 new widgets** and a widget visibility fix. For details, see the [RJBuilder Changelog](resources/views/rjbuilder/CHANGELOG.md).

**New widgets**
- **Culture, Religion and Holidays:** `PrayerTimesWidget`, `ShabbatTimesWidget`, `ChristianHolidaysWidget`, `ChineseFestivalsWidget`, `HinduFestivalsWidget`
- **Conversion, E-commerce and Calculators:** `CostCalculatorWidget`, `ProductCompareWidget`, `AgeVerificationGateWidget`, `AgePickerGateWidget`
- **Media, Design and Content:** `VideoStoriesCarouselWidget`, `BentoGridShowcaseWidget`, `MarkdownTextWidget`, `PdfReaderWidget`

### 🐛 Fixed
- **Missing Widgets:** `IconBoxWidget`, `ImageBoxWidget` and `AdvancedSearchWidget` were not visible in the widget list because they were not registered. They now appear in RJBuilder.

---

## [v1.10.0] - 2026-11-21

### 🚀 Added
- **New Languages Support:** Added 3 new languages to the system and installer: **Portuguese (Brazil)**, **Greek**, and **Czech**. All missing translation strings have been populated across all existing languages.
- **Language Settings Cache:** Implemented a new caching logic in the Language settings page to improve performance.
- **Amharic Language Support:** Added Amharic (`am`) as a fully supported language, including core and installer translation files, and the Ethiopian flag.

### 🎨 Changed
- **Language Page UI Redesign:** Modernized the Language settings page. Country flags are now displayed as circles instead of squares, and the frontend language list is now shown in a responsive grid layout to prevent the page from becoming too long.
- **RJBuilder Core Update:** Updated RJBuilder to **v1.9.4** (`resources/views/rjbuilder/CHANGELOG.md`), which includes a fix for background image pulling issues.

### 🐛 Fixed
- **AI Center Status Detection:** The AI Center was looking for a non-existent option key (`ai_api_key`), resulting in a false "API Disconnected" state. It now correctly relies on `OpenRouterService::isConfigured()`.
- **AI Center Cache Overflow:** Fetching the OpenRouter models list caused a `MySQL max_allowed_packet` error. The cached data is now stripped down to essential fields (`id`, `name`, `pricing`) to prevent database connection drops.
- **AI Model Selection Ignored:** The SEO, Code Reviewer, Translator, and Builder services now correctly read their specific assigned models (`ai_seo_model`, `ai_code_model`, `ai_translate_model`, `ai_builder_model`) instead of always defaulting to the main model.
- **AI Builder Connection:** `AiBuilderService` was using outdated HTTP logic. It now delegates directly to `OpenRouterService` for consistency.
- **AI Tools Request Signature:** `AiToolController` was passing parameters in the wrong order, causing OpenRouter API 400 errors. This has been corrected.
- **Auto SEO Invalid JSON:** `AiSeoService` now enforces `json_object` formatting, increases `max_tokens` to 2000, and features a more tolerant parser to prevent "invalid JSON" errors.
- **Auto SEO with RJBuilder:** Fixed an issue where generating SEO for RJBuilder pages failed because the textarea was empty. It now extracts text directly from the builder blocks.
- **AI SEO Routing:** The "Auto SEO" button in the Post/Page editor now correctly uses `AiSeoService` and the OpenRouter API key, instead of routing through the free RAG agent.