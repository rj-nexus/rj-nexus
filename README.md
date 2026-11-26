<div align="center">

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/banner.svg" alt="RJ Nexus" width="100%"/>

<!-- README-I18N:START -->
**English** | [Português](./README.pt.md) | [中文](./README.zh.md) | [Español](./README.es.md) | [한국어](./README.ko.md) | [日本語](./README.ja.md) | [Русский](./README.ru.md)
<!-- README-I18N:END -->

<br/>

![Status](https://img.shields.io/badge/Status-Stable-brightgreen)
![Release](https://img.shields.io/badge/Release-RJ%20CORE%201-10b981)
![Version](https://img.shields.io/badge/Version-v1.12.0-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.2-purple)
![Languages](https://img.shields.io/badge/Languages-55-orange)
![Cache](https://img.shields.io/badge/Cache-ResponseCache%20%2B%20LSCache-0ea5e9)

<br/>

[Website](https://rjnexus.org) &nbsp;&bull;&nbsp; [Changelog](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) &nbsp;&bull;&nbsp; [RJBuilder Changelog](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) &nbsp;&bull;&nbsp; [Themes & Plugins](https://rj-nexus.github.io/rj-registration/) &nbsp;&bull;&nbsp; [Discussions](https://github.com/orgs/rj-nexus/discussions) &nbsp;&bull;&nbsp; [Source Code](https://github.com/rj-nexus/rj-nexus)

</div>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## About

**RJ CMS** is a modern, self-hosted content management system built on **Laravel 12**. You install it on your own hosting, keep full ownership of your data, and extend it through an isolated plugin and theme system. It ships with a visual page builder (RJBuilder) with 80+ widgets, a built-in **Marketing Post Generator**, a dual AI engine, **55 languages** with per-language URLs, a **two-layer caching system** (Response Cache + LiteSpeed LSCache), and a browser-based installer that works on any shared hosting or VPS.

**RJ Nexus** is the organization behind it. It hosts the CMS core and the ecosystem around it.

Official website: **[rjnexus.org](https://rjnexus.org)**

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## What's New in v1.12.0

This release introduces the **Marketing Post Generator**, a built-in design studio that turns your posts into ready-to-share graphics. It also adds **Quick Edit** for posts and pages, **browser notifications** with 20+ sounds, and four new languages, bringing the total to **55**. The complete list of changes is available in the [Changelog](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md).

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>Marketing Post Generator</b><br/>
      Pick one of your posts and design a social media graphic without leaving the admin panel. Choose from <b>8 layouts</b> and <b>8 quick styles</b>, set your own gradients or image, add your logo and brand, and export in <b>PNG, JPG or WebP</b>. Get every social format (1:1, 4:5, 9:16, 16:9, 4:3) in one <b>ZIP</b>, copy the image to your clipboard, or save your design as a reusable template. Open it with the <b>Create Marketing Post</b> button on the Posts page.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Quick Edit for Posts &amp; Pages</b><br/>
      Change the <b>title</b>, the <b>slug</b> and the <b>status</b> straight from the list. For example, move a published post back to draft in one step, without opening the full editor.
    </td>
  </tr>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>Browser Notifications &amp; 20+ Sounds</b><br/>
      Get alerted the moment a new notification arrives, even when the admin tab is in the background. Choose from <b>20+ notification sounds</b>, and see an indicator on site cards when new notifications come in. The notification settings are now lighter and simpler.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>4 New Languages &mdash; 55 in Total</b><br/>
      <b>Norwegian</b> (<code>no</code>), <b>Finnish</b> (<code>fi</code>), <b>Bulgarian</b> (<code>bg</code>) and <b>Serbian</b> (<code>sr</code>) are now available. Missing translation strings were also added to all languages.
    </td>
  </tr>
</table>

Also in this release: a new **RJ Apps** section in the sidebar, long titles and slugs no longer break the Posts and Pages layout, language flags now show correctly on the Page edit and create screens, the Danish flag was added, and Activity Log entries can be deleted again.

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Installation

RJ CMS installs on any shared hosting or VPS without touching a single line of code.

1. **Upload.** Download the latest ZIP release and extract it to your web server (for example `public_html`).
2. **Run the installer.** Open `https://yourdomain.com/install.php` in your browser.
3. **Follow the steps.** Choose a language, verify server requirements, enter database credentials and create your admin account.
4. **Demo data.** The installer imports default pages, menus and builder templates, so your site does not start empty.
5. **Secure the site.** Delete `install.php` and the `installer/` folder when the wizard asks you to.

### Video Guide

<a href="https://www.youtube.com/watch?v=BU4UXY2D3FU">
  <img src="https://img.youtube.com/vi/BU4UXY2D3FU/0.jpg" alt="RJ CMS Installation Guide" width="480"/>
</a>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Key Features

<table>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder &mdash; 80+ Widgets</b><br/>
      Elementor-like visual page builder with <b>80+ ready-made widgets</b>, drag-and-drop, responsive controls and dynamic tags. See the <a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">RJBuilder changelog</a>.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/ai.svg" width="44" height="44" alt=""/><br/>
      <b>AI Integration</b><br/>
      Content generation, bulk translation that preserves HTML, and automatic SEO audits.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/security.svg" width="44" height="44" alt=""/><br/>
      <b>Advanced Security</b><br/>
      Two-factor authentication, email verification and rate limiting.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/roles.svg" width="44" height="44" alt=""/><br/>
      <b>Roles &amp; Permissions</b><br/>
      Fine-grained role-based access control for every admin section.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>Activity Logging</b><br/>
      Track what happens in your admin panel, with revisions for posts and pages.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>Multilingual &amp; RTL</b><br/>
      <b>55 languages</b> with per-language URLs and automatic right-to-left rendering for Arabic, Kurdish and other RTL languages.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Performance First</b><br/>
      Two-layer page caching (Response Cache + LiteSpeed LSCache), WebP optimization, lazy loading and fast asset compilation via Vite.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>Modular Architecture</b><br/>
      Plugins and themes are fully isolated, with their own routes, views and migrations.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="44" height="44" alt=""/><br/>
      <b>Themes &amp; Plugins</b><br/>
      Browse the full catalog in the <a href="https://github.com/rj-nexus/rj-registration">themes and plugins list</a>.
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<a id="caching"></a>

## Live Demo

You can try RJ Nexus in the demo below.

> **Note:** The demo site may not run the latest version at the moment. It is provided only to give you an idea of how RJ Nexus looks and works.

| | | |
|:-:|---|---|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/globe.svg" width="20" height="20" alt="" /> | **Demo site** | [rj-nexus.onrender.com](https://rj-nexus.onrender.com) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/layers.svg" width="20" height="20" alt="" /> | **Admin panel** | Add `/admin` to the end of the demo URL: [rj-nexus.onrender.com/admin](https://rj-nexus.onrender.com/admin) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file-text.svg" width="20" height="20" alt="" /> | **Email** | `admin@admin.com` |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file.svg" width="20" height="20" alt="" /> | **Password** | `admin123` |

---

## Caching

RJ CMS ships with a built-in, two-layer page caching system, so your site stays fast under real traffic, even on modest shared hosting.

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Response Cache</b><br/>
      Powered by <a href="https://github.com/spatie/laravel-responsecache"><code>laravel-responsecache</code></a>. Complete application responses are stored and served directly on repeat requests, which skips most of the framework work. Works on any hosting, with no special server required.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>LiteSpeed Cache (LSCache)</b><br/>
      Powered by <a href="https://github.com/litespeedtech/lscache-laravel"><code>litespeed/lscache-laravel</code></a>. On LiteSpeed and OpenLiteSpeed hosting, pages are cached at the web server level and delivered before PHP is even started.
    </td>
  </tr>
</table>

| | Response Cache | LiteSpeed LSCache |
|---|---|---|
| Package | `laravel-responsecache` | `litespeed/lscache-laravel` |
| Cache level | Application (Laravel) | Web server (LiteSpeed) |
| Hosting requirement | Any PHP hosting | LiteSpeed / OpenLiteSpeed |
| Best for | Universal baseline speed-up | Maximum speed on LiteSpeed hosts |

Cache behavior is managed from **Admin &rarr; Settings &rarr; Cache**.

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Supported Languages

55 languages are supported, including per-language URLs (for example `/en/about` and `/az/haqqimizda`).

<table>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/et.svg" width="32" alt="AM"/><br/>Amharic<br/><code>am</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/sa.svg" width="32" alt="AR"/><br/>Arabic<br/><code>ar</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/am.svg" width="32" alt="HY"/><br/>Armenian<br/><code>hy</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/az.svg" width="32" alt="AZ"/><br/>Azerbaijani<br/><code>az</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/bd.svg" width="32" alt="BN"/><br/>Bengali<br/><code>bn</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/bg.svg" width="32" alt="BG"/><br/>Bulgarian <b>NEW</b><br/><code>bg</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/cn.svg" width="32" alt="ZH"/><br/>Chinese (Simplified)<br/><code>zh</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tw.svg" width="32" alt="ZH-TW"/><br/>Chinese (Traditional)<br/><code>zh_TW</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cz.svg" width="32" alt="CS"/><br/>Czech<br/><code>cs</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/dk.svg" width="32" alt="DA"/><br/>Danish<br/><code>da</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nl.svg" width="32" alt="NL"/><br/>Dutch<br/><code>nl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gb.svg" width="32" alt="EN"/><br/>English<br/><code>en</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ee.svg" width="32" alt="ET"/><br/>Estonian<br/><code>et</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/fi.svg" width="32" alt="FI"/><br/>Finnish <b>NEW</b><br/><code>fi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/fr.svg" width="32" alt="FR"/><br/>French<br/><code>fr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ge.svg" width="32" alt="KA"/><br/>Georgian<br/><code>ka</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/de.svg" width="32" alt="DE"/><br/>German<br/><code>de</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gr.svg" width="32" alt="EL"/><br/>Greek<br/><code>el</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ht.svg" width="32" alt="HT"/><br/>Haitian Creole<br/><code>ht</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ng.svg" width="32" alt="HA"/><br/>Hausa<br/><code>ha</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/il.svg" width="32" alt="HE"/><br/>Hebrew<br/><code>he</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="HI"/><br/>Hindi<br/><code>hi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/hu.svg" width="32" alt="HU"/><br/>Hungarian<br/><code>hu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/id.svg" width="32" alt="ID"/><br/>Indonesian<br/><code>id</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/it.svg" width="32" alt="IT"/><br/>Italian<br/><code>it</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/jp.svg" width="32" alt="JA"/><br/>Japanese<br/><code>ja</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kz.svg" width="32" alt="KK"/><br/>Kazakh<br/><code>kk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/rw.svg" width="32" alt="RW"/><br/>Kinyarwanda<br/><code>rw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kr.svg" width="32" alt="KO"/><br/>Korean<br/><code>ko</code></td>
    <td align="center" width="16%"><b>KU</b><br/>Kurdish<br/><code>ku</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/kg.svg" width="32" alt="KY"/><br/>Kyrgyz<br/><code>ky</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/my.svg" width="32" alt="MS"/><br/>Malay<br/><code>ms</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nz.svg" width="32" alt="MI"/><br/>Maori<br/><code>mi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="MR"/><br/>Marathi<br/><code>mr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/no.svg" width="32" alt="NO"/><br/>Norwegian <b>NEW</b><br/><code>no</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ir.svg" width="32" alt="FA"/><br/>Persian<br/><code>fa</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pl.svg" width="32" alt="PL"/><br/>Polish<br/><code>pl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pt.svg" width="32" alt="PT"/><br/>Portuguese<br/><code>pt</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/br.svg" width="32" alt="PT-BR"/><br/>Portuguese (Brazil)<br/><code>pt_BR</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pe.svg" width="32" alt="QU"/><br/>Quechua<br/><code>qu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ro.svg" width="32" alt="RO"/><br/>Romanian<br/><code>ro</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ru.svg" width="32" alt="RU"/><br/>Russian<br/><code>ru</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/rs.svg" width="32" alt="SR"/><br/>Serbian <b>NEW</b><br/><code>sr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/es.svg" width="32" alt="ES"/><br/>Spanish<br/><code>es</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ke.svg" width="32" alt="SW"/><br/>Swahili<br/><code>sw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/se.svg" width="32" alt="SV"/><br/>Swedish<br/><code>sv</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ph.svg" width="32" alt="TL"/><br/>Tagalog<br/><code>tl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TA"/><br/>Tamil<br/><code>ta</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TE"/><br/>Telugu<br/><code>te</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/th.svg" width="32" alt="TH"/><br/>Thai<br/><code>th</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tr.svg" width="32" alt="TR"/><br/>Turkish<br/><code>tr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ua.svg" width="32" alt="UK"/><br/>Ukrainian<br/><code>uk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pk.svg" width="32" alt="UR"/><br/>Urdu<br/><code>ur</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/uz.svg" width="32" alt="UZ"/><br/>Uzbek<br/><code>uz</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/vn.svg" width="32" alt="VI"/><br/>Vietnamese<br/><code>vi</code></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Screenshots

### Admin Panel

<p align="center">
  <b>AI Global Search (Ctrl+K)</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-search.png" alt="AI Global Search" width="80%"/>
</p>

<table>
  <tr>
    <td width="50%" align="center">
      <b>Dashboard</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/dashboard.png" alt="Dashboard" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>AI Center</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-center.png" alt="AI Center" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>RJBuilder (80+ Widgets)</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/02.png" alt="RJBuilder" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Posts</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/yeni_post_sehifesi.png" alt="Posts" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>Media Library</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/media-library-page.png" alt="Media Library" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>KYC Management</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/kyc-management-page.png" alt="KYC Management" width="100%"/>
    </td>
  </tr>
</table>

#### Tools

<table>
  <tr>
    <td width="50%" align="center">
      <b>Marketing Post Generator</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/marketin-sehifesi.png" alt="Marketing Post Generator" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Tools &rarr; Backup</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/backup_page_new.png" alt="Tools - Backup" width="100%"/>
    </td>
  </tr>
</table>

#### Settings

<table>
  <tr>
    <td width="50%" align="center">
      <b>Settings &rarr; AI</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/07.png" alt="Settings - AI" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Settings &rarr; Colors</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/new-color-page.png" alt="Settings - Colors" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>Notification Settings</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/bildiris_ayarlari_sehifesi.png" alt="Notification Settings" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Settings &rarr; Updates</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/update-page.png" alt="Settings - Updates" width="100%"/>
    </td>
  </tr>
</table>

### Frontend

<table>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front1.png" alt="Frontend 1" width="100%"/></td>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front2.png" alt="Frontend 2" width="100%"/></td>
  </tr>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front3.png" alt="Frontend 3" width="100%"/></td>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front4.png" alt="Frontend 4" width="100%"/></td>
  </tr>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front5.png" alt="Frontend 5" width="100%"/></td>
    <td width="50%" align="center">
      <b>User Account</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/accout-page.png" alt="User Account" width="100%"/>
    </td>
  </tr>
</table>

### Authentication Pages

<p align="center">
  <b>Login & Register</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/01.gif" alt="Login & Register" width="100%"/>
</p>

<p align="center">
  <b>Reset Password</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/02.gif" alt="Reset Password" width="100%"/>
</p>

<p align="center">
  <b>Email Verification</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/03.gif" alt="Email Verification" width="100%"/>
</p>

<p align="center">
  <b>Forgot Password</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/04.gif" alt="Forgot Password" width="100%"/>
</p>

<p align="center">
  <b>Confirm Password</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/05.gif" alt="Confirm Password" width="100%"/>
</p>

### Error Pages

<table>
  <tr>
    <td width="33%" align="center"><b>400 Bad Request</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/400-error.png" alt="400" width="100%"/></td>
    <td width="33%" align="center"><b>401 Authentication Required</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/12.png" alt="401" width="100%"/></td>
    <td width="33%" align="center"><b>403 Forbidden</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/09.png" alt="403" width="100%"/></td>
  </tr>
  <tr>
    <td width="33%" align="center"><b>404 Not Found</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/10.png" alt="404" width="100%"/></td>
    <td width="33%" align="center"><b>405 Invalid Request Method</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/11.png" alt="405" width="100%"/></td>
    <td width="33%" align="center"><b>429 Rate Limit Exceeded</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/13.png" alt="429" width="100%"/></td>
  </tr>
</table>

<table>
  <tr>
    <td width="50%" align="center"><b>500 Server Error (Debug Mode)</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/500-error-debug.png" alt="500 Debug" width="100%"/></td>
    <td width="50%" align="center"><b>504 Gateway Timeout</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/504-error.png" alt="504" width="100%"/></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 12, PHP 8.2 |
| Database | MySQL |
| Frontend | Blade, Tailwind CSS v3, Alpine.js |
| Build tool | Vite |
| Caching | `laravel-responsecache`, `litespeed/lscache-laravel` |
| AI engine | OpenRouter and Free AI Proxy |

## Resources

| | Resource | Description |
|:-:|----------|-------------|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [rjnexus.org](https://rjnexus.org) | Official website |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/changelog.svg" width="28" alt=""/> | [Changelog](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) | Full release history of RJ CMS |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="28" alt=""/> | [RJBuilder Changelog](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) | Release history of the page builder |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="28" alt=""/> | [Themes & Plugins](https://github.com/rj-nexus/rj-registration) | Catalog of available themes and plugins |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/video.svg" width="28" alt=""/> | [Installation Video](https://www.youtube.com/watch?v=BU4UXY2D3FU) | Step-by-step guide on YouTube |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="28" alt=""/> | [Source Code](https://github.com/rj-nexus/rj-nexus) | RJ CMS core repository |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [Discussions](https://github.com/orgs/rj-nexus/discussions) | Questions, suggestions and complaints |

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Community & Support

Have a question, a suggestion or a complaint? Join the conversation in [GitHub Discussions](https://github.com/orgs/rj-nexus/discussions).

## Contributing

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/contribute.svg" width="40" height="40" align="left" alt=""/>

Bug reports, feature ideas and pull requests are welcome. Open an issue before starting work on a large change, fork the repository, create a feature branch, follow PSR-12 and open a pull request with a clear description.

<br clear="left"/>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<div align="center">

Created by **Ruhid Javadov** &nbsp;&bull;&nbsp; Released under the MIT License &nbsp;&bull;&nbsp; [rjnexus.org](https://rjnexus.org)

</div>