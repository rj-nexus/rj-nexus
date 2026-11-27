# Accessibility

RJ Nexus is a self-hosted CMS. We want people with disabilities to be able to use the admin panel, and we want sites built with RJ Nexus to be usable by everyone.

Our goal is to follow the [Web Content Accessibility Guidelines (WCAG) 2.2](https://www.w3.org/TR/WCAG22/) at level AA. This is a goal, not a certification. RJ Nexus has not had a formal accessibility audit, and parts of it do not meet this level yet (see [Known limitations](#known-limitations)).

## What RJ Nexus already does

- **Page language:** the `lang` attribute follows the active language, so screen readers use the right voice.
- **Right-to-left languages:** the layout switches direction (`dir`) for RTL languages.
- **Keyboard shortcuts in the admin panel:** `Ctrl + K` (or `⌘ + K`) and `/` open search, `Esc` closes menus and dialogs, arrow keys and `Enter` work inside search.
- **Image descriptions:** the media manager has an **Alt text** field for every image.
- **Reduced motion:** newer RJBuilder widgets and the documentation site turn off animations when the visitor has `prefers-reduced-motion` enabled.
- **Light and dark support:** newer widgets and documentation pages adapt to the visitor's color scheme.
- **Responsive layout:** the admin panel and built-in widgets are designed to work on phone, tablet and desktop screens.
- **Labels and roles:** dialogs, tabs, search and toast notifications use ARIA roles and labels where we have checked them.

## Known limitations

We list these openly so you know what to expect:

- **RJBuilder visual editor:** drag-and-drop is hard or impossible with only a keyboard. Content can also be edited in the Classic Editor mode, which is a plain text area.
- **Not every widget is checked.** With 80+ built-in widgets, some may have low color contrast, missing labels or animations that do not respect reduced motion.
- **Accent colors:** the colors you choose in widgets and themes are your choice. Some combinations may not have enough contrast.
- **Animated backgrounds:** decorative canvas effects (for example on the documentation site) are hidden from assistive technology, but they can distract some visitors.
- **Third-party content:** videos, maps, social feeds and other embeds follow the accessibility of their providers.
- **Plugins and themes** from other authors are not covered by this document.
- **Translations:** machine or incomplete translations may read badly with screen readers.

## For site owners

You are responsible for the content you publish. A few habits make a big difference:

- Add **alt text** to every meaningful image in the Media Library. Leave it empty for purely decorative images.
- Use headings in order (one `h1` per page, then `h2`, `h3`). Do not pick a heading level only for its size.
- Write link text that makes sense alone. Avoid "click here".
- Check color contrast of your text and accent colors. Aim for at least 4.5:1 for normal text.
- Provide captions or a transcript for videos and audio.
- Do not rely on color alone to give information.
- Test your pages with the keyboard (`Tab`, `Shift + Tab`, `Enter`, `Esc`) and zoom the page to 200%.

## For contributors

When you add or change a widget, admin page or theme file:

- Everything interactive must work with the keyboard and show a visible focus outline.
- Use real elements (`button`, `a`, `details`, `label`) before adding ARIA roles.
- Every form field needs a label. Icon-only buttons need `aria-label`.
- Respect `prefers-reduced-motion` for animations and auto-playing content.
- Do not remove the focus outline without a visible replacement.
- Keep text readable: enough contrast, and no information hidden only in color or images.
- Make sure the widget still works at 200% zoom and on a 320px wide screen.
- Use `__('...')` for all visible and ARIA text so it can be translated.

See [CONTRIBUTING.md](CONTRIBUTING.md) for the general contribution process.

## Report an accessibility problem

If something in RJ Nexus is hard or impossible to use, please tell us:

1. **GitHub issue (preferred):** open a [bug report](https://github.com/rj-nexus/rj-nexus/issues/new/choose) and add the word **Accessibility** to the title.
2. **Email:** [rjnexus@hotmail.com](mailto:rjnexus@hotmail.com?subject=Accessibility%20feedback)

Please include:

- The page or admin section and, if it is a widget, its name.
- What you were trying to do and what stopped you.
- The browser, operating system and any assistive technology you use (for example NVDA, JAWS, VoiceOver, TalkBack, screen magnifier or voice control).

We will confirm your message within 7 days and tell you what we plan to do. Accessibility fixes are treated as bugs, not as feature requests.

## Standards and tools we use

- [WCAG 2.2](https://www.w3.org/TR/WCAG22/) as the target
- Keyboard testing and browser zoom
- Browser developer tools and automated checkers such as Lighthouse and axe
- Manual checks with a screen reader on key pages

Automated tools find only part of the problems, so real-world reports are very valuable.

_Last updated: November 27, 2026_
