## [v1.10.0] - 2026-11-23
 
### 🚀 Added
 
**New widgets (15)**
 
*Culture, Religion and Holidays (5)*
- **`PrayerTimesWidget`:** Islamic prayer times, with a glass-style design.
- **`ShabbatTimesWidget`:** Jewish Shabbat candle-lighting and end times.
- **`ChristianHolidaysWidget`:** Christian holidays and calendar.
- **`ChineseFestivalsWidget`:** Chinese lunar calendar festivals with countdowns, today's lunar date, Yi / Ji (宜 / 忌) auspicious guidance, Shi Chen and the current China time.
- **`HinduFestivalsWidget`:** Hindu festivals covering Sanātana Dharma and Buddha Dharma. The display name is selectable: Sanātana Dharma (सनातन धर्म), Vaidika Dharma (वैदिक धर्म) or Hindu (हिन्दू).
*Conversion, E-commerce and Calculators (4)*
- **`CostCalculatorWidget`:** Interactive price and service calculator. Values are defined in the admin panel; visitors enter their own values on the frontend and get a calculated result.
- **`ProductCompareWidget`:** Build a product or package comparison table by entering products.
- **`AgeVerificationGateWidget`:** Age confirmation modal (18+ confirm button).
- **`AgePickerGateWidget`:** Age check where the visitor selects their age. The minimum age is set in the admin panel (e.g. 16) and visitors below it are blocked. The figure ages or rejuvenates with an animation as the selected age changes.
*Media, Design and Content (4)*
- **`VideoStoriesCarouselWidget`:** Instagram/TikTok-style vertical video stories carousel, with a hexagon (rounded-corner) story option.
- **`BentoGridShowcaseWidget`:** Modern Apple-style Bento card grid.
- **`MarkdownTextWidget`:** Markdown text field and renderer for markdown content.
- **`PdfReaderWidget`:** In-page PDF reader.
*Other (2)*
- **`ShareWidget`:** Share widget.
- **`TimelineWidget`:** Timeline widget.
**PDF**
- **PDF: Choose from Device:** PDF widgets can now upload a PDF from the device and store it on the site.
- **PDF: Media Picker Integration:** The device-upload flow now uses the media picker.
- **PDF: Improved Upload:** The "choose from device" function has been improved.
### 🎨 Changed
- **Prayer Times Design:** Refined the design (glass style).
### 🐛 Fixed
- **Missing Widgets:** `IconBoxWidget`, `ImageBoxWidget` and `AdvancedSearchWidget` were not visible in the widget list because they were not registered. They now appear in the builder.
- **PDF Widget Not Rendering:** Fixed the PDF not being displayed in the PDF widget.
- **Text Widget Links:** The text widget now recognizes and renders links.
- **ChineseFestivalsWidget Error:** Fixed an error and added a dedicated error screen.
- **Cookie Widget:** Fixed the design and the mobile layout.
 