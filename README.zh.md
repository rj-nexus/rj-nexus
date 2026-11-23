<div align="center">

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/banner.svg" alt="RJ Nexus" width="100%"/>

<!-- README-I18N:START -->
[English](./README.md) | [Português](./README.pt.md) | **中文** | [Español](./README.es.md)
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

[官方网站](https://rjnexus.org) &nbsp;&bull;&nbsp; [更新日志](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) &nbsp;&bull;&nbsp; [RJBuilder 更新日志](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) &nbsp;&bull;&nbsp; [主题与插件](https://rj-nexus.github.io/rj-registration/) &nbsp;&bull;&nbsp; [讨论区](https://github.com/orgs/rj-nexus/discussions) &nbsp;&bull;&nbsp; [源代码](https://github.com/rj-nexus/rj-nexus)

</div>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 关于

**RJ CMS** 是一个基于 **Laravel 12** 构建的现代化、自托管内容管理系统。您可以将其安装在自己的主机上，完全拥有自己的数据，并通过隔离的插件和主题系统进行扩展。它内置可视化页面构建器（RJBuilder），提供 80 多个小部件、双 AI 引擎、**51 种语言**（支持按语言划分的 URL）、**两层缓存系统**（Response Cache + LiteSpeed LSCache），以及基于浏览器的安装程序，适用于任何共享主机或 VPS。

**RJ Nexus** 是它背后的组织，负责托管 CMS 核心及其周围的生态系统。

官方网站：**[rjnexus.org](https://rjnexus.org)**

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## v1.11.1 新功能

本次版本将 RJBuilder 扩展至 **80 多个小部件**，新增文化与节日日历、计算器、年龄验证、视频故事轮播、Bento 网格、Markdown 文本以及页面内 PDF 阅读器。媒体选择器现在支持上传 PDF 以及更多文件类型，语言目录从 47 种增加到 **51 种**，新增**繁体中文**、**马来语**、**泰米尔语**和**丹麦语**。完整的变更列表请参见[更新日志](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md)。

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder &mdash; 80 多个小部件</b><br/>
      全新小部件涵盖<b>文化、宗教与节日</b>（祈祷时间、安息日时间、基督教、中国和印度教节日）、<b>转化与计算器</b>（成本计算器、产品对比、年龄验证与年龄选择门控）以及<b>媒体与内容</b>（视频故事轮播、Bento 网格展示、Markdown 文本、PDF 阅读器）。请参见 <a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">RJBuilder 更新日志</a>。
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>新增 4 种语言 &mdash; 共 51 种</b><br/>
      <b>繁体中文</b>（<code>zh_TW</code>）、<b>马来语</b>（<code>ms</code>）、<b>泰米尔语</b>（<code>ta</code>）和<b>丹麦语</b>（<code>da</code>）现已在核心系统和安装程序中提供，并附带对应的国旗。所有语言文件均已添加新的翻译键。
    </td>
  </tr>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>媒体选择器：PDF 与更广泛的文件支持</b><br/>
      现在可直接从媒体选择器上传 PDF 文件。它还支持更多的视频、音频、图像和文档格式，并带有独立的 <b>PDF</b> 与<b>压缩包</b>筛选器。
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>小部件注册修复</b><br/>
      <code>IconBoxWidget</code>、<code>ImageBoxWidget</code> 和 <code>AdvancedSearchWidget</code> 由于未注册而未出现在小部件列表中。现在它们已出现在 RJBuilder 中。
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 安装

RJ CMS 可安装在任何共享主机或 VPS 上，无需改动任何代码。

1. **上传。** 下载最新的 ZIP 发布包，并将其解压到您的 Web 服务器（例如 `public_html`）。
2. **运行安装程序。** 在浏览器中打开 `https://yourdomain.com/install.php`。
3. **按步骤操作。** 选择语言、验证服务器要求、输入数据库凭据并创建管理员账户。
4. **演示数据。** 安装程序会导入默认页面、菜单和构建器模板，因此您的站点不会一开始就是空的。
5. **保护站点。** 当向导提示时，请删除 `install.php` 和 `installer/` 文件夹。

### 视频指南

<a href="https://www.youtube.com/watch?v=BU4UXY2D3FU">
  <img src="https://img.youtube.com/vi/BU4UXY2D3FU/0.jpg" alt="RJ CMS 安装指南" width="480"/>
</a>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 核心特性

<table>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder &mdash; 80 多个小部件</b><br/>
      类似 Elementor 的可视化页面构建器，提供<b>80 多个现成小部件</b>、拖放、响应式控件和动态标签。请参见 <a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">RJBuilder 更新日志</a>。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/ai.svg" width="44" height="44" alt=""/><br/>
      <b>AI 集成</b><br/>
      内容生成、保留 HTML 的批量翻译以及自动 SEO 审核。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/security.svg" width="44" height="44" alt=""/><br/>
      <b>高级安全</b><br/>
      双因素身份验证、电子邮件验证和速率限制。
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/roles.svg" width="44" height="44" alt=""/><br/>
      <b>角色与权限</b><br/>
      针对每个管理模块的细粒度基于角色的访问控制。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>活动日志</b><br/>
      跟踪管理面板中发生的操作，并为文章和页面提供修订记录。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>多语言与 RTL</b><br/>
      <b>51 种语言</b>，支持按语言划分的 URL，并自动为阿拉伯语、库尔德语及其他 RTL 语言进行从右到左渲染。
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>性能优先</b><br/>
      两层页面缓存（Response Cache + LiteSpeed LSCache）、WebP 优化、懒加载以及通过 Vite 进行的快速资源编译。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>模块化架构</b><br/>
      插件和主题完全隔离，拥有自己的路由、视图和迁移。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="44" height="44" alt=""/><br/>
      <b>主题与插件</b><br/>
      在<a href="https://github.com/rj-nexus/rj-registration">主题与插件列表</a>中浏览完整目录。
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<a id="caching"></a>

## 在线演示

您可以在下方演示中试用 RJ Nexus。

> **注意：** 演示站点目前可能未运行最新版本（v1.11.1）。它仅用于让您了解 RJ Nexus 的外观和工作方式。

| | | |
|:-:|---|---|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/globe.svg" width="20" height="20" alt="" /> | **演示站点** | [rj-nexus.onrender.com](https://rj-nexus.onrender.com) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/layers.svg" width="20" height="20" alt="" /> | **管理面板** | 在演示 URL 末尾添加 `/admin`：[rj-nexus.onrender.com/admin](https://rj-nexus.onrender.com/admin) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file-text.svg" width="20" height="20" alt="" /> | **电子邮件** | `admin@admin.com` |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file.svg" width="20" height="20" alt="" /> | **密码** | `admin123` |

---

## 缓存

RJ CMS 内置两层页面缓存系统，使您的站点在真实流量下依然保持快速，即使在普通的共享主机上也是如此。

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Response Cache</b><br/>
      由 <a href="https://github.com/spatie/laravel-responsecache"><code>laravel-responsecache</code></a> 驱动。完整的应用程序响应被存储并在重复请求时直接返回，从而跳过框架的大部分工作。适用于任何主机，无需特殊服务器。
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>LiteSpeed 缓存（LSCache）</b><br/>
      由 <a href="https://github.com/litespeedtech/lscache-laravel"><code>litespeed/lscache-laravel</code></a> 驱动。在 LiteSpeed 和 OpenLiteSpeed 主机上，页面在 Web 服务器级别进行缓存，并在 PHP 启动之前即被返回。
    </td>
  </tr>
</table>

| | Response Cache | LiteSpeed LSCache |
|---|---|---|
| 软件包 | `laravel-responsecache` | `litespeed/lscache-laravel` |
| 缓存级别 | 应用程序（Laravel） | Web 服务器（LiteSpeed） |
| 主机要求 | 任何 PHP 主机 | LiteSpeed / OpenLiteSpeed |
| 最适合 | 通用的基础加速 | LiteSpeed 主机上的最大速度 |

缓存行为通过 **管理 &rarr; 设置 &rarr; 缓存** 进行管理。

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 支持的语言

共支持 51 种语言，包括按语言划分的 URL（例如 `/en/about` 和 `/az/haqqimizda`）。

<table>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/et.svg" width="32" alt="AM"/><br/>阿姆哈拉语<br/><code>am</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/sa.svg" width="32" alt="AR"/><br/>阿拉伯语<br/><code>ar</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/am.svg" width="32" alt="HY"/><br/>亚美尼亚语<br/><code>hy</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/az.svg" width="32" alt="AZ"/><br/>阿塞拜疆语<br/><code>az</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/bd.svg" width="32" alt="BN"/><br/>孟加拉语<br/><code>bn</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cn.svg" width="32" alt="ZH"/><br/>中文（简体）<br/><code>zh</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/tw.svg" width="32" alt="ZH-TW"/><br/>中文（繁体）<b>新增</b><br/><code>zh_TW</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cz.svg" width="32" alt="CS"/><br/>捷克语<br/><code>cs</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/dk.svg" width="32" alt="DA"/><br/>丹麦语<b>新增</b><br/><code>da</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nl.svg" width="32" alt="NL"/><br/>荷兰语<br/><code>nl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gb.svg" width="32" alt="EN"/><br/>英语<br/><code>en</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ee.svg" width="32" alt="ET"/><br/>爱沙尼亚语<br/><code>et</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/fr.svg" width="32" alt="FR"/><br/>法语<br/><code>fr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ge.svg" width="32" alt="KA"/><br/>格鲁吉亚语<br/><code>ka</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/de.svg" width="32" alt="DE"/><br/>德语<br/><code>de</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gr.svg" width="32" alt="EL"/><br/>希腊语<br/><code>el</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ht.svg" width="32" alt="HT"/><br/>海地克里奥尔语<br/><code>ht</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ng.svg" width="32" alt="HA"/><br/>豪萨语<br/><code>ha</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/il.svg" width="32" alt="HE"/><br/>希伯来语<br/><code>he</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="HI"/><br/>印地语<br/><code>hi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/hu.svg" width="32" alt="HU"/><br/>匈牙利语<br/><code>hu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/id.svg" width="32" alt="ID"/><br/>印度尼西亚语<br/><code>id</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/it.svg" width="32" alt="IT"/><br/>意大利语<br/><code>it</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/jp.svg" width="32" alt="JA"/><br/>日语<br/><code>ja</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/kz.svg" width="32" alt="KK"/><br/>哈萨克语<br/><code>kk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/rw.svg" width="32" alt="RW"/><br/>卢旺达语<br/><code>rw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kr.svg" width="32" alt="KO"/><br/>韩语<br/><code>ko</code></td>
    <td align="center" width="16%"><b>KU</b><br/>库尔德语<br/><code>ku</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kg.svg" width="32" alt="KY"/><br/>吉尔吉斯语<br/><code>ky</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/my.svg" width="32" alt="MS"/><br/>马来语<b>新增</b><br/><code>ms</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/nz.svg" width="32" alt="MI"/><br/>毛利语<br/><code>mi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="MR"/><br/>马拉地语<br/><code>mr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ir.svg" width="32" alt="FA"/><br/>波斯语<br/><code>fa</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pl.svg" width="32" alt="PL"/><br/>波兰语<br/><code>pl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pt.svg" width="32" alt="PT"/><br/>葡萄牙语<br/><code>pt</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/br.svg" width="32" alt="PT-BR"/><br/>葡萄牙语（巴西）<br/><code>pt_BR</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pe.svg" width="32" alt="QU"/><br/>克丘亚语<br/><code>qu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ro.svg" width="32" alt="RO"/><br/>罗马尼亚语<br/><code>ro</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ru.svg" width="32" alt="RU"/><br/>俄语<br/><code>ru</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/es.svg" width="32" alt="ES"/><br/>西班牙语<br/><code>es</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ke.svg" width="32" alt="SW"/><br/>斯瓦希里语<br/><code>sw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/se.svg" width="32" alt="SV"/><br/>瑞典语<br/><code>sv</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ph.svg" width="32" alt="TL"/><br/>他加禄语<br/><code>tl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TA"/><br/>泰米尔语<b>新增</b><br/><code>ta</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TE"/><br/>泰卢固语<br/><code>te</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/th.svg" width="32" alt="TH"/><br/>泰语<br/><code>th</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tr.svg" width="32" alt="TR"/><br/>土耳其语<br/><code>tr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ua.svg" width="32" alt="UK"/><br/>乌克兰语<br/><code>uk</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pk.svg" width="32" alt="UR"/><br/>乌尔都语<br/><code>ur</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/uz.svg" width="32" alt="UZ"/><br/>乌兹别克语<br/><code>uz</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/vn.svg" width="32" alt="VI"/><br/>越南语<br/><code>vi</code></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 屏幕截图

### 管理面板

<p align="center">
  <b>AI 全局搜索（Ctrl+K）</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-search.png" alt="AI 全局搜索" width="80%"/>
</p>

<table>
  <tr>
    <td width="50%" align="center">
      <b>仪表盘</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/dashboard.png" alt="仪表盘" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>AI 中心</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-center.png" alt="AI 中心" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>RJBuilder（80 多个小部件）</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/02.png" alt="RJBuilder" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>文章</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/03.png" alt="文章" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>媒体库</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/media-library-page.png" alt="媒体库" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>KYC 管理</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/kyc-management-page.png" alt="KYC 管理" width="100%"/>
    </td>
  </tr>
</table>

#### 设置

<table>
  <tr>
    <td width="50%" align="center">
      <b>设置 &rarr; AI</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/07.png" alt="设置 - AI" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>设置 &rarr; 颜色</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/new-color-page.png" alt="设置 - 颜色" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>设置 &rarr; 备份</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/backup-page.png" alt="设置 - 备份" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>设置 &rarr; 更新</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/update-page.png" alt="设置 - 更新" width="100%"/>
    </td>
  </tr>
</table>

### 前端

<table>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front1.png" alt="前端 1" width="100%"/></td>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front2.png" alt="前端 2" width="100%"/></td>
  </tr>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front3.png" alt="前端 3" width="100%"/></td>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front4.png" alt="前端 4" width="100%"/></td>
  </tr>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front5.png" alt="前端 5" width="100%"/></td>
    <td width="50%" align="center">
      <b>用户账户</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/accout-page.png" alt="用户账户" width="100%"/>
    </td>
  </tr>
</table>

### 身份验证页面

<p align="center">
  <b>登录与注册</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/01.gif" alt="登录与注册" width="100%"/>
</p>

<p align="center">
  <b>重置密码</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/02.gif" alt="重置密码" width="100%"/>
</p>

<p align="center">
  <b>电子邮件验证</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/03.gif" alt="电子邮件验证" width="100%"/>
</p>

<p align="center">
  <b>忘记密码</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/04.gif" alt="忘记密码" width="100%"/>
</p>

<p align="center">
  <b>确认密码</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/05.gif" alt="确认密码" width="100%"/>
</p>

### 错误页面

<table>
  <tr>
    <td width="33%" align="center"><b>400 错误请求</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/400-error.png" alt="400" width="100%"/></td>
    <td width="33%" align="center"><b>401 需要身份验证</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/12.png" alt="401" width="100%"/></td>
    <td width="33%" align="center"><b>403 禁止访问</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/09.png" alt="403" width="100%"/></td>
  </tr>
  <tr>
    <td width="33%" align="center"><b>404 未找到</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/10.png" alt="404" width="100%"/></td>
    <td width="33%" align="center"><b>405 无效的请求方法</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/11.png" alt="405" width="100%"/></td>
    <td width="33%" align="center"><b>429 超出速率限制</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/13.png" alt="429" width="100%"/></td>
  </tr>
</table>

<table>
  <tr>
    <td width="50%" align="center"><b>500 服务器错误（调试模式）</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/500-error-debug.png" alt="500 调试" width="100%"/></td>
    <td width="50%" align="center"><b>504 网关超时</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/504-error.png" alt="504" width="100%"/></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 技术栈

| 层级 | 技术 |
|-------|------------|
| 后端 | Laravel 12、PHP 8.2 |
| 数据库 | MySQL |
| 前端 | Blade、Tailwind CSS v3、Alpine.js |
| 构建工具 | Vite |
| 缓存 | `laravel-responsecache`、`litespeed/lscache-laravel` |
| AI 引擎 | OpenRouter 与 Free AI Proxy |

## 资源

| | 资源 | 描述 |
|:-:|----------|-------------|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [rjnexus.org](https://rjnexus.org) | 官方网站 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/changelog.svg" width="28" alt=""/> | [更新日志](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) | RJ CMS 的完整版本历史 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="28" alt=""/> | [RJBuilder 更新日志](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) | 页面构建器的版本历史 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="28" alt=""/> | [主题与插件](https://github.com/rj-nexus/rj-registration) | 可用主题和插件的目录 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/video.svg" width="28" alt=""/> | [安装视频](https://www.youtube.com/watch?v=BU4UXY2D3FU) | YouTube 上的分步指南 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="28" alt=""/> | [源代码](https://github.com/rj-nexus/rj-nexus) | RJ CMS 核心仓库 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [讨论区](https://github.com/orgs/rj-nexus/discussions) | 问题、建议与反馈 |

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 社区与支持

有问题、建议或反馈？欢迎在 [GitHub Discussions](https://github.com/orgs/rj-nexus/discussions) 中加入讨论。

## 贡献

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/contribute.svg" width="40" height="40" align="left" alt=""/>

欢迎提交错误报告、功能建议和拉取请求。在开始进行重大更改之前，请先创建一个 issue，fork 该仓库，创建一个功能分支，遵循 PSR-12 规范，并提交带有清晰描述的拉取请求。

<br clear="left"/>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<div align="center">

由 **Ruhid Javadov** 创建 &nbsp;&bull;&nbsp; 基于 MIT 许可证发布 &nbsp;&bull;&nbsp; [rjnexus.org](https://rjnexus.org)

</div>