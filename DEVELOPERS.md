# RJ CMS — Developer Guide

Conventions and best practices for theme and plugin developers. Read this guide before building anything that touches the RJ CMS core.

## Table of Contents

1. [Language and Locale Helpers](#1-language-and-locale-helpers)
2. [Naming and Structure](#2-naming-and-structure)
3. [Migrations](#3-migrations)
4. [Plugin and Theme Manifests](#4-plugin-and-theme-manifests)
5. [Hooks](#5-hooks)
6. [Contributing](#6-contributing)

---

## 1. Language and Locale Helpers

RJ CMS distinguishes between **all installed languages** and **frontend-visible languages**. Always pick the helper that matches your context.

### 1.1 Which helper to use

| Context | Helper | Reason |
|---|---|---|
| Frontend (theme, plugin, widget, public page) | `rj_frontend_locales()` | Returns only the languages the admin has enabled for the site |
| Admin panel (settings, filters, admin UI) | `rj_available_locales()` | Returns all installed languages, unfiltered |
| AI translation, file scanning, auto-translate | `rj_available_locales()` | Must have access to every installed language |
| Current active language | `app()->getLocale()` | No filtering required |

### 1.2 Correct usage: frontend language switcher

```blade
@foreach (rj_frontend_locales() as $locale)
    <a href="{{ route('rj.widget.locale', ['locale' => $locale]) }}">
        {{ strtoupper($locale) }}
    </a>
@endforeach
```

Hide the switcher when only one language is available:

```blade
@if (count(rj_frontend_locales()) > 1)
    {{-- render switcher --}}
@endif
```

### 1.3 Incorrect usage

> **Do not** use `rj_available_locales()` in the frontend. It exposes languages the admin has disabled.

```blade
{{-- WRONG: shows languages disabled by the admin --}}
@foreach (rj_available_locales() as $locale)
```

### 1.4 Related helpers

| Helper | Description |
|---|---|
| `rj_lang_name($locale)` | Display name. Respects the admin override and falls back to `\Locale::getDisplayLanguage` |
| `rj_lang_flag_url($locale)` | Flag image URL, or `null` if none |
| `rj_is_frontend_locale($locale)` | `true` if the locale is in the frontend list |
| `rj_is_rtl($locale)` / `rj_dir($locale)` | RTL detection and text direction |

---

## 2. Naming and Structure

| Area | Convention |
|---|---|
| Prefix | `rj_` for tables, functions, routes, and constants |
| Models | Namespace `App\Models\`; table name `rj_{name}` |
| Controllers | `Admin/` and `Admin/Settings/` |
| Routes | `admin.{section}.{tab}.{action}` |
| Views | `admin.layouts.app` (admin), `theme::layout` (frontend) |
| UI text | Always wrap in `__()` |
| Icons | SVG only. No emoji in the UI |

---

## 3. Migrations

- **File name:** `YYYY_MM_DD_HHMMSS_verb_table_name.php`
  - Allowed verbs: `create`, `add`, `update`, `drop`
- **Never** rename a migration after it has run in production.
- When consolidating duplicate migrations, update the corresponding rows in the `migrations` table via `tinker`.

---

## 4. Plugin and Theme Manifests

| Type | Manifest | Required fields |
|---|---|---|
| Plugin | `plugin.json` | `provider`, `namespace`, `version` |
| Theme | `theme.json` | `provider`, `namespace`, `version` |

- Both manifests are auto-registered through `ThemeManager::registerProviders()` and `PluginManager`.
- Builder widgets are registered through the manifest.

---

## 5. Hooks

Add items to the admin sidebar:

```php
rj_apply_filters('admin.menu', []);
```

The full list of available hooks is in `App\Helpers\hooks.php`.

---

## 6. Contributing

- **Commit format:** `type(scope): short description` (lowercase verb)
- **One concern per commit.**
- **Pre-release branch:** `main` (current release: RJ Nexus `v1.0.0-rc1`)
