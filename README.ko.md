<div align="center">

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/banner.svg" alt="RJ Nexus" width="100%"/>

<!-- README-I18N:START -->
**한국어** | [English](./README.md) | [Português](./README.pt.md) | [中文](./README.zh.md) | [Español](./README.es.md) | [日本語](./README.ja.md) | [Русский](./README.ru.md)
<!-- README-I18N:END -->

<br/>

![Status](https://img.shields.io/badge/Status-Stable-brightgreen)
![Release](https://img.shields.io/badge/Release-RJ%20CORE%201-10b981)
![Version](https://img.shields.io/badge/Version-v1.12.1-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.2-purple)
![Languages](https://img.shields.io/badge/Languages-55-orange)
![Cache](https://img.shields.io/badge/Cache-ResponseCache%20%2B%20LSCache-0ea5e9)

<br/>

[웹사이트](https://rjnexus.org) &nbsp;&bull;&nbsp; [변경 내역](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) &nbsp;&bull;&nbsp; [RJBuilder 변경 내역](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) &nbsp;&bull;&nbsp; [테마 및 플러그인](https://rj-nexus.github.io/rj-registration/) &nbsp;&bull;&nbsp; [토론](https://github.com/orgs/rj-nexus/discussions) &nbsp;&bull;&nbsp; [소스 코드](https://github.com/rj-nexus/rj-nexus)

</div>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 소개

**RJ CMS**는 **Laravel 12** 기반의 현대적인 셀프 호스팅 콘텐츠 관리 시스템입니다. 직접 운영하는 호스팅에 설치하여 데이터의 완전한 소유권을 유지할 수 있으며, 격리된 플러그인 및 테마 시스템으로 기능을 확장할 수 있습니다. 80개 이상의 위젯을 갖춘 비주얼 페이지 빌더(RJBuilder), 내장 **마케팅 포스트 생성기**, 듀얼 AI 엔진, 언어별 URL을 지원하는 **55개 언어**, **2계층 캐싱 시스템**(Response Cache + LiteSpeed LSCache), 그리고 모든 공유 호스팅이나 VPS에서 작동하는 브라우저 기반 설치 프로그램을 제공합니다.

**RJ Nexus**는 이 프로젝트를 만든 조직입니다. CMS 코어와 그 주변 생태계를 운영합니다.

공식 웹사이트: **[rjnexus.org](https://rjnexus.org)**

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## v1.12.1 의 새로운 기능

이번 릴리스에는 게시글을 바로 공유할 수 있는 그래픽으로 만들어 주는 내장 디자인 스튜디오 **마케팅 포스트 생성기**가 추가되었습니다. 또한 게시글과 페이지용 **빠른 편집**, 20가지 이상의 소리를 지원하는 **브라우저 알림**, 4개의 새로운 언어가 추가되어 총 **55개 언어**를 지원합니다. 전체 변경 사항은 [변경 내역](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md)에서 확인할 수 있습니다.

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>마케팅 포스트 생성기</b><br/>
      게시글 하나를 선택하면 관리자 패널을 벗어나지 않고 소셜 미디어용 그래픽을 디자인할 수 있습니다. <b>8가지 레이아웃</b>과 <b>8가지 빠른 스타일</b> 중에서 선택하고, 원하는 그라데이션이나 이미지를 설정하고, 로고와 브랜드를 추가한 뒤 <b>PNG, JPG 또는 WebP</b>로 내보내세요. 모든 소셜 형식(1:1, 4:5, 9:16, 16:9, 4:3)을 하나의 <b>ZIP</b>으로 받거나, 이미지를 클립보드에 복사하거나, 디자인을 재사용 가능한 템플릿으로 저장할 수 있습니다. 게시글 페이지의 <b>마케팅 포스트 만들기</b> 버튼으로 열 수 있습니다.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>게시글 및 페이지 빠른 편집</b><br/>
      목록에서 바로 <b>제목</b>, <b>슬러그</b>, <b>상태</b>를 변경할 수 있습니다. 예를 들어 전체 편집기를 열지 않고도 게시된 글을 한 번에 임시 저장 상태로 되돌릴 수 있습니다.
    </td>
  </tr>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>브라우저 알림 및 20가지 이상의 소리</b><br/>
      관리자 탭이 백그라운드에 있어도 새 알림이 도착하는 즉시 알려 줍니다. <b>20가지 이상의 알림음</b> 중에서 선택할 수 있으며, 새 알림이 오면 사이트 카드에 표시가 나타납니다. 알림 설정도 더 가볍고 간단해졌습니다.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>새로운 언어 4개 &mdash; 총 55개</b><br/>
      <b>노르웨이어</b>(<code>no</code>), <b>핀란드어</b>(<code>fi</code>), <b>불가리아어</b>(<code>bg</code>), <b>세르비아어</b>(<code>sr</code>)를 사용할 수 있습니다. 누락되었던 번역 문자열도 모든 언어에 추가되었습니다.
    </td>
  </tr>
</table>

이번 릴리스의 기타 변경 사항: 사이드바에 새로운 **RJ Apps** 섹션이 추가되었고, 긴 제목과 슬러그가 더 이상 게시글 및 페이지 레이아웃을 깨뜨리지 않으며, 페이지 편집 및 생성 화면에서 언어 국기가 올바르게 표시되고, 덴마크 국기가 추가되었으며, 활동 로그 항목을 다시 삭제할 수 있습니다.

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 설치

RJ CMS는 코드를 한 줄도 수정하지 않고 모든 공유 호스팅이나 VPS에 설치할 수 있습니다.

1. **업로드.** 최신 ZIP 릴리스를 다운로드하여 웹 서버(예: `public_html`)에 압축을 풉니다.
2. **설치 프로그램 실행.** 브라우저에서 `https://yourdomain.com/install.php`를 엽니다.
3. **단계 따라 진행.** 언어를 선택하고, 서버 요구 사항을 확인하고, 데이터베이스 정보를 입력한 뒤 관리자 계정을 만듭니다.
4. **데모 데이터.** 설치 프로그램이 기본 페이지, 메뉴, 빌더 템플릿을 가져오므로 사이트가 빈 상태로 시작하지 않습니다.
5. **사이트 보안.** 마법사가 안내하면 `install.php`와 `installer/` 폴더를 삭제하세요.

### 영상 가이드

<a href="https://www.youtube.com/watch?v=BU4UXY2D3FU">
  <img src="https://img.youtube.com/vi/BU4UXY2D3FU/0.jpg" alt="RJ CMS 설치 가이드" width="480"/>
</a>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 주요 기능

<table>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder &mdash; 80개 이상의 위젯</b><br/>
      <b>80개 이상의 기성 위젯</b>, 드래그 앤 드롭, 반응형 컨트롤, 동적 태그를 갖춘 Elementor 스타일의 비주얼 페이지 빌더입니다. <a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">RJBuilder 변경 내역</a>을 참고하세요.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/ai.svg" width="44" height="44" alt=""/><br/>
      <b>AI 통합</b><br/>
      콘텐츠 생성, HTML을 보존하는 일괄 번역, 자동 SEO 점검을 제공합니다.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/security.svg" width="44" height="44" alt=""/><br/>
      <b>고급 보안</b><br/>
      2단계 인증, 이메일 인증, 요청 제한(rate limiting)을 지원합니다.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/roles.svg" width="44" height="44" alt=""/><br/>
      <b>역할 및 권한</b><br/>
      모든 관리자 섹션에 대한 세분화된 역할 기반 접근 제어를 제공합니다.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>활동 로그</b><br/>
      관리자 패널에서 일어나는 일을 추적하며, 게시글과 페이지의 리비전도 지원합니다.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>다국어 및 RTL</b><br/>
      언어별 URL을 지원하는 <b>55개 언어</b>와, 아랍어·쿠르드어 등 RTL 언어를 위한 자동 오른쪽에서 왼쪽 렌더링을 제공합니다.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>성능 우선</b><br/>
      2계층 페이지 캐싱(Response Cache + LiteSpeed LSCache), WebP 최적화, 지연 로딩, Vite 기반의 빠른 에셋 컴파일을 제공합니다.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>모듈형 아키텍처</b><br/>
      플러그인과 테마는 각자의 라우트, 뷰, 마이그레이션을 가지며 완전히 격리되어 있습니다.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="44" height="44" alt=""/><br/>
      <b>테마 및 플러그인</b><br/>
      <a href="https://github.com/rj-nexus/rj-registration">테마 및 플러그인 목록</a>에서 전체 카탈로그를 확인하세요.
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<a id="caching"></a>

## 라이브 데모

아래 데모에서 RJ Nexus를 체험해 볼 수 있습니다.

> **참고:** 데모 사이트는 현재 최신 버전이 아닐 수 있습니다. RJ Nexus의 모습과 동작 방식을 대략적으로 보여 드리기 위한 용도입니다.

| | | |
|:-:|---|---|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/globe.svg" width="20" height="20" alt="" /> | **데모 사이트** | [rj-nexus.onrender.com](https://rj-nexus.onrender.com) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/layers.svg" width="20" height="20" alt="" /> | **관리자 패널** | 데모 URL 끝에 `/admin`을 추가하세요: [rj-nexus.onrender.com/admin](https://rj-nexus.onrender.com/admin) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file-text.svg" width="20" height="20" alt="" /> | **이메일** | `admin@admin.com` |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file.svg" width="20" height="20" alt="" /> | **비밀번호** | `admin123` |

---

## 캐싱

RJ CMS에는 2계층 페이지 캐싱 시스템이 내장되어 있어, 사양이 낮은 공유 호스팅에서도 실제 트래픽 상황에서 사이트를 빠르게 유지합니다.

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Response Cache</b><br/>
      <a href="https://github.com/spatie/laravel-responsecache"><code>laravel-responsecache</code></a> 기반입니다. 애플리케이션 응답 전체를 저장해 두었다가 반복 요청에 바로 제공하므로 프레임워크 작업 대부분을 건너뜁니다. 특별한 서버 없이 모든 호스팅에서 작동합니다.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>LiteSpeed Cache (LSCache)</b><br/>
      <a href="https://github.com/litespeedtech/lscache-laravel"><code>litespeed/lscache-laravel</code></a> 기반입니다. LiteSpeed 및 OpenLiteSpeed 호스팅에서는 웹 서버 수준에서 페이지를 캐시하여 PHP가 시작되기도 전에 전달합니다.
    </td>
  </tr>
</table>

| | Response Cache | LiteSpeed LSCache |
|---|---|---|
| 패키지 | `laravel-responsecache` | `litespeed/lscache-laravel` |
| 캐시 수준 | 애플리케이션 (Laravel) | 웹 서버 (LiteSpeed) |
| 호스팅 요구 사항 | 모든 PHP 호스팅 | LiteSpeed / OpenLiteSpeed |
| 적합한 용도 | 범용 기본 속도 향상 | LiteSpeed 호스트에서 최대 속도 |

캐시 동작은 **관리자 &rarr; 설정 &rarr; 캐시**에서 관리합니다.

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 지원 언어

언어별 URL(예: `/en/about`, `/az/haqqimizda`)을 포함하여 55개 언어를 지원합니다.

<table>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/et.svg" width="32" alt="AM"/><br/>암하라어<br/><code>am</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/sa.svg" width="32" alt="AR"/><br/>아랍어<br/><code>ar</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/am.svg" width="32" alt="HY"/><br/>아르메니아어<br/><code>hy</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/az.svg" width="32" alt="AZ"/><br/>아제르바이잔어<br/><code>az</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/bd.svg" width="32" alt="BN"/><br/>벵골어<br/><code>bn</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/bg.svg" width="32" alt="BG"/><br/>불가리아어 <b>신규</b><br/><code>bg</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/cn.svg" width="32" alt="ZH"/><br/>중국어(간체)<br/><code>zh</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tw.svg" width="32" alt="ZH-TW"/><br/>중국어(번체)<br/><code>zh_TW</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cz.svg" width="32" alt="CS"/><br/>체코어<br/><code>cs</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/dk.svg" width="32" alt="DA"/><br/>덴마크어<br/><code>da</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nl.svg" width="32" alt="NL"/><br/>네덜란드어<br/><code>nl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gb.svg" width="32" alt="EN"/><br/>영어<br/><code>en</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ee.svg" width="32" alt="ET"/><br/>에스토니아어<br/><code>et</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/fi.svg" width="32" alt="FI"/><br/>핀란드어 <b>신규</b><br/><code>fi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/fr.svg" width="32" alt="FR"/><br/>프랑스어<br/><code>fr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ge.svg" width="32" alt="KA"/><br/>조지아어<br/><code>ka</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/de.svg" width="32" alt="DE"/><br/>독일어<br/><code>de</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gr.svg" width="32" alt="EL"/><br/>그리스어<br/><code>el</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ht.svg" width="32" alt="HT"/><br/>아이티 크리올어<br/><code>ht</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ng.svg" width="32" alt="HA"/><br/>하우사어<br/><code>ha</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/il.svg" width="32" alt="HE"/><br/>히브리어<br/><code>he</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="HI"/><br/>힌디어<br/><code>hi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/hu.svg" width="32" alt="HU"/><br/>헝가리어<br/><code>hu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/id.svg" width="32" alt="ID"/><br/>인도네시아어<br/><code>id</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/it.svg" width="32" alt="IT"/><br/>이탈리아어<br/><code>it</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/jp.svg" width="32" alt="JA"/><br/>일본어<br/><code>ja</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kz.svg" width="32" alt="KK"/><br/>카자흐어<br/><code>kk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/rw.svg" width="32" alt="RW"/><br/>키냐르완다어<br/><code>rw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kr.svg" width="32" alt="KO"/><br/>한국어<br/><code>ko</code></td>
    <td align="center" width="16%"><b>KU</b><br/>쿠르드어<br/><code>ku</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/kg.svg" width="32" alt="KY"/><br/>키르기스어<br/><code>ky</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/my.svg" width="32" alt="MS"/><br/>말레이어<br/><code>ms</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nz.svg" width="32" alt="MI"/><br/>마오리어<br/><code>mi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="MR"/><br/>마라티어<br/><code>mr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/no.svg" width="32" alt="NO"/><br/>노르웨이어 <b>신규</b><br/><code>no</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ir.svg" width="32" alt="FA"/><br/>페르시아어<br/><code>fa</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pl.svg" width="32" alt="PL"/><br/>폴란드어<br/><code>pl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pt.svg" width="32" alt="PT"/><br/>포르투갈어<br/><code>pt</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/br.svg" width="32" alt="PT-BR"/><br/>포르투갈어(브라질)<br/><code>pt_BR</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pe.svg" width="32" alt="QU"/><br/>케추아어<br/><code>qu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ro.svg" width="32" alt="RO"/><br/>루마니아어<br/><code>ro</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ru.svg" width="32" alt="RU"/><br/>러시아어<br/><code>ru</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/rs.svg" width="32" alt="SR"/><br/>세르비아어 <b>신규</b><br/><code>sr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/es.svg" width="32" alt="ES"/><br/>스페인어<br/><code>es</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ke.svg" width="32" alt="SW"/><br/>스와힐리어<br/><code>sw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/se.svg" width="32" alt="SV"/><br/>스웨덴어<br/><code>sv</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ph.svg" width="32" alt="TL"/><br/>타갈로그어<br/><code>tl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TA"/><br/>타밀어<br/><code>ta</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TE"/><br/>텔루구어<br/><code>te</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/th.svg" width="32" alt="TH"/><br/>태국어<br/><code>th</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tr.svg" width="32" alt="TR"/><br/>튀르키예어<br/><code>tr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ua.svg" width="32" alt="UK"/><br/>우크라이나어<br/><code>uk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pk.svg" width="32" alt="UR"/><br/>우르두어<br/><code>ur</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/uz.svg" width="32" alt="UZ"/><br/>우즈베크어<br/><code>uz</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/vn.svg" width="32" alt="VI"/><br/>베트남어<br/><code>vi</code></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 스크린샷

### 관리자 패널

<p align="center">
  <b>AI 전역 검색 (Ctrl+K)</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-search.png" alt="AI 전역 검색" width="80%"/>
</p>

<table>
  <tr>
    <td width="50%" align="center">
      <b>대시보드</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/dashboard.png" alt="대시보드" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>AI 센터</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-center.png" alt="AI 센터" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>RJBuilder (80개 이상의 위젯)</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/02.png" alt="RJBuilder" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>게시글</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/yeni_post_sehifesi.png" alt="게시글" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>미디어 라이브러리</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/media-library-page.png" alt="미디어 라이브러리" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>KYC 관리</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/kyc-management-page.png" alt="KYC 관리" width="100%"/>
    </td>
  </tr>
</table>

#### 도구

<table>
  <tr>
    <td width="50%" align="center">
      <b>마케팅 포스트 생성기</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/marketin-sehifesi.png" alt="마케팅 포스트 생성기" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>도구 &rarr; 백업</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/backup_page_new.png" alt="도구 - 백업" width="100%"/>
    </td>
  </tr>
</table>

#### 설정

<table>
  <tr>
    <td width="50%" align="center">
      <b>설정 &rarr; AI</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/07.png" alt="설정 - AI" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>설정 &rarr; 색상</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/new-color-page.png" alt="설정 - 색상" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>알림 설정</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/bildiris_ayarlari_sehifesi.png" alt="알림 설정" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>설정 &rarr; 업데이트</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/update-page.png" alt="설정 - 업데이트" width="100%"/>
    </td>
  </tr>
</table>

### 프론트엔드

<table>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front1.png" alt="프론트엔드 1" width="100%"/></td>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front2.png" alt="프론트엔드 2" width="100%"/></td>
  </tr>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front3.png" alt="프론트엔드 3" width="100%"/></td>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front4.png" alt="프론트엔드 4" width="100%"/></td>
  </tr>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front5.png" alt="프론트엔드 5" width="100%"/></td>
    <td width="50%" align="center">
      <b>사용자 계정</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/accout-page.png" alt="사용자 계정" width="100%"/>
    </td>
  </tr>
</table>

### 인증 페이지

<p align="center">
  <b>로그인 및 회원가입</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/01.gif" alt="로그인 및 회원가입" width="100%"/>
</p>

<p align="center">
  <b>비밀번호 재설정</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/02.gif" alt="비밀번호 재설정" width="100%"/>
</p>

<p align="center">
  <b>이메일 인증</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/03.gif" alt="이메일 인증" width="100%"/>
</p>

<p align="center">
  <b>비밀번호 찾기</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/04.gif" alt="비밀번호 찾기" width="100%"/>
</p>

<p align="center">
  <b>비밀번호 확인</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/05.gif" alt="비밀번호 확인" width="100%"/>
</p>

### 오류 페이지

<table>
  <tr>
    <td width="33%" align="center"><b>400 잘못된 요청</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/400-error.png" alt="400" width="100%"/></td>
    <td width="33%" align="center"><b>401 인증 필요</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/12.png" alt="401" width="100%"/></td>
    <td width="33%" align="center"><b>403 접근 금지</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/09.png" alt="403" width="100%"/></td>
  </tr>
  <tr>
    <td width="33%" align="center"><b>404 찾을 수 없음</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/10.png" alt="404" width="100%"/></td>
    <td width="33%" align="center"><b>405 허용되지 않는 요청 메서드</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/11.png" alt="405" width="100%"/></td>
    <td width="33%" align="center"><b>429 요청 한도 초과</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/13.png" alt="429" width="100%"/></td>
  </tr>
</table>

<table>
  <tr>
    <td width="50%" align="center"><b>500 서버 오류 (디버그 모드)</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/500-error-debug.png" alt="500 디버그" width="100%"/></td>
    <td width="50%" align="center"><b>504 게이트웨이 시간 초과</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/504-error.png" alt="504" width="100%"/></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 기술 스택

| 계층 | 기술 |
|-------|------------|
| 백엔드 | Laravel 12, PHP 8.2 |
| 데이터베이스 | MySQL |
| 프론트엔드 | Blade, Tailwind CSS v3, Alpine.js |
| 빌드 도구 | Vite |
| 캐싱 | `laravel-responsecache`, `litespeed/lscache-laravel` |
| AI 엔진 | OpenRouter 및 Free AI Proxy |

## 리소스

| | 리소스 | 설명 |
|:-:|----------|-------------|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [rjnexus.org](https://rjnexus.org) | 공식 웹사이트 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/changelog.svg" width="28" alt=""/> | [변경 내역](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) | RJ CMS 전체 릴리스 기록 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="28" alt=""/> | [RJBuilder 변경 내역](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) | 페이지 빌더 릴리스 기록 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="28" alt=""/> | [테마 및 플러그인](https://github.com/rj-nexus/rj-registration) | 사용 가능한 테마와 플러그인 카탈로그 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/video.svg" width="28" alt=""/> | [설치 영상](https://www.youtube.com/watch?v=BU4UXY2D3FU) | YouTube 단계별 가이드 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="28" alt=""/> | [소스 코드](https://github.com/rj-nexus/rj-nexus) | RJ CMS 코어 저장소 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [토론](https://github.com/orgs/rj-nexus/discussions) | 질문, 제안 및 불만 사항 |

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 커뮤니티 및 지원

질문, 제안 또는 불만 사항이 있으신가요? [GitHub Discussions](https://github.com/orgs/rj-nexus/discussions)에서 대화에 참여하세요.

## 기여하기

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/contribute.svg" width="40" height="40" align="left" alt=""/>

버그 리포트, 기능 아이디어, 풀 리퀘스트를 환영합니다. 큰 변경 작업을 시작하기 전에 이슈를 먼저 열고, 저장소를 포크하고, 기능 브랜치를 만들고, PSR-12를 따른 뒤, 명확한 설명과 함께 풀 리퀘스트를 열어 주세요.

<br clear="left"/>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<div align="center">

제작: **Ruhid Javadov** &nbsp;&bull;&nbsp; MIT 라이선스로 배포됨 &nbsp;&bull;&nbsp; [rjnexus.org](https://rjnexus.org)

</div>