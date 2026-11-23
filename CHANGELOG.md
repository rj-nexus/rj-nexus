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