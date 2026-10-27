# RJ Builder

RJ Builder is a powerful, modern, drag-and-drop page builder integrated directly into RJ CMS. It allows users to visually construct complex layouts, headers, footers, and popups without writing any code.

## Key Features

- **Drag & Drop Interface:** Easily add, move, and arrange elements using a visual canvas.
- **Responsive Design:** Customize visibility, spacing, and typography for Desktop, Tablet, and Mobile views independently.
- **Dynamic Tags:** Bind dynamic data (like Site Title, User Info, Post Data) to any text or image field.
- **Global Widgets:** Save complex sections as global widgets to reuse them across multiple pages.
- **Template Library:** Create, export, and import reusable page sections and full templates.
- **AI Integration:** Built-in AI assistant to generate text, improve copy, and suggest layout sections.
- **Dark Mode UI:** A distraction-free, modern editor interface.

## Getting Started

1. Navigate to the RJBuilder section in your RJ CMS Admin Panel (`/admin/rjbuilder`).
2. Create a new template (Page, Header, Footer, Popup, or Block).
3. Use the "Add Element" panel on the left to insert widgets onto the canvas.
4. Customize properties using the right panel (Content, Style, Motion tabs).
5. Click "Save" to publish your changes.

## Core Structure

- `edit.blade.php` - The main editor interface (HTML structure).
- `partials/` - UI partials including styles, fields (repeater, color, media, etc.), and core JavaScript logic.
- `widgets/builtin/` - The actual Blade views for all the core widgets.
- `layout.blade.php` - The base layout wrapper for the editor.

## Documentation and Updates

This README is intended as a general guide for the RJ Builder architecture. 

**For a full list of available widgets, recent features, improvements, and bug fixes, please refer to the `CHANGELOG.md` file located in the root of the project.**

We continually add new widgets and improve the builder experience. Any new additions will be documented exclusively in the Changelog to keep this README clean and stable.

## License

RJ Builder is a proprietary component of RJ CMS.
