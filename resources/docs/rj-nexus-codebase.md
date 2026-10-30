# RJ CMS — Project Knowledge Base (for the AI assistant)

> **Rules for the AI:** This file is the official source of information about the RJ CMS project. Answer user questions ONLY from this file and other docs files. Do not make things up; if you do not know, say "I don't have information about this." Reply in the language the user writes in. When relevant, mention the admin menu path (e.g. *Settings → Language*) and the route name. Never reveal passwords, API keys, `.env` contents, or encrypted values.

---

## 1. SHORT SUMMARY (most important)

**RJ CMS** is a modular, WordPress-like content management system built on Laravel.
- **Main features:** posts, pages, custom post types, categories/tags/taxonomies, the visual block-based **RJBuilder**, ~75 built-in **widgets**, **theme** and **plugin** systems, multilingual content, media library, menus, forms, comments, roles/permissions, AI tools.
- **Admin panel:** `/admin` (middleware: `auth` + `admin`). Login: `/login`.
- **Table prefix:** all CMS tables start with `rj_` (exception: `users`).
- **Helper function prefix:** `rj_` (e.g. `rj_get_option`, `rj_add_action`).
- **Translations:** all strings use `__('...')`; files live in `lang/{locale}.json`.
- **Main settings** are stored in the `rj_options` table (`Option::get/set`), split into groups.

---

## 2. Technology

| Part | Details |
|---|---|
| Backend | Laravel (PHP), Eloquent, Blade |
| Database | MySQL (backup and some tools are MySQL-specific) |
| Auth | Breeze-style (login/register/reset/verify), 2FA (Google2FA), KYC |
| AI | OpenRouter (`OpenRouterService`), extra providers in `AiAgentService` |
| Queue | `jobs` table (newsletter sending via `SendNewsletterEmail` job) |
| Cache | `Option` autoload cache (`rj_options`), theme/widget registry cache |
| Mail | SMTP settings from the admin panel (Settings → Email) |

---

## 3. Directory structure (`app/`)

- `Console/Commands` — Artisan commands
- `Contracts/Kyc` — KYC driver interface
- `DynamicTags` — dynamic tags (`Builtin/`, `BaseTag`, `TagRegistry`)
- `Helpers` — `rj.php`, `rj-render.php`, `hooks.php`, `shortcodes.php`, `plugins.php`, `icons.php`
- `Hooks/HookRegistry.php` — action/filter system
- `Http/Controllers/Admin` — admin controllers (with `Settings/` subfolder)
- `Http/Controllers/Frontend` — public site controllers
- `Http/Controllers/Auth` — login/registration
- `Http/Middleware` — `AdminMiddleware`, `CheckMaintenanceMode`, `InjectRtlDirection`, `SetLocale`
- `Jobs`, `Mail`, `Models`, `Observers`
- `Plugins/PluginServiceProvider.php` — base provider for plugins
- `Services` — business logic (Theme/Plugin manager, AI, Backup, Import/Export, etc.)
- `Shortcodes/ShortcodeRegistry.php`
- `Widgets` — `BaseWidget`, `WidgetRegistry`, `WidgetList`, `Builtin/` (built-in widgets)
- `Traits/HasRevisions.php`

Route files: `routes/web.php` (sitemap, robots), `routes/frontend.php`, `routes/admin.php`, `routes/auth.php`, `routes/console.php`.

---

## 4. Database tables

**Users:** `users` (extra columns: `role`, `status`, 2FA columns `two_factor_*`, `kyc_status`, `kyc_verified_at`), `password_reset_tokens`, `sessions`.

**Content:** `rj_posts` (title, slug, content, blocks, edit_mode, theme_template, type, status, is_sticky, allow_comments, view_count, author_id, template_id, settings, meta, published_at), `rj_post_translations` (per-locale title/content/excerpt + SEO fields), `rj_categories` + `rj_category_translations`, `rj_tags` + `rj_tag_translations`, `rj_post_category`, `rj_post_tag`, `rj_terms` + `rj_term_translations`, `rj_post_term`.

**Structure:** `rj_post_types`, `rj_taxonomies`, `rj_custom_fields`, `rj_custom_field_values`.

**Design:** `rj_templates` (header/footer/page/popup, content JSON, conditions, settings), `rj_global_widgets`, `rj_menus`, `rj_menu_items`, `rj_custom_fonts`, `rj_custom_icons`.

**System:** `rj_options`, `rj_media`, `rj_themes`, `rj_theme_customizations`, `rj_plugins`, `rj_widgets` (uploaded widgets), `rj_revisions`, `rj_activity_log`, `rj_notifications`, `rj_notification_settings`.

**Roles:** `rj_roles`, `rj_permissions`, `rj_role_permission`, `rj_user_role`.

**Forms and marketing:** `rj_forms`, `rj_form_fields`, `rj_form_submissions`, `rj_comments`, `rj_newsletter_subscribers`.

**AI and knowledge:** `rj_ai_logs` (tokens/cost), `rj_ai_prompts`, `rj_knowledge` + `rj_knowledge_translations` (admin "About" section).

**KYC:** `rj_kyc_verifications`.

**Laravel standard:** `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs`.

---

## 5. Statuses and values (quick reference)

- **Post status:** `published`, `draft`, `scheduled`, `trash`
- **Post type:** `post`, `page`, and custom post type slugs
- **Edit mode (`edit_mode`):** `classic`, builder, theme mode (`isClassicMode/isBuilderMode/isThemeMode`)
- **Comment status:** `pending`, `approved`, `spam`, `trash`
- **Form submission:** `new`, `read`, `replied`, `spam`, `archived`
- **Plugin/Theme/Widget status:** `active`, `inactive`, `error`
- **Newsletter subscriber:** `active`, `pending`, `unsubscribed`
- **KYC:** `none` (default), `pending`, approved/rejected; driver: `manual` or `api`
- **Template types:** `header`, `footer`, `page`, `popup` (full list: `Template::types()`)

---

## 6. Admin panel sections (menu → route)

| Section | Prefix / route | What it does |
|---|---|---|
| Dashboard | `admin.dashboard` | Stats, recent posts/comments, **Ask AI** (`admin.ask-ai`) |
| Search | `admin.search` | AI-assisted admin search (finds menu items) |
| Posts | `admin.posts.*` | Posts, categories, tags, builder, SEO/AI tools |
| Pages | `admin.pages.*` | Pages (same controller, `type=page`) |
| Media | `admin.media.*` | Upload, edit, picker, bulk delete, **Media Cleanup** |
| Menus | `admin.menus.*` | Menus and menu items, drag-and-drop ordering |
| RJBuilder | `admin.rjbuilder.*` | Header/Footer/Page/Popup templates, conditions, import/export |
| Global Widgets | `admin.global-widgets.*` | Reusable widgets |
| Appearance | `admin.appearance.*` | Widgets management, Theme editor, Colors, Options, Customize |
| Themes | `admin.themes.*` | Theme list, upload, GitHub install, customizer, export, update |
| Plugins | `admin.plugins.*` | Plugin management, upload, GitHub, plugin editor, AI code review |
| Widgets (uploaded) | `admin.widgets.*` | Widgets uploaded as ZIP |
| Post Types / Taxonomies / Terms / Custom Fields | `admin.post-types.*` etc. | Extending the content model |
| Forms | `admin.forms.*` | Form builder, submissions, CSV export |
| Comments | `admin.comments.*` | Moderation (pending/approved/spam/trash), AI analysis |
| Users / Roles / Permissions | `admin.users.*`, `admin.roles.*`, `admin.permissions.*` | User and permission management |
| KYC | `admin.kyc.*` | Review pending verifications, approve/reject |
| Newsletter | `admin.newsletter.*` | Subscribers, bulk send (via queue) |
| Revisions | `admin.revisions.*` | Version history, restore, prune |
| Activity Log | `admin.activity-log.*` | Activity log, filters, clearing |
| Notifications | `admin.notifications.*` | Notifications and notification settings |
| AI Center | `admin.ai.*` | Models, prompts, usage statistics, AI tools |
| Tools | `admin.tools.*` | Import, Export, Health, Backup, Logs, Diagnostics |
| Updates | `admin.updates.*` | GitHub release check |
| Support | `admin.support.*` | Support ticket, FAQ, chat |
| About | `admin.about.*` | Knowledge base (rj_knowledge) |
| Profile | `admin.profile.*` | Profile, password, 2FA |

---

## 7. Settings groups (`Settings → ...`)

Each group is stored in `rj_options` with an `option_group`:
- **General** — site name, tagline, timezone, date/time format, currency, first day of week
- **Writing** — default category, post format, editor, default status
- **Reading** — homepage type, feed settings
- **Discussion** — comment rules, moderation level, avatar source
- **Media** — folder structure, image quality, watermark (uploaded images can be converted to WebP)
- **Permalinks** — URL structure, category/tag base
- **Language** — add/remove languages, frontend languages, translation editor, **AI auto-translate**
- **Colors** — admin color preset
- **SEO** — title separator, Twitter card, schema type, robots.txt content
- **Email** — SMTP, test email
- **Security** — security settings
- **Backup** — schedule, retention, DB/files inclusion
- **Cache** — driver, TTL, clear cache (data/views/routes/config/all)
- **Social** — social login providers (enable, auto-register, default role)
- **Notifications**, **API** (generate/revoke keys), **AI** (OpenRouter key, model, logging), **Advanced** (log level, environment, clear logs)

**In code:** `rj_get_option('site_name', 'default')`, `rj_set_option($name, $value, $group)`, `rj_delete_option`, `rj_flush_options`.

---

## 8. Frontend (public site) routes

- `/` — home page, `/{locale}/` — home page with locale
- `/{locale}/blog` — post archive (`?term=`, `?taxonomy=`, `?s=` search), `/{locale}/blog/{slug}` — single post
- `/{locale}/{slug}` — page (`PageController`). If it is the front page, it 301-redirects to `/`
- `/{locale}/account`, `/account/settings`, `/kyc` — for logged-in users
- `/sitemap.xml`, `/robots.txt`
- `/rj-form/{slug}` — form submission (POST)
- `/rj-widget/login`, `/rj-widget/logout`, `/rj-widget/locale/{locale}`, `/rj-widget/newsletter` — widget APIs (login: 5 attempts rate limit, newsletter: 3 attempts / 5 min)
- `/rj-fonts.css` — custom fonts
- `/theme-assets/{slug}/{path}`, `/plugin-assets/{slug}/{path}` — asset serving
- `/rj-preview/{template}`, `/rj-preview/post/{post}` — previews (auth required)

`{locale}` format: `az`, `en`, `pt_BR` (two letters, optionally `_XX`). The `SetLocale` middleware sets the language from route/session; `InjectRtlDirection` adds `dir="rtl"` for RTL languages.

---

## 9. RJBuilder and the Widget system

**RJBuilder** is a block-based visual builder. Blocks are stored as JSON (`rj_templates.content`, `rj_posts.blocks`). Rendering: `rj_render_blocks()`, `rj_render_block()`, `rj_render_template()`.

**Template conditions (`ThemeResolver`):** `front_page`, `not_front_page`, `single_post`, `single_page`, `archive`, `search`, `url_contains`, `url_exact`. When several templates of the same type exist, the matching one is chosen by `is_default` and update time.

**Popup:** `PopupResolver` returns published popup templates; settings via `Template::popupSettings()`.

**Writing a widget:** extend `App\Widgets\BaseWidget`. Methods: `id()`, `name()`, `icon()`, `category()`, `description()`, `schema()`, `render(array $settings)`. `schema()` fields: `name`, `type`, `label`, `default`, `tab` (`content`/`style`/`advanced`), `options`. Common style and advanced fields (padding/margin, background, shadow, animation, CSS ID/class) come from `BaseWidget` automatically. Container widgets accept `render($settings, $children)`. A widget can use `contexts()` to appear only in contexts such as header/footer.

**Registry:** `WidgetRegistry::discover()` merges built-in (`WidgetList`), plugin and uploaded widgets and caches them for 1 hour. After changes call `WidgetRegistry::reset()`.

**Uploading a widget (ZIP):** needs `manifest.json` (name, slug, class, main_file…); the class must extend `BaseWidget`. Manage under *Widgets* (activate/deactivate/delete).

### Built-in widgets (by category)

- **Headings/text:** Heading, AnimatedHeadline, DualColorHeading, Text, Blockquote, CodeHighlight, Alert
- **Layout:** Container, StructureContainer, Divider, Tabs, Accordion, ToggleCards, FlipBox, StepFlow
- **Media/Video:** Image, ImageBox, ImageComparison, BasicGallery, GalleryAdvanced, Video, VideoHero, VideoMaskText, Lottie, Object3D, Hotspot, SoundCloud, MusicPlayer, Google360
- **Hero/Slider:** HeroSlide, AnimatedHero, PromoBanner, CallToAction
- **Navigation/Header:** Menu, Logo, HeaderLoginButton, HeaderLanguageSwitcher, AdvancedSearch
- **Footer:** FooterAbout, FooterLinks, FooterContact, FooterCopyright, FooterBadges, FooterNewsletter
- **Marketing:** Button, Counter, Countdown, ProgressBar, WheelOfFortune, NewsletterSignup, CookieNotice, LogoGrid
- **Social:** SocialIcons, SocialFeed (RSS/JSON/CSV/manual), MultiChat, GoogleReviews (Places API + 6-hour cache)
- **Pricing:** PriceTable, PriceList
- **Team/testimonials:** Team, Testimonial, IconBox, Portfolio
- **Maps/info:** InteractiveMap, ContactInfo, BusinessHours, CurrencyRates
- **Blog:** Posts (with category/tag/sort filters)
- **Auth:** Login
- **Advanced:** CustomHtml

Widgets can be enabled/disabled, re-categorized or reset under Appearance → Widgets.

**Global Widget:** a widget built in the builder and saved for reuse; rendered anywhere with `rj_resolve_global_widget($id)`. Changing it in one place updates it everywhere.

---

## 10. Dynamic Tags (dynamic content)

Managed by `TagRegistry`. Built-in tags (19): `archive_description`, `archive_title`, `current_date`, `current_user`, `custom_field`, `page_title`, `post_author`, `post_content`, `post_date`, `post_excerpt`, `post_featured_image`, `post_terms`, `post_title`, `shortcode`, `site_logo`, `site_tagline`, `site_title`, `site_url`, `url_param`.
New tag: extend `BaseTag` and implement `id/name/category/resolve`. Output is secured with `escape()`. Resolve with `rj_resolve_dynamic()` / `rj_resolve_dynamics($settings)`.

---

## 11. Shortcodes

Register: `rj_add_shortcode($tag, $callback)`, `rj_remove_shortcode`, `rj_has_shortcode`, `rj_do_shortcode($content)`, `rj_strip_shortcodes`. The callback receives `($attrs, $content)`.
Default shortcodes: `[year]`, `[site_name]`, `[site_url]`, `[current_date]`, `[current_user]`, `[button]`, `[divider]`, `[spacer]`, `[highlight]`, `[icon]`.

---

## 12. Hook system (WordPress-style)

- Actions: `rj_add_action($hook, $cb, $priority=10, $args=1)`, `rj_do_action`, `rj_remove_action`, `rj_has_action`
- Filters: `rj_add_filter`, `rj_apply_filters($hook, $value, ...$args)`, `rj_remove_filter`, `rj_has_filter`, `rj_doing_filter`
- Errors in a hook do not crash the system; they are logged (`Hook action [..] failed`).

---

## 13. Theme system

- **Folder:** each theme lives in its own folder with a `manifest.json` (name, slug, version, supports, customizer schema, parent/child).
- **Installation:** ZIP upload, GitHub registry (Browse), or place in the folder manually and run `discover()`.
- **Activation:** only one active theme at a time (`active_theme` option). A child theme requires its parent; child views override parent views (`theme::` namespace).
- **View rendering:** `ThemeManager::renderView('home' | 'single-post' | 'single-page' | 'archive', [...])`.
- **Customizer:** `Themes → Customizer`; values are stored in `rj_theme_customizations` (theme_slug, section, key).
- **Theme Editor:** Appearance → Editor; file editing, Blade syntax validation, automatic backups (last 20), restore.
- **Export:** a theme can be downloaded as ZIP. **Update:** via the manifest `update_url` or a GitHub release.
- Assets: `/theme-assets/{slug}/{path}` (path traversal is guarded).

---

## 14. Plugin system

- **Manifest:** `plugin.json` / manifest (name, slug, main_file, provider, namespace, routes `admin`/`frontend`, views, migrations, requires `laravel`/`php`, `settings_schema`, menu items, widget classes).
- **Provider:** extends `App\Plugins\PluginServiceProvider`. `register()` loads config/views/migrations; `boot()` registers hooks first (admin menu, builder widgets), then routes.
- **Lifecycle:** discover → activate (runs migrations) → deactivate → delete. On error the status becomes `error` and the message is stored in `error_message`.
- **Helpers:** `rj_plugin_active($slug)`, `rj_plugin($slug)`, `rj_plugin_path`, `rj_plugin_url`, `rj_plugin_setting`.
- **Install options:** ZIP, GitHub Browse, bulk actions. Plugin settings: `Plugins → {plugin} → Settings`.
- **Plugin Editor:** file editing + **AI Code Review**.

---

## 15. Multilingual system (i18n)

- Language list: `rj_available_locales()`, frontend languages: `rj_frontend_locales()`; default language is `config('app.locale')`.
- Content translations live in `*_translations` tables (post, category, tag, term). If the current language has no translation, it falls back to the base language.
- Menu items have a `translations` JSON field.
- Admin UI translation files: `lang/{locale}.json`. Collect new strings: `php artisan rj:extract-translations --locale=en`.
- **AI translation:** Settings → Language → language translations → *AI Translate* (translates empty keys in batches of 50; needs an OpenRouter key).
- Bulk post translation: AI Tools → Bulk Translate.
- URLs: `rj_locale_url('path')` adds the current locale.

---

## 16. SEO

- Per post/page translation: `seo_title`, `seo_description`, `seo_image`, `focus_keyword`, `canonical_url`, Open Graph (`og_*`), Twitter (`twitter_*`), `robots` (default `index,follow`), `schema_type` (default `Article`).
- Automatic fallbacks when empty: SEO title → post title, description → excerpt (160 chars), image → featured image.
- `/sitemap.xml` (posts, pages, categories) and `/robots.txt` (Settings → SEO).
- **AI SEO:** in the post editor — "Generate meta", "Generate title", "Generate description", "Suggest keyword"; `analyzeSeo` runs an SEO analysis; AI Tools → SEO Audit finds missing SEO data.

---

## 17. AI features

| Feature | Where | Service |
|---|---|---|
| Admin Ask AI (this assistant) | Dashboard / global search | `AiAgentService` + `DocSearchService` |
| AI Builder (generate/improve/translate text, section suggestions) | RJBuilder | `AiBuilderService` |
| SEO generator | Post editor | `AiSeoService` |
| Translator | Settings → Language | `AiTranslatorService` |
| Code reviewer | Plugin Editor | `AiCodeReviewerService` |
| Comment analysis (spam/sentiment) | Comments | `AiCommentService` |
| Health analysis | Tools → Health | `AiHealthService` |
| Content generation, bulk translation | AI Center → Tools | `AiToolController` |

**AI Center:** models (OpenRouter list cached 24 hours), prompts (`ai_prompt_seo/translate/builder`), usage statistics (`rj_ai_logs`: tokens, cost, status).
**Setup:** Settings → AI → OpenRouter API key + model; verify with the "Test" button. Without a key, AI tools are disabled.
`AiAgentService` caches identical questions (semantic cache) and adds system context (date, post count).

---

## 18. Roles, permissions, security

- `users.role` column: `admin`, `super-admin`, `user` (admin panel access uses `isAdmin()`).
- `rj_roles` / `rj_permissions` tables: permissions are grouped; `Role::syncPermissions()`. System roles (`is_system`) cannot be deleted.
- **2FA:** Profile → Two-Factor: enable → QR → confirm with code → disable.
- **Login rate limit:** 5 failed attempts (email + IP).
- **Maintenance mode:** `CheckMaintenanceMode` closes the site except for admins and `/login`.
- **Activity Log:** Post, Media, User, Template, Category, Tag, Menu and Role models are tracked automatically; login/logout/failed login are recorded.
- **Revisions:** `HasRevisions` trait, 20 versions kept by default.

---

## 19. Forms

- Builder: Forms → fields (text, email, select, checkbox, etc.), validation, required fields.
- Settings: admin/user email notifications, webhook (`actions`), captcha (`enable_captcha`), success message/redirect.
- Submissions: Forms → Submissions; change status, bulk actions, **CSV export**.
- Frontend: `POST /rj-form/{slug}` (JSON or normal redirect response).

---

## 20. Media

- Upload: Media → Add New (multiple files). Images can be converted to WebP (per Media settings).
- Picker: `admin.media.picker` (for widgets/builder, with a `type` filter).
- **Media Cleanup:** finds and deletes orphan files that exist on disk but not in the database, and cleans database records whose file is missing (`prune-db`). Files referenced in options are not deleted.

---

## 21. Import / Export / Backup / Health / Logs

- **Export** (`Tools → Export`): JSON, WXR (WordPress XML), CSV. Selectable: posts, pages, categories, tags, terms, menus, post types, taxonomies, custom fields, templates, global widgets, site settings.
- **Import** (`Tools → Import`): the file is analyzed (preview), then a strategy is chosen: `skip` (leave existing) or update. Result statistics are shown.
- **Template Library:** export/import templates as JSON (single or pack).
- **Backup:** `Tools → Backup` (DB dump + uploads ZIP, retention) and `Settings → Backup`. Restore works only from local backups.
- **Health:** `Tools → Health` — environment, storage, DB, security, performance, content, logs and integrations checks with a 0-100 score; the **AI analysis** button explains problems (cached 15 min).
- **Logs:** `Tools → Logs` — `storage/logs` files, latest lines, download/clear.
- **Diagnostics:** server, DB, CMS, paths, security info.

---

## 22. KYC

- Frontend: `/{locale}/kyc` — document (front/back) and selfie upload.
- Driver: `manual` (admin reviews by hand) or `api` (external provider + webhook).
- Admin: KYC → pending → Approve (sets `kyc_status`, `kyc_verified_at`) or Reject (with a reason).

---

## 23. Newsletter

- The `NewsletterSignup` and `FooterNewsletter` widgets post to `/rj-widget/newsletter`.
- Admin: Newsletter → subscriber list, search/status filter, delete, **bulk send** (one `SendNewsletterEmail` job per active subscriber). A queue worker must be running: `php artisan queue:work`.

---

## 24. Artisan commands

| Command | Purpose |
|---|---|
| `php artisan rj:context` | Generates an AI context file about project structure/status (`storage/app/ai-context.md`) |
| `php artisan rj:extract-translations --locale=en` | Extracts `__()` strings from code into the JSON translation file |
| `php artisan rj:export-defaults` | Exports default templates, pages, categories and menus to JSON in `database/seeders/data/` |
| `php artisan migrate` | Migrations |
| `php artisan optimize:clear` | Clears all caches |

---

## 25. Frequently asked questions (FAQ)

**How do I create a new page?** `Pages → Add New`. For the builder, use the "Build" button after the page is created (`/admin/posts/{id}/build`).

**How do I change the header/footer?** `RJBuilder` → choose type `Header`/`Footer` → open the template → Build. *Publish* the template and *Set Default*.

**How do I add a site language?** `Settings → Language → Add Language`, then enable it in *Frontend Languages*. Fill translations via `Translations` or *AI Translate*.

**How do I change the logo?** The `image` field of the `Logo` widget in the header template, or the `site_logo` dynamic tag.

**How do I show a menu in the header?** Create a menu under `Menus`, then add the `Menu` widget in the builder and choose that menu.

**How do I install a new theme?** `Themes → Upload` (ZIP) or `Browse` (GitHub). Then `Activate`.

**A plugin does not work (status error).** Open `Plugins → plugin → Show` and read the error message; check `requires` (Laravel/PHP version) and the main file.

**AI does not respond.** Check the OpenRouter key in `Settings → AI` and run "Test connection". Look at `Tools → Logs`. Check error statuses in `AI Center → Usage`.

**My change does not appear on the site.** `Settings → Cache → Clear All` (view/route/config/data). After theme/widget changes the widget registry cache is also cleared.

**Email is not sent.** Fill in SMTP in `Settings → Email` and use `Send test email`. For the newsletter, a queue worker must be running.

**How do I take a backup?** `Tools → Backup → Create`. Automatic: the `Settings → Backup` schedule.

**How do I go back to an older version?** `Revisions` → choose a version → `Restore` (the current state is saved as a backup first).

**How do I make a widget look the same across the whole site?** Create a `Global Widget` and use it in the builder.

**New custom post type?** `Post Types → Create`; for taxonomies use `Taxonomies`, for extra fields `Custom Fields`.

**Where does a non-admin user go after login?** A regular user is redirected to `/{locale}/account`; admins go to `/admin/dashboard`.

---

## 26. Known limitations and notes

- Some tools (Backup dump, DB info, context generator) are MySQL-specific.
- API keys (`Settings → API`) can be generated, but separate API routes do not currently exist in the project.
- There are two role mechanisms: the `users.role` column (admin panel access) and `rj_roles/rj_permissions` (fine-grained permissions).
- Social login settings exist; the provider integration needs separate configuration.
- Tags store only `slug` and `post_count`; names live in `rj_tag_translations`.

---

## 27. Conventions (for developers)

- New table: `rj_` prefix, `timestamps`, a `string` column for status.
- New model: `protected $table = 'rj_...'`, `scopeActive`, a static `uniqueSlug()` for unique slugs.
- Controller: check `expectsJson()` for AJAX, on success `back()->with('success', __('...'))`.
- All user-facing text must be inside `__()`.
- Widget `render()` must always escape HTML with `escape()` and validate URLs with `safeUrl()`.
- New admin page: add it to `routes/admin.php` with an `admin.`-prefixed name.

---

_This file was prepared from an automated analysis. Keep it updated as the project changes (especially routes, the widget list and settings groups)._
