<div align="center">

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/banner.svg" alt="RJ Nexus" width="100%"/>

<!-- README-I18N:START -->
[English](./README.md) | [Português](./README.pt.md) | [中文](./README.zh.md) | [Español](./README.es.md) | [한국어](./README.ko.md) | **日本語** | [Русский](./README.ru.md)
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

[ウェブサイト](https://rjnexus.org) &nbsp;&bull;&nbsp; [変更履歴](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) &nbsp;&bull;&nbsp; [RJBuilder 変更履歴](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) &nbsp;&bull;&nbsp; [テーマとプラグイン](https://rj-nexus.github.io/rj-registration/) &nbsp;&bull;&nbsp; [ディスカッション](https://github.com/orgs/rj-nexus/discussions) &nbsp;&bull;&nbsp; [ソースコード](https://github.com/rj-nexus/rj-nexus)

</div>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 概要

**RJ CMS** は、**Laravel 12** 上に構築されたモダンでセルフホスト型のコンテンツ管理システムです。ご自身のホスティングにインストールし、データの完全な所有権を維持しながら、分離されたプラグインおよびテーマシステムを通じて拡張できます。80 以上のウィジェットを備えたビジュアルページビルダー(RJBuilder)、デュアル AI エンジン、**51 言語**(言語別 URL 対応)、**2 層キャッシングシステム**(Response Cache + LiteSpeed LSCache)、そしてあらゆる共有ホスティングや VPS で動作するブラウザベースのインストーラーを搭載しています。

**RJ Nexus** はその背後にある組織で、CMS コアとその周辺のエコシステムをホストしています。

公式ウェブサイト: **[rjnexus.org](https://rjnexus.org)**

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## v1.11.1 の新機能

このリリースでは、RJBuilder が **80 以上のウィジェット**に拡張され、新しい文化・祝日カレンダー、計算機、年齢確認、ビデオストーリーカルーセル、Bento グリッド、Markdown テキスト、ページ内 PDF リーダーが追加されました。メディアピッカーは PDF アップロードとより多くのファイル形式をサポートし、言語カタログは 47 から **51** に拡大され、**繁体字中国語**、**マレー語**、**タミル語**、**デンマーク語**が追加されました。変更の完全なリストは[変更履歴](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md)で確認できます。

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder &mdash; 80 以上のウィジェット</b><br/>
      <b>文化・宗教・祝日</b>(礼拝時間、安息日時間、キリスト教・中国・ヒンドゥー教の祭り)、<b>コンバージョンと計算機</b>(コスト計算機、製品比較、年齢確認・年齢選択ゲート)、<b>メディアとコンテンツ</b>(ビデオストーリーカルーセル、Bento グリッドショーケース、Markdown テキスト、PDF リーダー)の新しいウィジェット。<a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">RJBuilder 変更履歴</a>をご覧ください。
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>4 つの新言語 &mdash; 合計 51</b><br/>
      <b>繁体字中国語</b>(<code>zh_TW</code>)、<b>マレー語</b>(<code>ms</code>)、<b>タミル語</b>(<code>ta</code>)、<b>デンマーク語</b>(<code>da</code>)が、それぞれの国旗とともにコアシステムとインストーラーで利用できるようになりました。新しい翻訳キーがすべての言語ファイルに追加されました。
    </td>
  </tr>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>メディアピッカー: PDF と幅広いファイルサポート</b><br/>
      PDF ファイルをメディアピッカーから直接アップロードできるようになりました。さらに多くのビデオ、オーディオ、画像、ドキュメント形式をサポートし、<b>PDF</b> と<b>アーカイブ</b>のフィルターが別々に用意されています。
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>ウィジェット登録の修正</b><br/>
      <code>IconBoxWidget</code>、<code>ImageBoxWidget</code>、<code>AdvancedSearchWidget</code> が登録されていなかったため、ウィジェットリストに表示されていませんでした。これらは RJBuilder に表示されるようになりました。
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## インストール

RJ CMS は、コードを一行も変更することなく、あらゆる共有ホスティングまたは VPS にインストールできます。

1. **アップロード。** 最新の ZIP リリースをダウンロードし、ウェブサーバー(例: `public_html`)に解凍します。
2. **インストーラーを実行。** ブラウザで `https://yourdomain.com/install.php` を開きます。
3. **手順に従います。** 言語を選択し、サーバー要件を確認し、データベースの認証情報を入力し、管理者アカウントを作成します。
4. **デモデータ。** インストーラーは既定のページ、メニュー、ビルダーテンプレートをインポートするため、サイトが空の状態で始まることはありません。
5. **サイトを保護。** ウィザードの指示に従って、`install.php` と `installer/` フォルダーを削除します。

### ビデオガイド

<a href="https://www.youtube.com/watch?v=BU4UXY2D3FU">
  <img src="https://img.youtube.com/vi/BU4UXY2D3FU/0.jpg" alt="RJ CMS インストールガイド" width="480"/>
</a>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 主な機能

<table>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder &mdash; 80 以上のウィジェット</b><br/>
      Elementor に似たビジュアルページビルダーで、<b>80 以上の既製ウィジェット</b>、ドラッグ＆ドロップ、レスポンシブコントロール、動的タグを提供します。<a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">RJBuilder 変更履歴</a>をご覧ください。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/ai.svg" width="44" height="44" alt=""/><br/>
      <b>AI 統合</b><br/>
      コンテンツ生成、HTML を保持する一括翻訳、自動 SEO 監査。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/security.svg" width="44" height="44" alt=""/><br/>
      <b>高度なセキュリティ</b><br/>
      二要素認証、メール認証、レート制限。
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/roles.svg" width="44" height="44" alt=""/><br/>
      <b>ロールと権限</b><br/>
      すべての管理セクションに対するきめ細かなロールベースのアクセス制御。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>アクティビティログ</b><br/>
      管理パネルで行われた操作を追跡し、投稿とページのリビジョンを提供します。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>多言語と RTL</b><br/>
      <b>51 言語</b>と言語別 URL、アラビア語、クルド語、その他の RTL 言語に対する右から左への自動レンダリング。
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>パフォーマンス優先</b><br/>
      2 層ページキャッシング(Response Cache + LiteSpeed LSCache)、WebP 最適化、遅延読み込み、Vite による高速アセットコンパイル。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>モジュラーアーキテクチャ</b><br/>
      プラグインとテーマは、独自のルート、ビュー、マイグレーションとともに完全に分離されています。
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="44" height="44" alt=""/><br/>
      <b>テーマとプラグイン</b><br/>
      <a href="https://github.com/rj-nexus/rj-registration">テーマとプラグインのリスト</a>で完全なカタログをご覧ください。
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<a id="caching"></a>

## ライブデモ

以下のデモで RJ Nexus をお試しいただけます。

> **注意:** デモサイトは現在、最新バージョン(v1.11.1)を実行していない可能性があります。RJ Nexus の見た目と動作を把握していただくためのみに提供されています。

| | | |
|:-:|---|---|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/globe.svg" width="20" height="20" alt="" /> | **デモサイト** | [rj-nexus.onrender.com](https://rj-nexus.onrender.com) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/layers.svg" width="20" height="20" alt="" /> | **管理パネル** | デモ URL の末尾に `/admin` を追加: [rj-nexus.onrender.com/admin](https://rj-nexus.onrender.com/admin) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file-text.svg" width="20" height="20" alt="" /> | **メール** | `admin@admin.com` |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file.svg" width="20" height="20" alt="" /> | **パスワード** | `admin123` |

---

## キャッシング

RJ CMS には、2 層のページキャッシングシステムが組み込まれているため、適度な共有ホスティングでも実際のトラフィック下でサイトが高速に保たれます。

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Response Cache</b><br/>
      <a href="https://github.com/spatie/laravel-responsecache"><code>laravel-responsecache</code></a> によって提供されます。完全なアプリケーション応答が保存され、繰り返しリクエスト時に直接提供されるため、フレームワーク作業の大部分を省略できます。特別なサーバーなしで、あらゆるホスティングで動作します。
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>LiteSpeed キャッシュ(LSCache)</b><br/>
      <a href="https://github.com/litespeedtech/lscache-laravel"><code>litespeed/lscache-laravel</code></a> によって提供されます。LiteSpeed および OpenLiteSpeed ホスティングでは、ページはウェブサーバーレベルでキャッシュされ、PHP が起動する前に配信されます。
    </td>
  </tr>
</table>

| | Response Cache | LiteSpeed LSCache |
|---|---|---|
| パッケージ | `laravel-responsecache` | `litespeed/lscache-laravel` |
| キャッシュレベル | アプリケーション(Laravel) | ウェブサーバー(LiteSpeed) |
| ホスティング要件 | すべての PHP ホスティング | LiteSpeed / OpenLiteSpeed |
| 最適な用途 | 汎用的なベースライン高速化 | LiteSpeed ホスティングでの最大速度 |

キャッシュ動作は **管理 &rarr; 設定 &rarr; キャッシュ** で管理されます。

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## サポートされている言語

51 の言語がサポートされており、言語別 URL(例: `/en/about`、`/az/haqqimizda`)が含まれます。

<table>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/et.svg" width="32" alt="AM"/><br/>アムハラ語<br/><code>am</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/sa.svg" width="32" alt="AR"/><br/>アラビア語<br/><code>ar</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/am.svg" width="32" alt="HY"/><br/>アルメニア語<br/><code>hy</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/az.svg" width="32" alt="AZ"/><br/>アゼルバイジャン語<br/><code>az</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/bd.svg" width="32" alt="BN"/><br/>ベンガル語<br/><code>bn</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cn.svg" width="32" alt="ZH"/><br/>中国語(簡体字)<br/><code>zh</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/tw.svg" width="32" alt="ZH-TW"/><br/>中国語(繁体字) <b>新規</b><br/><code>zh_TW</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cz.svg" width="32" alt="CS"/><br/>チェコ語<br/><code>cs</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/dk.svg" width="32" alt="DA"/><br/>デンマーク語 <b>新規</b><br/><code>da</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nl.svg" width="32" alt="NL"/><br/>オランダ語<br/><code>nl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gb.svg" width="32" alt="EN"/><br/>英語<br/><code>en</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ee.svg" width="32" alt="ET"/><br/>エストニア語<br/><code>et</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/fr.svg" width="32" alt="FR"/><br/>フランス語<br/><code>fr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ge.svg" width="32" alt="KA"/><br/>ジョージア語<br/><code>ka</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/de.svg" width="32" alt="DE"/><br/>ドイツ語<br/><code>de</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gr.svg" width="32" alt="EL"/><br/>ギリシャ語<br/><code>el</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ht.svg" width="32" alt="HT"/><br/>ハイチ・クレオール語<br/><code>ht</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ng.svg" width="32" alt="HA"/><br/>ハウサ語<br/><code>ha</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/il.svg" width="32" alt="HE"/><br/>ヘブライ語<br/><code>he</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="HI"/><br/>ヒンディー語<br/><code>hi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/hu.svg" width="32" alt="HU"/><br/>ハンガリー語<br/><code>hu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/id.svg" width="32" alt="ID"/><br/>インドネシア語<br/><code>id</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/it.svg" width="32" alt="IT"/><br/>イタリア語<br/><code>it</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/jp.svg" width="32" alt="JA"/><br/>日本語<br/><code>ja</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/kz.svg" width="32" alt="KK"/><br/>カザフ語<br/><code>kk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/rw.svg" width="32" alt="RW"/><br/>キニャルワンダ語<br/><code>rw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kr.svg" width="32" alt="KO"/><br/>韓国語<br/><code>ko</code></td>
    <td align="center" width="16%"><b>KU</b><br/>クルド語<br/><code>ku</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kg.svg" width="32" alt="KY"/><br/>キルギス語<br/><code>ky</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/my.svg" width="32" alt="MS"/><br/>マレー語 <b>新規</b><br/><code>ms</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/nz.svg" width="32" alt="MI"/><br/>マオリ語<br/><code>mi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="MR"/><br/>マラーティー語<br/><code>mr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ir.svg" width="32" alt="FA"/><br/>ペルシア語<br/><code>fa</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pl.svg" width="32" alt="PL"/><br/>ポーランド語<br/><code>pl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pt.svg" width="32" alt="PT"/><br/>ポルトガル語<br/><code>pt</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/br.svg" width="32" alt="PT-BR"/><br/>ポルトガル語(ブラジル)<br/><code>pt_BR</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pe.svg" width="32" alt="QU"/><br/>ケチュア語<br/><code>qu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ro.svg" width="32" alt="RO"/><br/>ルーマニア語<br/><code>ro</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ru.svg" width="32" alt="RU"/><br/>ロシア語<br/><code>ru</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/es.svg" width="32" alt="ES"/><br/>スペイン語<br/><code>es</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ke.svg" width="32" alt="SW"/><br/>スワヒリ語<br/><code>sw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/se.svg" width="32" alt="SV"/><br/>スウェーデン語<br/><code>sv</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ph.svg" width="32" alt="TL"/><br/>タガログ語<br/><code>tl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TA"/><br/>タミル語 <b>新規</b><br/><code>ta</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TE"/><br/>テルグ語<br/><code>te</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/th.svg" width="32" alt="TH"/><br/>タイ語<br/><code>th</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tr.svg" width="32" alt="TR"/><br/>トルコ語<br/><code>tr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ua.svg" width="32" alt="UK"/><br/>ウクライナ語<br/><code>uk</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pk.svg" width="32" alt="UR"/><br/>ウルドゥー語<br/><code>ur</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/uz.svg" width="32" alt="UZ"/><br/>ウズベク語<br/><code>uz</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/vn.svg" width="32" alt="VI"/><br/>ベトナム語<br/><code>vi</code></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## スクリーンショット

### 管理パネル

<p align="center">
  <b>AI グローバル検索 (Ctrl+K)</b><br/><br/>
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
      <b>RJBuilder (80 以上のウィジェット)</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/02.png" alt="RJBuilder" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>投稿</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/03.png" alt="投稿" width="100%"/>
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

#### 設定

<table>
  <tr>
    <td width="50%" align="center">
      <b>設定 &rarr; AI</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/07.png" alt="設定 - AI" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>設定 &rarr; 色</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/new-color-page.png" alt="設定 - 色" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>設定 &rarr; バックアップ</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/backup-page.png" alt="設定 - バックアップ" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>設定 &rarr; 更新</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/update-page.png" alt="設定 - 更新" width="100%"/>
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
  <b>パスワードを忘れた場合</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/04.gif" alt="パスワードを忘れた場合" width="100%"/>
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
    <td width="33%" align="center"><b>403 禁止</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/09.png" alt="403" width="100%"/></td>
  </tr>
  <tr>
    <td width="33%" align="center"><b>404 見つかりません</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/10.png" alt="404" width="100%"/></td>
    <td width="33%" align="center"><b>405 無効なリクエストメソッド</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/11.png" alt="405" width="100%"/></td>
    <td width="33%" align="center"><b>429 レート制限を超えました</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/13.png" alt="429" width="100%"/></td>
  </tr>
</table>

<table>
  <tr>
    <td width="50%" align="center"><b>500 サーバーエラー (デバッグモード)</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/500-error-debug.png" alt="500 デバッグ" width="100%"/></td>
    <td width="50%" align="center"><b>504 ゲートウェイタイムアウト</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/504-error.png" alt="504" width="100%"/></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 技術スタック

| レイヤー | テクノロジー |
|-------|------------|
| バックエンド | Laravel 12、PHP 8.2 |
| データベース | MySQL |
| フロントエンド | Blade、Tailwind CSS v3、Alpine.js |
| ビルドツール | Vite |
| キャッシング | `laravel-responsecache`、`litespeed/lscache-laravel` |
| AI エンジン | OpenRouter と Free AI Proxy |

## リソース

| | リソース | 説明 |
|:-:|----------|-------------|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [rjnexus.org](https://rjnexus.org) | 公式ウェブサイト |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/changelog.svg" width="28" alt=""/> | [変更履歴](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) | RJ CMS の完全なリリース履歴 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="28" alt=""/> | [RJBuilder 変更履歴](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) | ページビルダーのリリース履歴 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="28" alt=""/> | [テーマとプラグイン](https://github.com/rj-nexus/rj-registration) | 利用可能なテーマとプラグインのカタログ |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/video.svg" width="28" alt=""/> | [インストールビデオ](https://www.youtube.com/watch?v=BU4UXY2D3FU) | YouTube のステップバイステップガイド |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="28" alt=""/> | [ソースコード](https://github.com/rj-nexus/rj-nexus) | RJ CMS コアリポジトリ |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [ディスカッション](https://github.com/orgs/rj-nexus/discussions) | 質問、提案、苦情 |

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## コミュニティとサポート

質問、提案、苦情がありますか? [GitHub Discussions](https://github.com/orgs/rj-nexus/discussions) で会話に参加してください。

## 貢献

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/contribute.svg" width="40" height="40" align="left" alt=""/>

バグ報告、機能のアイデア、プルリクエストを歓迎します。大きな変更の作業を開始する前にイシューを作成し、リポジトリをフォークし、フィーチャーブランチを作成し、PSR-12 に従って、明確な説明を添えてプルリクエストを作成してください。

<br clear="left"/>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<div align="center">

**Ruhid Javadov** によって作成 &nbsp;&bull;&nbsp; MIT ライセンスの下でリリース &nbsp;&bull;&nbsp; [rjnexus.org](https://rjnexus.org)

</div>