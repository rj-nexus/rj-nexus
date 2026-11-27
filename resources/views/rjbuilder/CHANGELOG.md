## [v1.10.2] - 2026-11-27

### 🎨 Changed

- **RJBuilder Top Toolbar (Header):** The toolbar now stays fixed at the top while scrolling down the sidebar, keeping tools always accessible without scrolling back up.

- **Text Widget — Live Preview:** Real-time updates were not reflecting in the canvas. Fixed the render pipeline so changes made in the sidebar appear instantly in the live preview as you type or adjust settings.

- **Live Editing (Render Function):** Improved the overall render function for live editing — changes made on the side panel are now immediately visible on the canvas, without needing a manual refresh or re-render trigger.

### 🐛 Fixed

- **Text Widget — Changes Not Appearing:** Fixed a bug where editing text in the sidebar did not update the canvas in real time. The widget now reflects changes as they happen.