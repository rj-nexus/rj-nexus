## [v1.10.1] - 2026-11-27

### 🎨 Changed

- **RJBuilder Top Toolbar (Header):** Restructured the top toolbar using CSS Grid to prevent overlapping elements. It is now fully responsive; titles and labels dynamically shrink or hide on smaller screens while keeping the action buttons accessible.
- **Text Widget (Rich Editor):** Replaced the standard basic textarea with a powerful **Quill.js Visual Editor**. Users can now format text, add headings, lists, links, and images directly from the sidebar.
- **Two-Way Binding:** Implemented two-way data binding for the Text Widget. Changes made via AI generation, Undo/Redo, or external actions now instantly reflect inside the Quill editor.
- **Backward Compatibility:** Fully preserved older text widget content. Legacy plain text and basic HTML will automatically load into the new visual editor without data loss.

### 🐛 Fixed

- **Duplicate Labels:** Fixed an issue where the "Content" label appeared twice in the Text Widget's sidebar panel.
- **Quill.js Infinite Loop:** Added a safety flag to prevent infinite update loops between the editor and the Alpine.js state.