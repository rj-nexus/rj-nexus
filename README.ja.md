<div align="center">

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/banner.svg" alt="RJ Nexus" width="100%"/>

<!-- README-I18N:START -->
[English](./README.md) | [Português](./README.pt.md) | [中文](./README.zh.md) | [Español](./README.es.md) | [한국어](./README.ko.md) | **日本語** | [Русский](./README.ru.md)
<!-- README-I18N:END -->

<br/>

![Status](https://img.shields.io/badge/Status-Stable-brightgreen)
![Release](https://img.shields.io/badge/Release-RJ%20CORE%201-10b981)
![Version](https://img.shields.io/badge/Version-v1.12.2-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.2-purple)
![Languages](https://img.shields.io/badge/Languages-55-orange)
![Cache](https://img.shields.io/badge/Cache-ResponseCache%20%2B%20LSCache-0ea5e9)

<br/>

[公式サイト](https://rjnexus.org) &nbsp;&bull;&nbsp; [変更履歴](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) &nbsp;&bull;&nbsp; [RJBuilder 変更履歴](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) &nbsp;&bull;&nbsp; [テーマ & プラグイン](https://rj-nexus.github.io/rj-registration/) &nbsp;&bull;&nbsp; [ディスカッション](https://github.com/orgs/rj-nexus/discussions) &nbsp;&bull;&nbsp; [ソースコード](https://github.com/rj-nexus/rj-nexus)

</div>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 概要

**RJ CMS** は、**Laravel 12** で構築されたモダンなセルフホスト型のコンテンツ管理システムです。ご自身のホスティングにインストールでき、データの所有権は完全にあなたのものです。独立したプラグインとテーマのしくみで機能を拡張できます。80 以上のウィジェットを備えたビジュアルページビルダー（RJBuilder）、内蔵の**マーケティング投稿ジェネレーター**、デュアル AI エンジン、言語ごとの URL に対応した **55 言語**、**2 層キャッシュシステム**（Response Cache + LiteSpeed LSCache）、そしてどの共有ホスティングや VPS でも動作するブラウザベースのインストーラーを搭載しています。

**RJ Nexus** は、その開発を担う組織です。CMS コアとそれを取り巻くエコシステムを公開しています。

公式サイト: **[rjnexus.org](https://rjnexus.org)**

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## v1.12.2 の新機能

このリリースでは、投稿をそのまま共有できる画像に変えるデザインスタジオ、**マーケティング投稿ジェネレーター**を搭載しました。さらに、投稿とページの**クイック編集**、20 種類以上のサウンドに対応した**ブラウザ通知**、4 つの新しい言語を追加し、対応言語は合計 **55 言語**になりました。変更内容の全一覧は[変更履歴](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md)をご覧ください。

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>マーケティング投稿ジェネレーター</b><br/>
      管理画面を離れることなく、投稿を選んで SNS 用の画像をデザインできます。<b>8 種類のレイアウト</b>と <b>8 種類のクイックスタイル</b>から選び、グラデーションや画像を自由に設定し、ロゴとブランドを追加して、<b>PNG・JPG・WebP</b> で書き出せます。すべての SNS サイズ（1:1、4:5、9:16、16:9、4:3）を 1 つの <b>ZIP</b> にまとめて取得したり、画像をクリップボードにコピーしたり、デザインを再利用できるテンプレートとして保存したりできます。投稿ページの <b>Create Marketing Post</b> ボタンから開けます。
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>投稿とページのクイック編集</b><br/>
      一覧画面から直接、<b>タイトル</b>、<b>スラッグ</b>、<b>ステータス</b>を変更できます。たとえば、公開済みの投稿をワンステップで下書きに戻せます。完全なエディターを開く必要はありません。
    </td>
  </tr>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>ブラウザ通知と 20 種類以上のサウンド</b><br/>
      管理画面のタブがバックグラウンドにあっても、新しい通知が届いた瞬間にお知らせします。<b>20 種類以上の通知サウンド</b>から選べるほか、新しい通知が届くとサイトカードにインジケーターが表示されます。通知設定も、より軽量でシンプルになりました。
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>新しい 4 言語を追加（合計 55 言語）</b><br/>
      <b>ノルウェー語</b>（<code>no</code>）、<b>フィンランド語</b>（<code>fi</code>）、<b>ブルガリア語</b>（<code>bg</code>）、<b>セルビア語</b>（<code>sr</code>）が利用できるようになりました。すべての言語で、不足していた翻訳文字列も追加されています。
    </td>
  </tr>
</table>

このリリースにはほかにも、サイドバーの新しい **RJ Apps** セクション、長いタイトルやスラッグが投稿・ページのレイアウトを崩さないようになる修正、ページの編集・作成画面で言語のフラグが正しく表示される修正、デンマークのフラグの追加、アクティビティログのエントリーを再び削除できるようになる修正が含まれます。

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## インストール

RJ CMS は、コードを 1 行も編集することなく、どの共有ホスティングや VPS にもインストールできます。

1. **アップロード。** 最新のリリース ZIP をダウンロードし、Web サーバー（たとえば `public_html`）に展開します。
2. **インストーラーを実行。** ブラウザで `https://yourdomain.com/install.php` を開きます。
3. **手順に従う。** 言語を選び、サーバー要件を確認し、データベースの認証情報を入力して、管理者アカウントを作成します。
4. **デモデータ。** インストーラーが既定のページ、メニュー、ビルダーテンプレートをインポートするため、サイトが空の状態で始まることはありません。
5. **サイトを保護。** ウィザードの案内に従って、`install.php` と `installer/` フォルダーを削除します。

### 動画ガイド

<a href="https://www.youtube.com/watch?v=BU4UXY2D3FU">
  <img src="https://img.youtube.com/vi/BU4UXY2D3FU/0.jpg" alt="RJ CMS インストールガイド" width="480"/>
</a>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 主な機能

<table>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder：80 以上のウィジェット</b><br/>
      Elementor のようなビジュアルページビルダー。<b>80 以上の既製ウィジェット</b>、ドラッグ＆ドロップ、レスポンシブ設定、ダイナミックタグを備えています。<a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">RJBuilder の変更履歴</a>もご覧ください。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/ai.svg" width="44" height="44" alt=""/><br/>
      <b>AI 連携</b><br/>
      コンテンツ生成、HTML を保持した一括翻訳、自動 SEO 監査に対応しています。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/security.svg" width="44" height="44" alt=""/><br/>
      <b>高度なセキュリティ</b><br/>
      2 要素認証、メール認証、レート制限を備えています。
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/roles.svg" width="44" height="44" alt=""/><br/>
      <b>ロールと権限</b><br/>
      管理画面のすべてのセクションに対して、きめ細かなロールベースのアクセス制御ができます。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>アクティビティログ</b><br/>
      管理画面で行われた操作を記録し、投稿とページのリビジョンも管理できます。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>多言語対応と RTL</b><br/>
      言語ごとの URL に対応した <b>55 言語</b>。アラビア語、クルド語などの右から左へ書く言語（RTL）も自動で表示されます。
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>パフォーマンス重視</b><br/>
      2 層のページキャッシュ（Response Cache + LiteSpeed LSCache）、WebP 最適化、遅延読み込み、Vite による高速なアセットビルドを備えています。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>モジュール式アーキテクチャ</b><br/>
      プラグインとテーマは完全に分離されており、それぞれが独自のルート、ビュー、マイグレーションを持ちます。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="44" height="44" alt=""/><br/>
      <b>テーマ & プラグイン</b><br/>
      すべてのカタログは<a href="https://github.com/rj-nexus/rj-registration">テーマとプラグインの一覧</a>でご覧いただけます。
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<a id="caching"></a>

## ライブデモ

以下のデモで RJ Nexus をお試しいただけます。

> **注意:** デモサイトは、現時点で最新バージョンで動作していない場合があります。RJ Nexus の見た目と動作のイメージをつかんでいただくためだけに提供しています。

| | | |
|:-:|---|---|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/globe.svg" width="20" height="20" alt="" /> | **デモサイト** | [rj-nexus.onrender.com](https://rj-nexus.onrender.com) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/layers.svg" width="20" height="20" alt="" /> | **管理画面** | デモ URL の末尾に `/admin` を付けてください: [rj-nexus.onrender.com/admin](https://rj-nexus.onrender.com/admin) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file-text.svg" width="20" height="20" alt="" /> | **メールアドレス** | `admin@admin.com` |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file.svg" width="20" height="20" alt="" /> | **パスワード** | `admin123` |

---

## キャッシュ

RJ CMS には、2 層構造のページキャッシュシステムが標準で組み込まれています。控えめな共有ホスティングでも、実際のトラフィックの下でサイトを高速に保てます。

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Response Cache</b><br/>
      <a href="https://github.com/spatie/laravel-responsecache"><code>laravel-responsecache</code></a> を採用しています。アプリケーションのレスポンス全体を保存し、同じリクエストが来たときにそのまま返すことで、フレームワークの処理の大半を省略します。特別なサーバーは不要で、どのホスティングでも動作します。
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>LiteSpeed Cache (LSCache)</b><br/>
      <a href="https://github.com/litespeedtech/lscache-laravel"><code>litespeed/lscache-laravel</code></a> を採用しています。LiteSpeed と OpenLiteSpeed のホスティングでは、Web サーバーのレベルでページをキャッシュし、PHP が起動する前に配信します。
    </td>
  </tr>
</table>

| | Response Cache | LiteSpeed LSCache |
|---|---|---|
| パッケージ | `laravel-responsecache` | `litespeed/lscache-laravel` |
| キャッシュのレベル | アプリケーション（Laravel） | Web サーバー（LiteSpeed） |
| ホスティング要件 | PHP が動作するホスティングなら何でも可 | LiteSpeed / OpenLiteSpeed |
| 適した用途 | 誰でも得られる基本的な高速化 | LiteSpeed ホストでの最高速度 |

キャッシュの動作は **Admin &rarr; Settings &rarr; Cache** で管理します。

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 対応言語

言語ごとの URL（例: `/en/about` と `/az/haqqimizda`）を含め、55 言語に対応しています。

<table>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/az.svg" width="32" alt="AZ"/><br/>アゼルバイジャン語<br/><code>az</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/et.svg" width="32" alt="AM"/><br/>アムハラ語<br/><code>am</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/sa.svg" width="32" alt="AR"/><br/>アラビア語<br/><code>ar</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/am.svg" width="32" alt="HY"/><br/>アルメニア語<br/><code>hy</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/it.svg" width="32" alt="IT"/><br/>イタリア語<br/><code>it</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/id.svg" width="32" alt="ID"/><br/>インドネシア語<br/><code>id</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ua.svg" width="32" alt="UK"/><br/>ウクライナ語<br/><code>uk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/uz.svg" width="32" alt="UZ"/><br/>ウズベク語<br/><code>uz</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pk.svg" width="32" alt="UR"/><br/>ウルドゥー語<br/><code>ur</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gb.svg" width="32" alt="EN"/><br/>英語<br/><code>en</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ee.svg" width="32" alt="ET"/><br/>エストニア語<br/><code>et</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nl.svg" width="32" alt="NL"/><br/>オランダ語<br/><code>nl</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/kz.svg" width="32" alt="KK"/><br/>カザフ語<br/><code>kk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kr.svg" width="32" alt="KO"/><br/>韓国語<br/><code>ko</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/rw.svg" width="32" alt="RW"/><br/>キニヤルワンダ語<br/><code>rw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kg.svg" width="32" alt="KY"/><br/>キルギス語<br/><code>ky</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gr.svg" width="32" alt="EL"/><br/>ギリシャ語<br/><code>el</code></td>
    <td align="center" width="16%"><b>KU</b><br/>クルド語<br/><code>ku</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pe.svg" width="32" alt="QU"/><br/>ケチュア語<br/><code>qu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ge.svg" width="32" alt="KA"/><br/>ジョージア語<br/><code>ka</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/se.svg" width="32" alt="SV"/><br/>スウェーデン語<br/><code>sv</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/es.svg" width="32" alt="ES"/><br/>スペイン語<br/><code>es</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ke.svg" width="32" alt="SW"/><br/>スワヒリ語<br/><code>sw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/rs.svg" width="32" alt="SR"/><br/>セルビア語 <b>NEW</b><br/><code>sr</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/th.svg" width="32" alt="TH"/><br/>タイ語<br/><code>th</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ph.svg" width="32" alt="TL"/><br/>タガログ語<br/><code>tl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TA"/><br/>タミル語<br/><code>ta</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cz.svg" width="32" alt="CS"/><br/>チェコ語<br/><code>cs</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cn.svg" width="32" alt="ZH"/><br/>中国語（簡体字）<br/><code>zh</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tw.svg" width="32" alt="ZH-TW"/><br/>中国語（繁体字）<br/><code>zh_TW</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TE"/><br/>テルグ語<br/><code>te</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/dk.svg" width="32" alt="DA"/><br/>デンマーク語<br/><code>da</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tr.svg" width="32" alt="TR"/><br/>トルコ語<br/><code>tr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/de.svg" width="32" alt="DE"/><br/>ドイツ語<br/><code>de</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/jp.svg" width="32" alt="JA"/><br/>日本語<br/><code>ja</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/no.svg" width="32" alt="NO"/><br/>ノルウェー語 <b>NEW</b><br/><code>no</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ht.svg" width="32" alt="HT"/><br/>ハイチ・クレオール語<br/><code>ht</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ng.svg" width="32" alt="HA"/><br/>ハウサ語<br/><code>ha</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/hu.svg" width="32" alt="HU"/><br/>ハンガリー語<br/><code>hu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="HI"/><br/>ヒンディー語<br/><code>hi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/fi.svg" width="32" alt="FI"/><br/>フィンランド語 <b>NEW</b><br/><code>fi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/fr.svg" width="32" alt="FR"/><br/>フランス語<br/><code>fr</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/bg.svg" width="32" alt="BG"/><br/>ブルガリア語 <b>NEW</b><br/><code>bg</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/il.svg" width="32" alt="HE"/><br/>ヘブライ語<br/><code>he</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/vn.svg" width="32" alt="VI"/><br/>ベトナム語<br/><code>vi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/bd.svg" width="32" alt="BN"/><br/>ベンガル語<br/><code>bn</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ir.svg" width="32" alt="FA"/><br/>ペルシア語<br/><code>fa</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pl.svg" width="32" alt="PL"/><br/>ポーランド語<br/><code>pl</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pt.svg" width="32" alt="PT"/><br/>ポルトガル語<br/><code>pt</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/br.svg" width="32" alt="PT-BR"/><br/>ポルトガル語（ブラジル）<br/><code>pt_BR</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nz.svg" width="32" alt="MI"/><br/>マオリ語<br/><code>mi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="MR"/><br/>マラーティー語<br/><code>mr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/my.svg" width="32" alt="MS"/><br/>マレー語<br/><code>ms</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ro.svg" width="32" alt="RO"/><br/>ルーマニア語<br/><code>ro</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ru.svg" width="32" alt="RU"/><br/>ロシア語<br/><code>ru</code></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## スクリーンショット

### 管理画面

<p align="center">
  <b>AI グローバル検索（Ctrl+K）</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-search.png" alt="AI グローバル検索" width="80%"/>
</p>

<table>
  <tr>
    <td width="50%" align="center">
      <b>ダッシュボード</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/dashboard.png" alt="ダッシュボード" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>AI センター</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-center.png" alt="AI センター" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>RJBuilder（80 以上のウィジェット）</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/02.png" alt="RJBuilder" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>投稿</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/yeni_post_sehifesi.png" alt="投稿" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>メディアライブラリ</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/media-library-page.png" alt="メディアライブラリ" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>KYC 管理</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/kyc-management-page.png" alt="KYC 管理" width="100%"/>
    </td>
  </tr>
</table>

#### ツール

<table>
  <tr>
    <td width="50%" align="center">
      <b>マーケティング投稿ジェネレーター</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/marketin-sehifesi.png" alt="マーケティング投稿ジェネレーター" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>ツール &rarr; バックアップ</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/backup_page_new.png" alt="ツール - バックアップ" width="100%"/>
    </td>
  </tr>
</table>

#### 設定

<table>
  <tr>
    <td width="50%" align="center">
      <b>設定 &rarr; AI</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/07.png" alt="設定 - AI" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>設定 &rarr; カラー</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/new-color-page.png" alt="設定 - カラー" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>通知設定</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/bildiris_ayarlari_sehifesi.png" alt="通知設定" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>設定 &rarr; アップデート</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/update-page.png" alt="設定 - アップデート" width="100%"/>
    </td>
  </tr>
</table>

### フロントエンド

<table>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front1.png" alt="フロントエンド 1" width="100%"/></td>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front2.png" alt="フロントエンド 2" width="100%"/></td>
  </tr>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front3.png" alt="フロントエンド 3" width="100%"/></td>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front4.png" alt="フロントエンド 4" width="100%"/></td>
  </tr>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front5.png" alt="フロントエンド 5" width="100%"/></td>
    <td width="50%" align="center">
      <b>ユーザーアカウント</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/accout-page.png" alt="ユーザーアカウント" width="100%"/>
    </td>
  </tr>
</table>

### 認証ページ

<p align="center">
  <b>ログインと登録</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/01.gif" alt="ログインと登録" width="100%"/>
</p>

<p align="center">
  <b>パスワードのリセット</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/02.gif" alt="パスワードのリセット" width="100%"/>
</p>

<p align="center">
  <b>メール認証</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/03.gif" alt="メール認証" width="100%"/>
</p>

<p align="center">
  <b>パスワードをお忘れの場合</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/04.gif" alt="パスワードをお忘れの場合" width="100%"/>
</p>

<p align="center">
  <b>パスワードの確認</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/05.gif" alt="パスワードの確認" width="100%"/>
</p>

### エラーページ

<table>
  <tr>
    <td width="33%" align="center"><b>400 不正なリクエスト</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/400-error.png" alt="400" width="100%"/></td>
    <td width="33%" align="center"><b>401 認証が必要</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/12.png" alt="401" width="100%"/></td>
    <td width="33%" align="center"><b>403 アクセス禁止</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/09.png" alt="403" width="100%"/></td>
  </tr>
  <tr>
    <td width="33%" align="center"><b>404 ページが見つかりません</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/10.png" alt="404" width="100%"/></td>
    <td width="33%" align="center"><b>405 許可されていないリクエストメソッド</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/11.png" alt="405" width="100%"/></td>
    <td width="33%" align="center"><b>429 リクエスト制限超過</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/13.png" alt="429" width="100%"/></td>
  </tr>
</table>

<table>
  <tr>
    <td width="50%" align="center"><b>500 サーバーエラー（デバッグモード）</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/500-error-debug.png" alt="500 デバッグ" width="100%"/></td>
    <td width="50%" align="center"><b>504 ゲートウェイタイムアウト</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/504-error.png" alt="504" width="100%"/></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 技術スタック

| レイヤー | 技術 |
|----------|------|
| バックエンド | Laravel 12、PHP 8.2 |
| データベース | MySQL |
| フロントエンド | Blade、Tailwind CSS v3、Alpine.js |
| ビルドツール | Vite |
| キャッシュ | `laravel-responsecache`、`litespeed/lscache-laravel` |
| AI エンジン | OpenRouter と Free AI Proxy |

## リソース

| | リソース | 説明 |
|:-:|----------|------|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [rjnexus.org](https://rjnexus.org) | 公式サイト |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/changelog.svg" width="28" alt=""/> | [変更履歴](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) | RJ CMS の全リリース履歴 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="28" alt=""/> | [RJBuilder 変更履歴](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) | ページビルダーのリリース履歴 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="28" alt=""/> | [テーマ & プラグイン](https://github.com/rj-nexus/rj-registration) | 利用可能なテーマとプラグインのカタログ |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/video.svg" width="28" alt=""/> | [インストール動画](https://www.youtube.com/watch?v=BU4UXY2D3FU) | YouTube のステップバイステップガイド |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="28" alt=""/> | [ソースコード](https://github.com/rj-nexus/rj-nexus) | RJ CMS コアのリポジトリ |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [ディスカッション](https://github.com/orgs/rj-nexus/discussions) | 質問、提案、苦情の受付 |

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## コミュニティとサポート

質問、提案、ご意見はありますか？ [GitHub Discussions](https://github.com/orgs/rj-nexus/discussions) でお気軽にご参加ください。

## コントリビューション

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/contribute.svg" width="40" height="40" align="left" alt=""/>

バグ報告、機能のアイデア、プルリクエストを歓迎します。大きな変更に取りかかる前に Issue を作成し、リポジトリをフォークして、機能ブランチを作成してください。PSR-12 に従い、わかりやすい説明を付けてプルリクエストを送ってください。

<br clear="left"/>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<div align="center">

作者: **Ruhid Javadov** &nbsp;&bull;&nbsp; MIT ライセンスで公開 &nbsp;&bull;&nbsp; [rjnexus.org](https://rjnexus.org)

</div>