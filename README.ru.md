<div align="center">

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/banner.svg" alt="RJ Nexus" width="100%"/>

<!-- README-I18N:START -->
[English](./README.md) | [Português](./README.pt.md) | [中文](./README.zh.md) | [Español](./README.es.md) | [한국어](./README.ko.md) | [日本語](./README.ja.md) | **Русский**
<!-- README-I18N:END -->

<br/>

![Status](https://img.shields.io/badge/Status-Stable-brightgreen)
![Release](https://img.shields.io/badge/Release-RJ%20CORE%201-10b981)
![Version](https://img.shields.io/badge/Version-v1.11.1-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.2-purple)
![Languages](https://img.shields.io/badge/Languages-51-orange)
![Cache](https://img.shields.io/badge/Cache-ResponseCache%20%2B%20LSCache-0ea5e9)

<br/>

[Веб-сайт](https://rjnexus.org) &nbsp;&bull;&nbsp; [Журнал изменений](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) &nbsp;&bull;&nbsp; [Журнал изменений RJBuilder](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) &nbsp;&bull;&nbsp; [Темы и плагины](https://rj-nexus.github.io/rj-registration/) &nbsp;&bull;&nbsp; [Обсуждения](https://github.com/orgs/rj-nexus/discussions) &nbsp;&bull;&nbsp; [Исходный код](https://github.com/rj-nexus/rj-nexus)

</div>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## О проекте

**RJ CMS** — это современная система управления контентом с самостоятельным хостингом, построенная на **Laravel 12**. Вы устанавливаете её на свой собственный хостинг, сохраняете полное право собственности на свои данные и расширяете её через изолированную систему плагинов и тем. Она поставляется с визуальным конструктором страниц (RJBuilder) с более чем 80 виджетами, двойным AI-движком, **51 языком** (с URL для каждого языка), **двухуровневой системой кэширования** (Response Cache + LiteSpeed LSCache) и браузерным установщиком, который работает на любом общем хостинге или VPS.

**RJ Nexus** — это организация, стоящая за ним. Она размещает ядро CMS и экосистему вокруг него.

Официальный веб-сайт: **[rjnexus.org](https://rjnexus.org)**

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Что нового в v1.11.1

Этот выпуск расширяет RJBuilder до **более чем 80 виджетов**, добавляя новые календари культурных и праздничных событий, калькуляторы, возрастные шлюзы, карусель видео-историй, сетку Bento, текст Markdown и встроенное средство чтения PDF. Средство выбора медиа теперь поддерживает загрузку PDF и многие другие типы файлов, а каталог языков вырос с 47 до **51**, добавив **традиционный китайский**, **малайский**, **тамильский** и **датский**. Полный список изменений доступен в [журнале изменений](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md).

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder &mdash; более 80 виджетов</b><br/>
      Новые виджеты для <b>культуры, религии и праздников</b> (время молитв, время Шаббата, христианские, китайские и индуистские праздники), <b>конверсии и калькуляторов</b> (калькулятор стоимости, сравнение продуктов, шлюзы проверки возраста и выбора возраста) и <b>медиа и контента</b> (карусель видео-историй, витрина сетки Bento, текст Markdown, средство чтения PDF). См. <a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">журнал изменений RJBuilder</a>.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>4 новых языка &mdash; всего 51</b><br/>
      <b>Традиционный китайский</b> (<code>zh_TW</code>), <b>малайский</b> (<code>ms</code>), <b>тамильский</b> (<code>ta</code>) и <b>датский</b> (<code>da</code>) теперь доступны в основной системе и установщике вместе со своими флагами. Во все языковые файлы добавлены новые ключи перевода.
    </td>
  </tr>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>Средство выбора медиа: PDF и более широкая поддержка файлов</b><br/>
      PDF-файлы теперь можно загружать прямо из средства выбора медиа. Оно также поддерживает гораздо больше форматов видео, аудио, изображений и документов, с отдельными фильтрами <b>PDF</b> и <b>Архив</b>.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>Исправление регистрации виджетов</b><br/>
      <code>IconBoxWidget</code>, <code>ImageBoxWidget</code> и <code>AdvancedSearchWidget</code> отсутствовали в списке виджетов, поскольку не были зарегистрированы. Теперь они отображаются в RJBuilder.
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Установка

RJ CMS устанавливается на любом общем хостинге или VPS без изменения единой строки кода.

1. **Загрузка.** Скачайте последний ZIP-релиз и распакуйте его на свой веб-сервер (например, `public_html`).
2. **Запустите установщик.** Откройте `https://yourdomain.com/install.php` в браузере.
3. **Следуйте шагам.** Выберите язык, проверьте требования к серверу, введите учётные данные базы данных и создайте учётную запись администратора.
4. **Демонстрационные данные.** Установщик импортирует страницы, меню и шаблоны конструктора по умолчанию, чтобы ваш сайт не начинался пустым.
5. **Защитите сайт.** Удалите `install.php` и папку `installer/`, когда мастер предложит вам это сделать.

### Видеоруководство

<a href="https://www.youtube.com/watch?v=BU4UXY2D3FU">
  <img src="https://img.youtube.com/vi/BU4UXY2D3FU/0.jpg" alt="Руководство по установке RJ CMS" width="480"/>
</a>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Ключевые возможности

<table>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder &mdash; более 80 виджетов</b><br/>
      Визуальный конструктор страниц, похожий на Elementor, с <b>более чем 80 готовыми виджетами</b>, перетаскиванием, адаптивными элементами управления и динамическими тегами. См. <a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">журнал изменений RJBuilder</a>.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/ai.svg" width="44" height="44" alt=""/><br/>
      <b>Интеграция с ИИ</b><br/>
      Генерация контента, массовый перевод с сохранением HTML и автоматический SEO-аудит.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/security.svg" width="44" height="44" alt=""/><br/>
      <b>Расширенная безопасность</b><br/>
      Двухфакторная аутентификация, подтверждение по электронной почте и ограничение частоты запросов.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/roles.svg" width="44" height="44" alt=""/><br/>
      <b>Роли и разрешения</b><br/>
      Детальный контроль доступа на основе ролей для каждого раздела административной панели.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>Журнал активности</b><br/>
      Отслеживайте, что происходит в административной панели, с ревизиями записей и страниц.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>Многоязычность и RTL</b><br/>
      <b>51 язык</b> с URL для каждого языка и автоматическим отображением справа налево для арабского, курдского и других языков RTL.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Производительность прежде всего</b><br/>
      Двухуровневое кэширование страниц (Response Cache + LiteSpeed LSCache), оптимизация WebP, ленивая загрузка и быстрая компиляция ресурсов через Vite.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>Модульная архитектура</b><br/>
      Плагины и темы полностью изолированы, со своими собственными маршрутами, представлениями и миграциями.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="44" height="44" alt=""/><br/>
      <b>Темы и плагины</b><br/>
      Просмотрите полный каталог в <a href="https://github.com/rj-nexus/rj-registration">списке тем и плагинов</a>.
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<a id="caching"></a>

## Живая демонстрация

Вы можете попробовать RJ Nexus в демонстрации ниже.

> **Примечание:** Демонстрационный сайт может в настоящее время работать не на последней версии (v1.11.1). Он предоставляется только для того, чтобы дать вам представление о том, как выглядит и работает RJ Nexus.

| | | |
|:-:|---|---|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/globe.svg" width="20" height="20" alt="" /> | **Демонстрационный сайт** | [rj-nexus.onrender.com](https://rj-nexus.onrender.com) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/layers.svg" width="20" height="20" alt="" /> | **Административная панель** | Добавьте `/admin` в конец URL демонстрации: [rj-nexus.onrender.com/admin](https://rj-nexus.onrender.com/admin) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file-text.svg" width="20" height="20" alt="" /> | **Электронная почта** | `admin@admin.com` |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file.svg" width="20" height="20" alt="" /> | **Пароль** | `admin123` |

---

## Кэширование

RJ CMS поставляется со встроенной двухуровневой системой кэширования страниц, поэтому ваш сайт остаётся быстрым при реальном трафике даже на скромном общем хостинге.

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Response Cache</b><br/>
      Работает на <a href="https://github.com/spatie/laravel-responsecache"><code>laravel-responsecache</code></a>. Полные ответы приложения сохраняются и отдаются напрямую при повторных запросах, что позволяет пропустить большую часть работы фреймворка. Работает на любом хостинге без необходимости в специальном сервере.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>LiteSpeed Cache (LSCache)</b><br/>
      Работает на <a href="https://github.com/litespeedtech/lscache-laravel"><code>litespeed/lscache-laravel</code></a>. На хостинге LiteSpeed и OpenLiteSpeed страницы кэшируются на уровне веб-сервера и доставляются ещё до запуска PHP.
    </td>
  </tr>
</table>

| | Response Cache | LiteSpeed LSCache |
|---|---|---|
| Пакет | `laravel-responsecache` | `litespeed/lscache-laravel` |
| Уровень кэша | Приложение (Laravel) | Веб-сервер (LiteSpeed) |
| Требования к хостингу | Любой PHP-хостинг | LiteSpeed / OpenLiteSpeed |
| Лучше всего для | Универсальное базовое ускорение | Максимальная скорость на хостинге LiteSpeed |

Поведение кэша управляется в **Админ &rarr; Настройки &rarr; Кэш**.

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Поддерживаемые языки

Поддерживается 51 язык, включая URL для каждого языка (например, `/en/about` и `/az/haqqimizda`).

<table>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/et.svg" width="32" alt="AM"/><br/>Амхарский<br/><code>am</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/sa.svg" width="32" alt="AR"/><br/>Арабский<br/><code>ar</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/am.svg" width="32" alt="HY"/><br/>Армянский<br/><code>hy</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/az.svg" width="32" alt="AZ"/><br/>Азербайджанский<br/><code>az</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/bd.svg" width="32" alt="BN"/><br/>Бенгальский<br/><code>bn</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cn.svg" width="32" alt="ZH"/><br/>Китайский (упрощённый)<br/><code>zh</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/tw.svg" width="32" alt="ZH-TW"/><br/>Китайский (традиционный) <b>НОВЫЙ</b><br/><code>zh_TW</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cz.svg" width="32" alt="CS"/><br/>Чешский<br/><code>cs</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/dk.svg" width="32" alt="DA"/><br/>Датский <b>НОВЫЙ</b><br/><code>da</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nl.svg" width="32" alt="NL"/><br/>Нидерландский<br/><code>nl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gb.svg" width="32" alt="EN"/><br/>Английский<br/><code>en</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ee.svg" width="32" alt="ET"/><br/>Эстонский<br/><code>et</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/fr.svg" width="32" alt="FR"/><br/>Французский<br/><code>fr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ge.svg" width="32" alt="KA"/><br/>Грузинский<br/><code>ka</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/de.svg" width="32" alt="DE"/><br/>Немецкий<br/><code>de</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gr.svg" width="32" alt="EL"/><br/>Греческий<br/><code>el</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ht.svg" width="32" alt="HT"/><br/>Гаитянский креольский<br/><code>ht</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ng.svg" width="32" alt="HA"/><br/>Хауса<br/><code>ha</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/il.svg" width="32" alt="HE"/><br/>Иврит<br/><code>he</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="HI"/><br/>Хинди<br/><code>hi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/hu.svg" width="32" alt="HU"/><br/>Венгерский<br/><code>hu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/id.svg" width="32" alt="ID"/><br/>Индонезийский<br/><code>id</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/it.svg" width="32" alt="IT"/><br/>Итальянский<br/><code>it</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/jp.svg" width="32" alt="JA"/><br/>Японский<br/><code>ja</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/kz.svg" width="32" alt="KK"/><br/>Казахский<br/><code>kk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/rw.svg" width="32" alt="RW"/><br/>Киньяруанда<br/><code>rw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kr.svg" width="32" alt="KO"/><br/>Корейский<br/><code>ko</code></td>
    <td align="center" width="16%"><b>KU</b><br/>Курдский<br/><code>ku</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kg.svg" width="32" alt="KY"/><br/>Киргизский<br/><code>ky</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/my.svg" width="32" alt="MS"/><br/>Малайский <b>НОВЫЙ</b><br/><code>ms</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/nz.svg" width="32" alt="MI"/><br/>Маори<br/><code>mi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="MR"/><br/>Маратхи<br/><code>mr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ir.svg" width="32" alt="FA"/><br/>Персидский<br/><code>fa</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pl.svg" width="32" alt="PL"/><br/>Польский<br/><code>pl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pt.svg" width="32" alt="PT"/><br/>Португальский<br/><code>pt</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/br.svg" width="32" alt="PT-BR"/><br/>Португальский (Бразилия)<br/><code>pt_BR</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pe.svg" width="32" alt="QU"/><br/>Кечуа<br/><code>qu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ro.svg" width="32" alt="RO"/><br/>Румынский<br/><code>ro</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ru.svg" width="32" alt="RU"/><br/>Русский<br/><code>ru</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/es.svg" width="32" alt="ES"/><br/>Испанский<br/><code>es</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ke.svg" width="32" alt="SW"/><br/>Суахили<br/><code>sw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/se.svg" width="32" alt="SV"/><br/>Шведский<br/><code>sv</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ph.svg" width="32" alt="TL"/><br/>Тагальский<br/><code>tl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TA"/><br/>Тамильский <b>НОВЫЙ</b><br/><code>ta</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TE"/><br/>Телугу<br/><code>te</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/th.svg" width="32" alt="TH"/><br/>Тайский<br/><code>th</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tr.svg" width="32" alt="TR"/><br/>Турецкий<br/><code>tr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ua.svg" width="32" alt="UK"/><br/>Украинский<br/><code>uk</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pk.svg" width="32" alt="UR"/><br/>Урду<br/><code>ur</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/uz.svg" width="32" alt="UZ"/><br/>Узбекский<br/><code>uz</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/vn.svg" width="32" alt="VI"/><br/>Вьетнамский<br/><code>vi</code></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Скриншоты

### Административная панель

<p align="center">
  <b>Глобальный поиск с ИИ (Ctrl+K)</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-search.png" alt="Глобальный поиск с ИИ" width="80%"/>
</p>

<table>
  <tr>
    <td width="50%" align="center">
      <b>Панель управления</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/dashboard.png" alt="Панель управления" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Центр ИИ</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-center.png" alt="Центр ИИ" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>RJBuilder (более 80 виджетов)</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/02.png" alt="RJBuilder" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Записи</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/03.png" alt="Записи" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>Медиатека</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/media-library-page.png" alt="Медиатека" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Управление KYC</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/kyc-management-page.png" alt="Управление KYC" width="100%"/>
    </td>
  </tr>
</table>

#### Настройки

<table>
  <tr>
    <td width="50%" align="center">
      <b>Настройки &rarr; ИИ</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/07.png" alt="Настройки - ИИ" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Настройки &rarr; Цвета</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/new-color-page.png" alt="Настройки - Цвета" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>Настройки &rarr; Резервное копирование</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/backup-page.png" alt="Настройки - Резервное копирование" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Настройки &rarr; Обновления</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/update-page.png" alt="Настройки - Обновления" width="100%"/>
    </td>
  </tr>
</table>

### Фронтенд

<table>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front1.png" alt="Фронтенд 1" width="100%"/></td>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front2.png" alt="Фронтенд 2" width="100%"/></td>
  </tr>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front3.png" alt="Фронтенд 3" width="100%"/></td>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front4.png" alt="Фронтенд 4" width="100%"/></td>
  </tr>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front5.png" alt="Фронтенд 5" width="100%"/></td>
    <td width="50%" align="center">
      <b>Учётная запись пользователя</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/accout-page.png" alt="Учётная запись пользователя" width="100%"/>
    </td>
  </tr>
</table>

### Страницы аутентификации

<p align="center">
  <b>Вход и регистрация</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/01.gif" alt="Вход и регистрация" width="100%"/>
</p>

<p align="center">
  <b>Сброс пароля</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/02.gif" alt="Сброс пароля" width="100%"/>
</p>

<p align="center">
  <b>Подтверждение по электронной почте</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/03.gif" alt="Подтверждение по электронной почте" width="100%"/>
</p>

<p align="center">
  <b>Забыли пароль</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/04.gif" alt="Забыли пароль" width="100%"/>
</p>

<p align="center">
  <b>Подтверждение пароля</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/05.gif" alt="Подтверждение пароля" width="100%"/>
</p>

### Страницы ошибок

<table>
  <tr>
    <td width="33%" align="center"><b>400 Неверный запрос</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/400-error.png" alt="400" width="100%"/></td>
    <td width="33%" align="center"><b>401 Требуется аутентификация</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/12.png" alt="401" width="100%"/></td>
    <td width="33%" align="center"><b>403 Запрещено</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/09.png" alt="403" width="100%"/></td>
  </tr>
  <tr>
    <td width="33%" align="center"><b>404 Не найдено</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/10.png" alt="404" width="100%"/></td>
    <td width="33%" align="center"><b>405 Неверный метод запроса</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/11.png" alt="405" width="100%"/></td>
    <td width="33%" align="center"><b>429 Превышен лимит запросов</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/13.png" alt="429" width="100%"/></td>
  </tr>
</table>

<table>
  <tr>
    <td width="50%" align="center"><b>500 Ошибка сервера (режим отладки)</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/500-error-debug.png" alt="500 Отладка" width="100%"/></td>
    <td width="50%" align="center"><b>504 Тайм-аут шлюза</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/504-error.png" alt="504" width="100%"/></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Технологический стек

| Уровень | Технология |
|-------|------------|
| Бэкенд | Laravel 12, PHP 8.2 |
| База данных | MySQL |
| Фронтенд | Blade, Tailwind CSS v3, Alpine.js |
| Инструмент сборки | Vite |
| Кэширование | `laravel-responsecache`, `litespeed/lscache-laravel` |
| AI-движок | OpenRouter и Free AI Proxy |

## Ресурсы

| | Ресурс | Описание |
|:-:|----------|-------------|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [rjnexus.org](https://rjnexus.org) | Официальный веб-сайт |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/changelog.svg" width="28" alt=""/> | [Журнал изменений](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) | Полная история релизов RJ CMS |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="28" alt=""/> | [Журнал изменений RJBuilder](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) | История релизов конструктора страниц |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="28" alt=""/> | [Темы и плагины](https://github.com/rj-nexus/rj-registration) | Каталог доступных тем и плагинов |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/video.svg" width="28" alt=""/> | [Видео установки](https://www.youtube.com/watch?v=BU4UXY2D3FU) | Пошаговое руководство на YouTube |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="28" alt=""/> | [Исходный код](https://github.com/rj-nexus/rj-nexus) | Основной репозиторий RJ CMS |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [Обсуждения](https://github.com/orgs/rj-nexus/discussions) | Вопросы, предложения и жалобы |

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Сообщество и поддержка

Есть вопрос, предложение или жалоба? Присоединяйтесь к обсуждению в [GitHub Discussions](https://github.com/orgs/rj-nexus/discussions).

## Участие в разработке

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/contribute.svg" width="40" height="40" align="left" alt=""/>

Отчёты об ошибках, идеи функций и пул-реквесты приветствуются. Прежде чем приступить к крупным изменениям, создайте issue, сделайте форк репозитория, создайте ветку функции, следуйте PSR-12 и откройте пул-реквест с чётким описанием.

<br clear="left"/>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<div align="center">

Создано **Ruhid Javadov** &nbsp;&bull;&nbsp; Выпущено под лицензией MIT &nbsp;&bull;&nbsp; [rjnexus.org](https://rjnexus.org)

</div>