<div align="center">

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/banner.svg" alt="RJ Nexus" width="100%"/>

<!-- README-I18N:START -->
[English](./README.md) | [Português](./README.pt.md) | **中文** | [Español](./README.es.md) | [한국어](./README.ko.md) | [日本語](./README.ja.md) | [Русский](./README.ru.md)
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

[官方网站](https://rjnexus.org) &nbsp;&bull;&nbsp; [更新日志](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) &nbsp;&bull;&nbsp; [RJBuilder 更新日志](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) &nbsp;&bull;&nbsp; [主题与插件](https://rj-nexus.github.io/rj-registration/) &nbsp;&bull;&nbsp; [讨论区](https://github.com/orgs/rj-nexus/discussions) &nbsp;&bull;&nbsp; [源代码](https://github.com/rj-nexus/rj-nexus)

</div>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 关于

**RJ CMS** 是一款基于 **Laravel 12** 构建的现代化自托管内容管理系统。您可以将其安装在自己的主机上，完全掌控自己的数据，并通过相互隔离的插件和主题系统进行扩展。它内置可视化页面构建器（RJBuilder，拥有 80 多个小部件）、内置的**营销帖子生成器**、双 AI 引擎、支持按语言区分网址的 **55 种语言**、**双层缓存系统**（Response Cache + LiteSpeed LSCache），以及可在任何共享主机或 VPS 上运行的浏览器安装向导。

**RJ Nexus** 是其背后的组织，负责托管 CMS 核心及其周边生态。

官方网站：**[rjnexus.org](https://rjnexus.org)**

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## v1.12.0 新特性

此版本推出了**营销帖子生成器**，这是一个内置的设计工作室，可将您的文章转换为可直接分享的图片。此外还新增了文章和页面的**快速编辑**、带有 20 多种提示音的**浏览器通知**，以及四种新语言，使语言总数达到 **55** 种。完整的变更列表请查看[更新日志](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md)。

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>营销帖子生成器</b><br/>
      选择您的一篇文章，无需离开管理后台即可设计社交媒体图片。可从 <b>8 种布局</b>和 <b>8 种快速样式</b>中选择，设置自己的渐变色或图片，添加您的徽标和品牌，并导出为 <b>PNG、JPG 或 WebP</b>。一次性将所有社交媒体尺寸（1:1、4:5、9:16、16:9、4:3）打包为一个 <b>ZIP</b>，将图片复制到剪贴板，或将您的设计保存为可复用的模板。通过“文章”页面上的<b>创建营销帖子</b>按钮即可打开。
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>文章和页面的快速编辑</b><br/>
      直接在列表中修改<b>标题</b>、<b>固定链接（slug）</b>和<b>状态</b>。例如，无需打开完整编辑器，一步即可将已发布的文章改回草稿。
    </td>
  </tr>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>浏览器通知与 20 多种提示音</b><br/>
      即使管理后台标签页处于后台，新通知到达时您也能第一时间收到提醒。可从 <b>20 多种通知提示音</b>中选择，新通知到达时站点卡片上还会显示提示标记。通知设置现在更轻量、更简洁。
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>新增 4 种语言，共计 55 种</b><br/>
      现已支持<b>挪威语</b>（<code>no</code>）、<b>芬兰语</b>（<code>fi</code>）、<b>保加利亚语</b>（<code>bg</code>）和<b>塞尔维亚语</b>（<code>sr</code>）。同时也为所有语言补充了缺失的翻译字符串。
    </td>
  </tr>
</table>

此版本还包括：侧边栏新增 **RJ Apps** 板块；过长的标题和 slug 不再破坏“文章”和“页面”的布局；页面编辑和创建界面中的语言旗帜现已正确显示；新增丹麦国旗；活动日志条目再次可以删除。

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 安装

RJ CMS 可安装在任何共享主机或 VPS 上，无需修改任何代码。

1. **上传。** 下载最新的 ZIP 发行包，并解压到您的网站服务器（例如 `public_html`）。
2. **运行安装程序。** 在浏览器中打开 `https://yourdomain.com/install.php`。
3. **按步骤操作。** 选择语言、检查服务器环境要求、填写数据库凭据并创建管理员账户。
4. **演示数据。** 安装程序会导入默认页面、菜单和构建器模板，这样您的网站一开始就不是空白的。
5. **保护网站。** 向导提示时，请删除 `install.php` 和 `installer/` 文件夹。

### 视频指南

<a href="https://www.youtube.com/watch?v=BU4UXY2D3FU">
  <img src="https://img.youtube.com/vi/BU4UXY2D3FU/0.jpg" alt="RJ CMS 安装指南" width="480"/>
</a>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 主要特性

<table>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder &mdash; 80 多个小部件</b><br/>
      类似 Elementor 的可视化页面构建器，拥有 <b>80 多个现成小部件</b>，支持拖放、响应式控制和动态标签。请参阅 <a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">RJBuilder 更新日志</a>。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/ai.svg" width="44" height="44" alt=""/><br/>
      <b>AI 集成</b><br/>
      内容生成、保留 HTML 的批量翻译，以及自动 SEO 审核。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/security.svg" width="44" height="44" alt=""/><br/>
      <b>高级安全</b><br/>
      双因素认证、邮箱验证和请求频率限制。
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/roles.svg" width="44" height="44" alt=""/><br/>
      <b>角色与权限</b><br/>
      针对每个管理板块的精细化基于角色的访问控制。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>活动日志</b><br/>
      追踪管理后台中发生的操作，并为文章和页面提供修订历史。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>多语言与 RTL</b><br/>
      <b>55 种语言</b>，支持按语言区分的网址，并为阿拉伯语、库尔德语等从右到左的语言自动适配 RTL 排版。
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>性能优先</b><br/>
      双层页面缓存（Response Cache + LiteSpeed LSCache）、WebP 优化、懒加载，以及通过 Vite 实现的快速资源编译。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>模块化架构</b><br/>
      插件和主题完全隔离，拥有各自独立的路由、视图和数据库迁移。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="44" height="44" alt=""/><br/>
      <b>主题与插件</b><br/>
      在<a href="https://github.com/rj-nexus/rj-registration">主题和插件列表</a>中浏览完整目录。
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<a id="caching"></a>

## 在线演示

您可以在下面的演示站点中体验 RJ Nexus。

> **注意：** 演示站点目前可能并未运行最新版本。它仅用于让您了解 RJ Nexus 的外观和使用方式。

| | | |
|:-:|---|---|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/globe.svg" width="20" height="20" alt="" /> | **演示站点** | [rj-nexus.onrender.com](https://rj-nexus.onrender.com) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/layers.svg" width="20" height="20" alt="" /> | **管理后台** | 在演示网址末尾添加 `/admin`：[rj-nexus.onrender.com/admin](https://rj-nexus.onrender.com/admin) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file-text.svg" width="20" height="20" alt="" /> | **邮箱** | `admin@admin.com` |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file.svg" width="20" height="20" alt="" /> | **密码** | `admin123` |

---

## 缓存

RJ CMS 内置双层页面缓存系统，即使在配置一般的共享主机上，您的网站在真实流量下也能保持快速。

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Response Cache</b><br/>
      由 <a href="https://github.com/spatie/laravel-responsecache"><code>laravel-responsecache</code></a> 提供支持。完整的应用响应会被存储，并在重复请求时直接返回，从而跳过框架的大部分处理工作。适用于任何主机，无需特殊服务器。
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>LiteSpeed Cache（LSCache）</b><br/>
      由 <a href="https://github.com/litespeedtech/lscache-laravel"><code>litespeed/lscache-laravel</code></a> 提供支持。在 LiteSpeed 和 OpenLiteSpeed 主机上，页面在网页服务器层面被缓存，甚至在 PHP 启动之前就已返回。
    </td>
  </tr>
</table>

| | Response Cache | LiteSpeed LSCache |
|---|---|---|
| 软件包 | `laravel-responsecache` | `litespeed/lscache-laravel` |
| 缓存层级 | 应用层（Laravel） | 网页服务器层（LiteSpeed） |
| 主机要求 | 任何支持 PHP 的主机 | LiteSpeed / OpenLiteSpeed |
| 最适合 | 通用的基础加速 | 在 LiteSpeed 主机上获得最高速度 |

缓存行为可在 **管理后台 &rarr; 设置 &rarr; 缓存** 中管理。

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 支持的语言

支持 55 种语言，并支持按语言区分的网址（例如 `/en/about` 和 `/az/haqqimizda`）。

<table>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/et.svg" width="32" alt="AM"/><br/>阿姆哈拉语<br/><code>am</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/sa.svg" width="32" alt="AR"/><br/>阿拉伯语<br/><code>ar</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/am.svg" width="32" alt="HY"/><br/>亚美尼亚语<br/><code>hy</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/az.svg" width="32" alt="AZ"/><br/>阿塞拜疆语<br/><code>az</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/bd.svg" width="32" alt="BN"/><br/>孟加拉语<br/><code>bn</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/bg.svg" width="32" alt="BG"/><br/>保加利亚语 <b>新增</b><br/><code>bg</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/cn.svg" width="32" alt="ZH"/><br/>简体中文<br/><code>zh</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tw.svg" width="32" alt="ZH-TW"/><br/>繁体中文<br/><code>zh_TW</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cz.svg" width="32" alt="CS"/><br/>捷克语<br/><code>cs</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/dk.svg" width="32" alt="DA"/><br/>丹麦语<br/><code>da</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nl.svg" width="32" alt="NL"/><br/>荷兰语<br/><code>nl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gb.svg" width="32" alt="EN"/><br/>英语<br/><code>en</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ee.svg" width="32" alt="ET"/><br/>爱沙尼亚语<br/><code>et</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/fi.svg" width="32" alt="FI"/><br/>芬兰语 <b>新增</b><br/><code>fi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/fr.svg" width="32" alt="FR"/><br/>法语<br/><code>fr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ge.svg" width="32" alt="KA"/><br/>格鲁吉亚语<br/><code>ka</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/de.svg" width="32" alt="DE"/><br/>德语<br/><code>de</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gr.svg" width="32" alt="EL"/><br/>希腊语<br/><code>el</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ht.svg" width="32" alt="HT"/><br/>海地克里奥尔语<br/><code>ht</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ng.svg" width="32" alt="HA"/><br/>豪萨语<br/><code>ha</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/il.svg" width="32" alt="HE"/><br/>希伯来语<br/><code>he</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="HI"/><br/>印地语<br/><code>hi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/hu.svg" width="32" alt="HU"/><br/>匈牙利语<br/><code>hu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/id.svg" width="32" alt="ID"/><br/>印度尼西亚语<br/><code>id</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/it.svg" width="32" alt="IT"/><br/>意大利语<br/><code>it</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/jp.svg" width="32" alt="JA"/><br/>日语<br/><code>ja</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kz.svg" width="32" alt="KK"/><br/>哈萨克语<br/><code>kk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/rw.svg" width="32" alt="RW"/><br/>卢旺达语<br/><code>rw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kr.svg" width="32" alt="KO"/><br/>韩语<br/><code>ko</code></td>
    <td align="center" width="16%"><b>KU</b><br/>库尔德语<br/><code>ku</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/kg.svg" width="32" alt="KY"/><br/>吉尔吉斯语<br/><code>ky</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/my.svg" width="32" alt="MS"/><br/>马来语<br/><code>ms</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nz.svg" width="32" alt="MI"/><br/>毛利语<br/><code>mi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="MR"/><br/>马拉地语<br/><code>mr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/no.svg" width="32" alt="NO"/><br/>挪威语 <b>新增</b><br/><code>no</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ir.svg" width="32" alt="FA"/><br/>波斯语<br/><code>fa</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pl.svg" width="32" alt="PL"/><br/>波兰语<br/><code>pl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pt.svg" width="32" alt="PT"/><br/>葡萄牙语<br/><code>pt</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/br.svg" width="32" alt="PT-BR"/><br/>葡萄牙语（巴西）<br/><code>pt_BR</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pe.svg" width="32" alt="QU"/><br/>克丘亚语<br/><code>qu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ro.svg" width="32" alt="RO"/><br/>罗马尼亚语<br/><code>ro</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ru.svg" width="32" alt="RU"/><br/>俄语<br/><code>ru</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/rs.svg" width="32" alt="SR"/><br/>塞尔维亚语 <b>新增</b><br/><code>sr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/es.svg" width="32" alt="ES"/><br/>西班牙语<br/><code>es</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ke.svg" width="32" alt="SW"/><br/>斯瓦希里语<br/><code>sw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/se.svg" width="32" alt="SV"/><br/>瑞典语<br/><code>sv</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ph.svg" width="32" alt="TL"/><br/>他加禄语<br/><code>tl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TA"/><br/>泰米尔语<br/><code>ta</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TE"/><br/>泰卢固语<br/><code>te</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/th.svg" width="32" alt="TH"/><br/>泰语<br/><code>th</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tr.svg" width="32" alt="TR"/><br/>土耳其语<br/><code>tr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ua.svg" width="32" alt="UK"/><br/>乌克兰语<br/><code>uk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pk.svg" width="32" alt="UR"/><br/>乌尔都语<br/><code>ur</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/uz.svg" width="32" alt="UZ"/><br/>乌兹别克语<br/><code>uz</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/vn.svg" width="32" alt="VI"/><br/>越南语<br/><code>vi</code></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 截图

### 管理后台

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
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/yeni_post_sehifesi.png" alt="文章" width="100%"/>
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

#### 工具

<table>
  <tr>
    <td width="50%" align="center">
      <b>营销帖子生成器</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/marketin-sehifesi.png" alt="营销帖子生成器" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>工具 &rarr; 备份</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/backup_page_new.png" alt="工具 - 备份" width="100%"/>
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
      <b>通知设置</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/bildiris_ayarlari_sehifesi.png" alt="通知设置" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>设置 &rarr; 更新</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/update-page.png" alt="设置 - 更新" width="100%"/>
    </td>
  </tr>
</table>

### 前台

<table>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front1.png" alt="前台 1" width="100%"/></td>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front2.png" alt="前台 2" width="100%"/></td>
  </tr>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front3.png" alt="前台 3" width="100%"/></td>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front4.png" alt="前台 4" width="100%"/></td>
  </tr>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front5.png" alt="前台 5" width="100%"/></td>
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
  <b>邮箱验证</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/03.gif" alt="邮箱验证" width="100%"/>
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
    <td width="33%" align="center"><b>405 请求方法无效</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/11.png" alt="405" width="100%"/></td>
    <td width="33%" align="center"><b>429 超出请求频率限制</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/13.png" alt="429" width="100%"/></td>
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
| AI 引擎 | OpenRouter 和 Free AI Proxy |

## 资源

| | 资源 | 说明 |
|:-:|----------|-------------|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [rjnexus.org](https://rjnexus.org) | 官方网站 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/changelog.svg" width="28" alt=""/> | [更新日志](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) | RJ CMS 的完整发布历史 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="28" alt=""/> | [RJBuilder 更新日志](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) | 页面构建器的发布历史 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="28" alt=""/> | [主题与插件](https://github.com/rj-nexus/rj-registration) | 可用主题和插件目录 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/video.svg" width="28" alt=""/> | [安装视频](https://www.youtube.com/watch?v=BU4UXY2D3FU) | YouTube 上的分步指南 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="28" alt=""/> | [源代码](https://github.com/rj-nexus/rj-nexus) | RJ CMS 核心代码仓库 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [讨论区](https://github.com/orgs/rj-nexus/discussions) | 提问、建议和投诉 |

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 社区与支持

有问题、建议或投诉？欢迎在 [GitHub Discussions](https://github.com/orgs/rj-nexus/discussions) 中参与讨论。

## 参与贡献

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/contribute.svg" width="40" height="40" align="left" alt=""/>

欢迎提交错误报告、功能建议和拉取请求。在开始较大的改动之前，请先创建一个 issue；然后 fork 本仓库，创建功能分支，遵循 PSR-12 规范，并提交带有清晰说明的拉取请求。

<br clear="left"/>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<div align="center">

由 **Ruhid Javadov** 创建 &nbsp;&bull;&nbsp; 基于 MIT 许可证发布 &nbsp;&bull;&nbsp; [rjnexus.org](https://rjnexus.org)

</div>