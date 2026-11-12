<div align="center">

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/banner.svg" alt="RJ Nexus" width="100%"/>

<br/>

![Status](https://img.shields.io/badge/Status-Stable-brightgreen)
![Release](https://img.shields.io/badge/Release-RJ%20CORE%201-10b981)
![Version](https://img.shields.io/badge/Version-v1.9.2-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.2-purple)

<br/>

[Website](https://rjnexus.org) &nbsp;&bull;&nbsp; [Changelog](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) &nbsp;&bull;&nbsp; [RJBuilder Changelog](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) &nbsp;&bull;&nbsp; [Themes & Plugins](https://rj-nexus.github.io/rj-registration/) &nbsp;&bull;&nbsp; [Discussions](https://github.com/orgs/rj-nexus/discussions) &nbsp;&bull;&nbsp; [Source Code](https://github.com/rj-nexus/rj-nexus)

</div>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## About

**RJ CMS** is a modern, self-hosted content management system built on **Laravel 12**. You install it on your own hosting, keep full ownership of your data, and extend it through an isolated plugin and theme system. It ships with a visual page builder (RJBuilder) with 60+ widgets, a dual AI engine, 38 languages with per-language URLs, and a browser-based installer that works on any shared hosting or VPS.

**RJ Nexus** is the organization behind it. It hosts the CMS core and the ecosystem around it.

Official website: **[rjnexus.org](https://rjnexus.org)**

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## What's New in v1.9.2

This update significantly expands the system's localization capabilities and optimizes the installer interface for a larger dataset. The complete list of changes is available in the [Changelog](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md).

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>21 New Languages</b><br/>
      Expanded from 17 to <b>38 languages</b> in the installer and the system: Bengali, Persian, Hausa, Haitian Creole, Hungarian, Kazakh, Korean, Kurdish, Kyrgyz, Maori, Marathi, Polish, Quechua, Romanian, Swahili, Telugu, Tagalog, Ukrainian, Urdu, Uzbek and Vietnamese.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/slugs.svg" width="44" height="44" alt=""/><br/>
      <b>RTL Support</b><br/>
      Kurdish (<code>ku</code>) has been added to the list of right-to-left languages.
    </td>
  </tr>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/installer.svg" width="44" height="44" alt=""/><br/>
      <b>Installer UI Optimization</b><br/>
      The 3D planet animation in the language selection step now calculates planet density, size and stagger speed dynamically, keeping the experience smooth with 38 languages.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/search.svg" width="44" height="44" alt=""/><br/>
      <b>Language Helper</b><br/>
      <code>installer/helpers.php</code> now contains the complete list of 38 languages and their aliases for the search functionality.
    </td>
  </tr>
</table>

Also in this release: obsolete SQL backup files were removed from the database directory to reduce project size.

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
      <b>RJBuilder &mdash; 60+ Widgets</b><br/>
      Elementor-like visual page builder with <b>60+ ready-made widgets</b>, drag-and-drop, responsive controls and dynamic tags. See the <a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">RJBuilder changelog</a>.
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
      38 languages with automatic right-to-left rendering for Arabic, Kurdish and other RTL languages.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Performance First</b><br/>
      WebP optimization, lazy loading and fast asset compilation via Vite.
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

## Supported Languages

38 languages are supported, including per-language URLs (for example `/en/about` and `/az/haqqimizda`).

<table>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/az.svg" width="32" alt="AZ"/><br/>Azerbaijani<br/><code>az</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gb.svg" width="32" alt="EN"/><br/>English<br/><code>en</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/de.svg" width="32" alt="DE"/><br/>German<br/><code>de</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/es.svg" width="32" alt="ES"/><br/>Spanish<br/><code>es</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/fr.svg" width="32" alt="FR"/><br/>French<br/><code>fr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pt.svg" width="32" alt="PT"/><br/>Portuguese<br/><code>pt</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ru.svg" width="32" alt="RU"/><br/>Russian<br/><code>ru</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tr.svg" width="32" alt="TR"/><br/>Turkish<br/><code>tr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="HI"/><br/>Hindi<br/><code>hi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cn.svg" width="32" alt="ZH"/><br/>Chinese<br/><code>zh</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/jp.svg" width="32" alt="JA"/><br/>Japanese<br/><code>ja</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/id.svg" width="32" alt="ID"/><br/>Indonesian<br/><code>id</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/sa.svg" width="32" alt="AR"/><br/>Arabic<br/><code>ar</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/it.svg" width="32" alt="IT"/><br/>Italian<br/><code>it</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nl.svg" width="32" alt="NL"/><br/>Dutch<br/><code>nl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/am.svg" width="32" alt="HY"/><br/>Armenian<br/><code>hy</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ge.svg" width="32" alt="KA"/><br/>Georgian<br/><code>ka</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/bd.svg" width="32" alt="BN"/><br/>Bengali<br/><code>bn</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ir.svg" width="32" alt="FA"/><br/>Persian<br/><code>fa</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ng.svg" width="32" alt="HA"/><br/>Hausa<br/><code>ha</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ht.svg" width="32" alt="HT"/><br/>Haitian Creole<br/><code>ht</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/hu.svg" width="32" alt="HU"/><br/>Hungarian<br/><code>hu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kz.svg" width="32" alt="KK"/><br/>Kazakh<br/><code>kk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kr.svg" width="32" alt="KO"/><br/>Korean<br/><code>ko</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><b>❓</b><br/>Kurdish<br/><code>ku</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kg.svg" width="32" alt="KY"/><br/>Kyrgyz<br/><code>ky</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nz.svg" width="32" alt="MI"/><br/>Maori<br/><code>mi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="MR"/><br/>Marathi<br/><code>mr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pl.svg" width="32" alt="PL"/><br/>Polish<br/><code>pl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pe.svg" width="32" alt="QU"/><br/>Quechua<br/><code>qu</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ro.svg" width="32" alt="RO"/><br/>Romanian<br/><code>ro</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ke.svg" width="32" alt="SW"/><br/>Swahili<br/><code>sw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TE"/><br/>Telugu<br/><code>te</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ph.svg" width="32" alt="TL"/><br/>Tagalog<br/><code>tl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ua.svg" width="32" alt="UK"/><br/>Ukrainian<br/><code>uk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pk.svg" width="32" alt="UR"/><br/>Urdu<br/><code>ur</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/uz.svg" width="32" alt="UZ"/><br/>Uzbek<br/><code>uz</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/vn.svg" width="32" alt="VI"/><br/>Vietnamese<br/><code>vi</code></td>
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
      <b>RJBuilder (60+ Widgets)</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/02.png" alt="RJBuilder" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Posts</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/03.png" alt="Posts" width="100%"/>
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

#### Settings

<table>
  <tr>
    <td width="50%" align="center">
      <b>Settings &rarr; AI</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/07.png" alt="Settings - AI" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Settings &rarr; Theme</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/06.png" alt="Settings - Theme" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>Settings &rarr; Backup</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/backup-page.png" alt="Settings - Backup" width="100%"/>
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
  <tr>
    <td width="100%" colspan="3" align="center"><b>500 Server Error (Debug Mode)</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/500-error-debug.png" alt="500 Debug" width="60%"/></td>
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