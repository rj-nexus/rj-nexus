<div align="center">

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/banner.svg" alt="RJ Builder" width="100%"/>

<br/>

# RJ Builder

**A modern drag-and-drop page builder with 80+ ready-made widgets.**
Design pages, headers, footers and popups visually, without writing code.

<br/>

![Version](https://img.shields.io/badge/Version-v1.10.1-blue)
![Widgets](https://img.shields.io/badge/Widgets-80%2B-10b981)
![AI](https://img.shields.io/badge/AI-Built--in-8b5cf6)
![Responsive](https://img.shields.io/badge/Responsive-Desktop%20%7C%20Tablet%20%7C%20Mobile-orange)
![License](https://img.shields.io/badge/License-Proprietary-lightgrey)

<br/>

[Website](https://rjnexus.org) &nbsp;&bull;&nbsp; [Live Demo](https://rj-nexus.onrender.com) &nbsp;&bull;&nbsp; [Changelog](CHANGELOG.md) &nbsp;&bull;&nbsp; [RJ Nexus CMS](https://github.com/rj-nexus/rj-nexus)

</div>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## About

RJ Builder is a powerful, modern page builder that runs inside **RJ Nexus CMS** and is developed as an independent component with its own repository, version and changelog. Build complex layouts, headers, footers and popups on a visual canvas, then fine-tune every detail from the property panel.

See it in action on the **[live demo](https://rj-nexus.onrender.com)** or learn more at **[rjnexus.org](https://rjnexus.org)**.

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Key Features

<table>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>Drag &amp; Drop Canvas</b><br/>
      Add, move and arrange elements visually. Nested containers, undo/redo history and a distraction-free dark mode editor.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Truly Responsive</b><br/>
      Control visibility, spacing and typography for Desktop, Tablet and Mobile independently.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>80+ Widgets</b><br/>
      From basic text and images to calculators, timelines, festival calendars and product comparison tables.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>Dynamic Tags</b><br/>
      Bind live data such as Site Title, User Info and Post Data to any text or image field.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="44" height="44" alt=""/><br/>
      <b>Global Widgets &amp; Templates</b><br/>
      Save sections as global widgets, then create, export and import reusable sections and full templates.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/ai.svg" width="44" height="44" alt=""/><br/>
      <b>AI Assistant</b><br/>
      Generate text, improve copy and get layout section suggestions without leaving the editor.
    </td>
  </tr>
</table>

Also included: custom CSS and JS, motion and animation controls, and a Content / Style / Motion property panel for every widget.

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Widgets

RJ Builder ships with **80+ widgets**. A few highlights:

| Group | Widgets |
|---|---|
| **Basic & Content** | Text (with links and Markdown), Logo, Icon Box, Image Box, Timeline, Bento Grid Showcase |
| **Culture & Religion** | Prayer Times, Shabbat Times, Christian Festivals, Hindu Festivals, 中国节日 (Chinese Festivals) |
| **Tools & Interactive** | Cost Calculator, Product Compare, Age Verification, Advanced Search |
| **Media & Documents** | PDF Reader (upload from device or media library) |
| **Site Essentials** | Cookie Consent, Share |

New widgets arrive with almost every release. The complete list is always in the [Changelog](CHANGELOG.md).

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Getting Started

1. Open the **RJBuilder** section in your RJ Nexus admin panel (`/admin/rjbuilder`).
2. Create a new template: **Page, Header, Footer, Popup** or **Block**.
3. Use the **Add Element** panel on the left to place widgets on the canvas.
4. Customize everything in the right panel (**Content**, **Style** and **Motion** tabs).
5. Click **Save** to publish your changes.

Want to try it first? Open the **[live demo](https://rj-nexus.onrender.com)**.

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Core Structure

| Path | Purpose |
|---|---|
| `edit.blade.php` | The main editor interface (HTML structure) |
| `partials/` | UI partials: styles, fields (repeater, color, media and more) and the core JavaScript logic |
| `widgets/builtin/` | Blade views of all built-in widgets |
| `layout.blade.php` | The base layout wrapper for the editor |

## Documentation and Updates

This README is a general guide to the RJ Builder architecture. For the full list of widgets, new features, improvements and bug fixes, see **[CHANGELOG.md](CHANGELOG.md)**.

All new additions are documented only in the Changelog, which keeps this README clean and stable.

## Links

| | |
|:-|:-|
| Website | [rjnexus.org](https://rjnexus.org) |
| Live demo | [rj-nexus.onrender.com](https://rj-nexus.onrender.com) |
| RJ Nexus CMS | [github.com/rj-nexus/rj-nexus](https://github.com/rj-nexus/rj-nexus) |
| Changelog | [CHANGELOG.md](CHANGELOG.md) |

## License

RJ Builder is a proprietary component of RJ NEXUS.

<div align="center">

Created by **Ruhid Javadov** &nbsp;&bull;&nbsp; [rjnexus.org](https://rjnexus.org)

</div>