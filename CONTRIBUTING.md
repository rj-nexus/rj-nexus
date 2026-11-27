# Contributing to RJ Nexus

Thanks for your interest in RJ Nexus. It is a self-hosted CMS released under the [MIT License](LICENSE), so anyone can use it, change it and contribute to it. You can run it locally or on your own hosting.

By taking part, you agree to follow our [Code of Conduct](CODE_OF_CONDUCT.md). If something goes wrong, see [how to report](https://rj-nexus.github.io/reporting.html) and the [FAQ](https://rj-nexus.github.io/faq.html).

## Ways to help

- Report a bug.
- Suggest an improvement.
- Fix a bug or add a feature with a pull request.
- Add or improve a translation.
- Build a new RJBuilder widget.
- Improve the [documentation](https://rj-nexus.github.io/documents/).
- Support the project through [Patreon](https://www.patreon.com/c/mr_ruhid/membership) and get extra features.

## Before you start

- Search [existing issues](https://github.com/rj-nexus/rj-nexus/issues) first, someone may have reported it already.
- For questions and ideas, use [Discussions](https://github.com/orgs/rj-nexus/discussions).
- **Security vulnerabilities:** do not open a public issue. Follow the [security policy](https://github.com/rj-nexus/rj-nexus/security/policy).

## Reporting a bug

Open an [issue](https://github.com/rj-nexus/rj-nexus/issues) and include:

- RJ Nexus version, PHP version and where you run it (local or hosting).
- Steps to reproduce the problem.
- What you expected and what happened instead.
- Screenshots or error messages from `storage/logs/laravel.log` or the browser console.

## Suggesting a feature

Open an issue or a discussion and explain the problem you want to solve, not only the solution. Small and general improvements that help most users are the easiest to accept.

## Development setup

Requirements: PHP 8.2+, Composer, Node.js and a database (MySQL or MariaDB).

```bash
git clone https://github.com/<your-username>/rj-nexus.git
cd rj-nexus
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm install
npm run dev
```

After changing views or config, run `php artisan optimize:clear`.

## Pull requests

1. Fork the repository and create a branch from `main`, for example `feat/share-widget` or `fix/media-picker-pdf`.
2. Keep each pull request small and focused on one change.
3. Describe what changed and why. Add screenshots for visual changes.
4. Test your change locally, including on a mobile screen size if it touches the UI.
5. Open the pull request against `main`.

### Commit messages

We use short [Conventional Commits](https://www.conventionalcommits.org/):

```
feat(widgets): add Timeline widget
fix(admin): show flags for all locale tabs
docs: update installation guide
```

Common types: `feat`, `fix`, `docs`, `refactor`, `chore`.

### Code style

- PHP follows PSR-12. Run `./vendor/bin/pint` before committing.
- Use `__('Text')` for every visible string.
- Never store secrets or API keys in the code.

## Translations

RJ Nexus supports 50+ languages. When you add a new translation key, add it to **all** language files in `lang/`, using the English text as the default. To add a new language, include its flag in `public/images/flags/`.

## Adding a widget

1. Create `YourWidget.php` in `app/Widgets/Builtin/` (extend `BaseWidget`) and a Blade view in `resources/views/rjbuilder/widgets/builtin/`.
2. **Register it in `app/Widgets/WidgetList.php`**. A widget that is not registered will not appear in RJBuilder.
3. Escape all user input, make the widget responsive, and respect `prefers-reduced-motion` for animations.

## Support the project

RJ Nexus is free and open source under the MIT License, and it is maintained in spare time. The whole CMS stays free for everyone.

People who support the project get **extra features and perks** and a place in our supporter list. The tiers are named after stars, from the nearest one to the biggest object we know:

| Tier | Star | Who it is for |
|:-:|---|---|
| 1 | **Proxima** (Proxima Centauri) | People who find and report a bug. Entry level, open to everyone. |
| 2 | **Sol** | [Patreon](https://www.patreon.com/c/mr_ruhid/membership) supporters: the standard, balanced package. |
| 3 | **Sirius** | [Patreon](https://www.patreon.com/c/mr_ruhid/membership) supporters: for bright and active users. |
| 4 | **Betelgeuse** | [Patreon](https://www.patreon.com/c/mr_ruhid/membership) supporters: a powerful package with more volume and options. |
| 5 | **Vela** | [Patreon](https://www.patreon.com/c/mr_ruhid/membership) supporters: the Pro / Elite level. |
| 6 | **Sagittarius A\*** | [Patreon](https://www.patreon.com/c/mr_ruhid/membership) supporters: the VIP level. |
| 7 | **TON 618** | Project sponsors. |

Details and current perks of each Patreon tier are on the [membership page](https://www.patreon.com/c/mr_ruhid/membership). Everyone listed is thanked in [SUPPORTERS.md](SUPPORTERS.md).

### Where to get help

| Need | Where to go |
|---|---|
| Bug or question | Open an [issue](https://github.com/rj-nexus/rj-nexus/issues). Supporters are helped with priority. |
| Found a bug | Report it, and you can join **Proxima** in the supporter list. |
| Features made for supporters | Join a [Patreon](https://www.patreon.com/c/mr_ruhid/membership) tier. |
| Bigger changes, custom requests, sponsorship | Contact the maintainer directly (below). |

**Direct contact**

- WhatsApp: [+994 50 663 60 31](https://wa.me/994506636031)
- Telegram: [@veb_developher_az](https://t.me/veb_developher_az)
- Email: [rjnexus@hotmail.com](mailto:rjnexus@hotmail.com)

## License

By contributing, you agree that your contributions are licensed under the [MIT License](LICENSE).
