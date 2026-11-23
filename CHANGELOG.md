## [v1.11.1] - 2026-11-23

### 🚀 Added
- **Media Picker: PDF Upload:** PDF files can now be uploaded directly from the media picker.
- **Media Picker: Wider File Support:** The media picker now supports many more file types. PDF and archives also have their own filters.
  - **Video:** mp4, webm, mov, avi, mkv, m4v, wmv, flv, 3gp, mpeg, mpg, ogv
  - **Audio:** mp3, wav, ogg, m4a, aac, flac, opus, wma
  - **Image:** jpg, jpeg, png, gif, webp, svg, bmp, ico, avif, tiff, heic
  - **Documents:** doc, docx, xls, xlsx, ppt, pptx, txt, csv, rtf, odt, ods, odp
  - **PDF:** separate filter
  - **Archives:** zip, rar, 7z, tar, gz (separate filter)
- **New Languages:** Added **Traditional Chinese (zh_TW)**, **Malay**, **Tamil** and **Danish (`da`)** to the core system and the installer, including their flags.
- **New Translation Keys:** Added new translation keys to all existing language files (`lang/*.json`).

### 🧩 RJBuilder
RJBuilder has its own version and changelog. This update brings **13 new widgets**, a PDF picker integration with the media picker, and a widget visibility fix. For full details of every widget and change, see the [RJBuilder Changelog](resources/views/rjbuilder/CHANGELOG.md).

**New widgets (13)**

*Culture, Religion and Holidays (5)*
1. `PrayerTimesWidget` – Islamic prayer times (glass-style design).
2. `ShabbatTimesWidget` – Jewish Shabbat candle-lighting and end times.
3. `ChristianHolidaysWidget` – Christian holidays and calendar.
4. `ChineseFestivalsWidget` – Chinese lunar calendar festivals, countdowns, today's lunar date, Yi / Ji (宜 / 忌) auspicious guidance, Shi Chen and current China time.
5. `HinduFestivalsWidget` – Sanātana Dharma / Hindu festivals (selectable naming: Sanātana Dharma, Vaidika Dharma or Hindu).

*Conversion, E-commerce and Calculators (4)*
6. `CostCalculatorWidget` – Interactive price and service calculator; values are set in the admin panel and the visitor gets a calculated result on the frontend.
7. `ProductCompareWidget` – Product or package comparison table.
8. `AgeVerificationGateWidget` – Age confirmation modal (18+ confirm button).
9. `AgePickerGateWidget` – Age check by selecting an age; visitors below the minimum age set in the admin panel are blocked, and an animation ages or rejuvenates the figure as the selected age changes.

*Media, Design and Content (4)*
10. `VideoStoriesCarouselWidget` – Instagram/TikTok-style vertical video stories carousel (hexagon-shaped story option).
11. `BentoGridShowcaseWidget` – Modern Apple-style Bento card grid.
12. `MarkdownTextWidget` – Markdown-formatted text field and renderer.
13. `PdfReaderWidget` – In-page PDF reader, with "choose from device" upload (stored on the site) via the media picker.

### 🐛 Fixed
- **Missing Widgets:** `IconBoxWidget`, `ImageBoxWidget` and `AdvancedSearchWidget` were not visible in the widget list because they were not registered. They now appear in RJBuilder.