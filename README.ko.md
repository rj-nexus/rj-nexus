<div align="center">

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/banner.svg" alt="RJ Nexus" width="100%"/>

<!-- README-I18N:START -->
[English](./README.md) | [Português](./README.pt.md) | [中文](./README.zh.md) | [Español](./README.es.md) | **한국어** | [日本語](./README.ja.md) | [Русский](./README.ru.md)
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

[웹사이트](https://rjnexus.org) &nbsp;&bull;&nbsp; [변경 로그](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) &nbsp;&bull;&nbsp; [RJBuilder 변경 로그](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) &nbsp;&bull;&nbsp; [테마 및 플러그인](https://rj-nexus.github.io/rj-registration/) &nbsp;&bull;&nbsp; [토론](https://github.com/orgs/rj-nexus/discussions) &nbsp;&bull;&nbsp; [소스 코드](https://github.com/rj-nexus/rj-nexus)

</div>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 소개

**RJ CMS**는 **Laravel 12** 기반으로 구축된 현대적이고 자체 호스팅 가능한 콘텐츠 관리 시스템입니다. 자체 호스팅에 설치하고 데이터에 대한 완전한 소유권을 유지하며, 격리된 플러그인 및 테마 시스템을 통해 확장할 수 있습니다. 80개 이상의 위젯을 갖춘 시각적 페이지 빌더(RJBuilder), 이중 AI 엔진, **51개 언어**(언어별 URL 지원), **2계층 캐싱 시스템**(Response Cache + LiteSpeed LSCache), 그리고 모든 공유 호스팅 또는 VPS에서 작동하는 브라우저 기반 설치 프로그램이 포함되어 있습니다.

**RJ Nexus**는 그 뒤에 있는 조직으로, CMS 코어와 그 주변 생태계를 호스팅합니다.

공식 웹사이트: **[rjnexus.org](https://rjnexus.org)**

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## v1.11.1의 새로운 기능

이번 릴리스는 RJBuilder를 **80개 이상의 위젯**으로 확장하며, 새로운 문화 및 공휴일 달력, 계산기, 연령 확인, 비디오 스토리 캐러셀, Bento 그리드, Markdown 텍스트, 페이지 내 PDF 리더를 추가합니다. 미디어 선택기는 이제 PDF 업로드와 더 많은 파일 형식을 지원하며, 언어 카탈로그는 47개에서 **51개**로 확장되어 **번체 중국어**, **말레이어**, **타밀어**, **덴마크어**가 추가되었습니다. 전체 변경 사항 목록은 [변경 로그](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md)에서 확인할 수 있습니다.

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder &mdash; 80개 이상의 위젯</b><br/>
      <b>문화, 종교 및 공휴일</b>(예배 시간, 안식일 시간, 기독교, 중국 및 힌두 축제), <b>전환 및 계산기</b>(비용 계산기, 제품 비교, 연령 확인 및 연령 선택 게이트), <b>미디어 및 콘텐츠</b>(비디오 스토리 캐러셀, Bento 그리드 쇼케이스, Markdown 텍스트, PDF 리더)를 위한 새로운 위젯. <a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">RJBuilder 변경 로그</a>를 참조하세요.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>4개 신규 언어 &mdash; 총 51개</b><br/>
      <b>번체 중국어</b>(<code>zh_TW</code>), <b>말레이어</b>(<code>ms</code>), <b>타밀어</b>(<code>ta</code>), <b>덴마크어</b>(<code>da</code>)가 이제 핵심 시스템과 설치 프로그램에서 국기와 함께 제공됩니다. 모든 언어 파일에 새로운 번역 키가 추가되었습니다.
    </td>
  </tr>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>미디어 선택기: PDF 및 더 넓은 파일 지원</b><br/>
      이제 미디어 선택기에서 PDF 파일을 직접 업로드할 수 있습니다. 더 많은 비디오, 오디오, 이미지 및 문서 형식을 지원하며, <b>PDF</b> 및 <b>아카이브</b> 필터가 별도로 제공됩니다.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>위젯 등록 수정</b><br/>
      <code>IconBoxWidget</code>, <code>ImageBoxWidget</code> 및 <code>AdvancedSearchWidget</code>이 등록되지 않아 위젯 목록에서 누락되었습니다. 이제 RJBuilder에 표시됩니다.
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 설치

RJ CMS는 단 한 줄의 코드도 수정하지 않고 모든 공유 호스팅 또는 VPS에 설치할 수 있습니다.

1. **업로드.** 최신 ZIP 릴리스를 다운로드하여 웹 서버(예: `public_html`)에 압축 해제합니다.
2. **설치 프로그램 실행.** 브라우저에서 `https://yourdomain.com/install.php`를 엽니다.
3. **단계를 따르세요.** 언어를 선택하고, 서버 요구 사항을 확인하고, 데이터베이스 자격 증명을 입력하고, 관리자 계정을 만듭니다.
4. **데모 데이터.** 설치 프로그램이 기본 페이지, 메뉴, 빌더 템플릿을 가져오므로 사이트가 비어 있지 않습니다.
5. **사이트 보호.** 마법사가 요청하면 `install.php`와 `installer/` 폴더를 삭제합니다.

### 비디오 가이드

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
      Elementor와 유사한 시각적 페이지 빌더로, <b>80개 이상의 사전 제작된 위젯</b>, 드래그 앤 드롭, 반응형 컨트롤, 동적 태그를 제공합니다. <a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">RJBuilder 변경 로그</a>를 참조하세요.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/ai.svg" width="44" height="44" alt=""/><br/>
      <b>AI 통합</b><br/>
      콘텐츠 생성, HTML을 유지하는 대량 번역, 자동 SEO 감사.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/security.svg" width="44" height="44" alt=""/><br/>
      <b>고급 보안</b><br/>
      2단계 인증, 이메일 인증, 속도 제한.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/roles.svg" width="44" height="44" alt=""/><br/>
      <b>역할 및 권한</b><br/>
      모든 관리 섹션에 대한 세분화된 역할 기반 액세스 제어.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>활동 로깅</b><br/>
      관리 패널에서 발생하는 작업을 추적하고 게시물 및 페이지에 대한 수정 사항을 제공합니다.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>다국어 및 RTL</b><br/>
      <b>51개 언어</b>와 언어별 URL, 아랍어, 쿠르드어 및 기타 RTL 언어에 대한 자동 오른쪽에서 왼쪽 렌더링.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>성능 우선</b><br/>
      2계층 페이지 캐싱(Response Cache + LiteSpeed LSCache), WebP 최적화, 지연 로딩, Vite를 통한 빠른 자산 컴파일.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>모듈식 아키텍처</b><br/>
      플러그인과 테마는 자체 라우트, 뷰, 마이그레이션과 함께 완전히 격리됩니다.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="44" height="44" alt=""/><br/>
      <b>테마 및 플러그인</b><br/>
      <a href="https://github.com/rj-nexus/rj-registration">테마 및 플러그인 목록</a>에서 전체 카탈로그를 찾아보세요.
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<a id="caching"></a>

## 라이브 데모

아래 데모에서 RJ Nexus를 사용해 볼 수 있습니다.

> **참고:** 데모 사이트는 현재 최신 버전(v1.11.1)을 실행하지 않을 수 있습니다. RJ Nexus의 모양과 작동 방식을 보여주기 위한 목적으로만 제공됩니다.

| | | |
|:-:|---|---|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/globe.svg" width="20" height="20" alt="" /> | **데모 사이트** | [rj-nexus.onrender.com](https://rj-nexus.onrender.com) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/layers.svg" width="20" height="20" alt="" /> | **관리자 패널** | 데모 URL 끝에 `/admin`을 추가하세요: [rj-nexus.onrender.com/admin](https://rj-nexus.onrender.com/admin) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file-text.svg" width="20" height="20" alt="" /> | **이메일** | `admin@admin.com` |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file.svg" width="20" height="20" alt="" /> | **비밀번호** | `admin123` |

---

## 캐싱

RJ CMS는 내장된 2계층 페이지 캐싱 시스템을 제공하여 실제 트래픽에서도 사이트가 빠르게 유지되며, 적당한 공유 호스팅에서도 마찬가지입니다.

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Response Cache</b><br/>
      <a href="https://github.com/spatie/laravel-responsecache"><code>laravel-responsecache</code></a>로 구동됩니다. 완전한 애플리케이션 응답이 저장되고 반복 요청 시 직접 제공되어 프레임워크 작업의 대부분을 건너뜁니다. 특별한 서버 없이 모든 호스팅에서 작동합니다.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>LiteSpeed 캐시(LSCache)</b><br/>
      <a href="https://github.com/litespeedtech/lscache-laravel"><code>litespeed/lscache-laravel</code></a>로 구동됩니다. LiteSpeed 및 OpenLiteSpeed 호스팅에서 페이지는 웹 서버 수준에서 캐시되며 PHP가 시작되기 전에 제공됩니다.
    </td>
  </tr>
</table>

| | Response Cache | LiteSpeed LSCache |
|---|---|---|
| 패키지 | `laravel-responsecache` | `litespeed/lscache-laravel` |
| 캐시 수준 | 애플리케이션(Laravel) | 웹 서버(LiteSpeed) |
| 호스팅 요구 사항 | 모든 PHP 호스팅 | LiteSpeed / OpenLiteSpeed |
| 최적 용도 | 범용 기본 속도 향상 | LiteSpeed 호스팅에서 최대 속도 |

캐시 동작은 **관리 &rarr; 설정 &rarr; 캐시**에서 관리됩니다.

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 지원 언어

51개 언어가 지원되며, 언어별 URL(예: `/en/about`, `/az/haqqimizda`)이 포함됩니다.

<table>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/et.svg" width="32" alt="AM"/><br/>암하라어<br/><code>am</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/sa.svg" width="32" alt="AR"/><br/>아랍어<br/><code>ar</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/am.svg" width="32" alt="HY"/><br/>아르메니아어<br/><code>hy</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/az.svg" width="32" alt="AZ"/><br/>아제르바이잔어<br/><code>az</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/bd.svg" width="32" alt="BN"/><br/>벵골어<br/><code>bn</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cn.svg" width="32" alt="ZH"/><br/>중국어(간체)<br/><code>zh</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/tw.svg" width="32" alt="ZH-TW"/><br/>중국어(번체) <b>신규</b><br/><code>zh_TW</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cz.svg" width="32" alt="CS"/><br/>체코어<br/><code>cs</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/dk.svg" width="32" alt="DA"/><br/>덴마크어 <b>신규</b><br/><code>da</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nl.svg" width="32" alt="NL"/><br/>네덜란드어<br/><code>nl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gb.svg" width="32" alt="EN"/><br/>영어<br/><code>en</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ee.svg" width="32" alt="ET"/><br/>에스토니아어<br/><code>et</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/fr.svg" width="32" alt="FR"/><br/>프랑스어<br/><code>fr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ge.svg" width="32" alt="KA"/><br/>조지아어<br/><code>ka</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/de.svg" width="32" alt="DE"/><br/>독일어<br/><code>de</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gr.svg" width="32" alt="EL"/><br/>그리스어<br/><code>el</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ht.svg" width="32" alt="HT"/><br/>아이티 크리올어<br/><code>ht</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ng.svg" width="32" alt="HA"/><br/>하우사어<br/><code>ha</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/il.svg" width="32" alt="HE"/><br/>히브리어<br/><code>he</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="HI"/><br/>힌디어<br/><code>hi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/hu.svg" width="32" alt="HU"/><br/>헝가리어<br/><code>hu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/id.svg" width="32" alt="ID"/><br/>인도네시아어<br/><code>id</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/it.svg" width="32" alt="IT"/><br/>이탈리아어<br/><code>it</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/jp.svg" width="32" alt="JA"/><br/>일본어<br/><code>ja</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/kz.svg" width="32" alt="KK"/><br/>카자흐어<br/><code>kk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/rw.svg" width="32" alt="RW"/><br/>키냐르완다어<br/><code>rw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kr.svg" width="32" alt="KO"/><br/>한국어<br/><code>ko</code></td>
    <td align="center" width="16%"><b>KU</b><br/>쿠르드어<br/><code>ku</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kg.svg" width="32" alt="KY"/><br/>키르기스어<br/><code>ky</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/my.svg" width="32" alt="MS"/><br/>말레이어 <b>신규</b><br/><code>ms</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/nz.svg" width="32" alt="MI"/><br/>마오리어<br/><code>mi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="MR"/><br/>마라티어<br/><code>mr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ir.svg" width="32" alt="FA"/><br/>페르시아어<br/><code>fa</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pl.svg" width="32" alt="PL"/><br/>폴란드어<br/><code>pl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pt.svg" width="32" alt="PT"/><br/>포르투갈어<br/><code>pt</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/br.svg" width="32" alt="PT-BR"/><br/>포르투갈어(브라질)<br/><code>pt_BR</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pe.svg" width="32" alt="QU"/><br/>케추아어<br/><code>qu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ro.svg" width="32" alt="RO"/><br/>루마니아어<br/><code>ro</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ru.svg" width="32" alt="RU"/><br/>러시아어<br/><code>ru</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/es.svg" width="32" alt="ES"/><br/>스페인어<br/><code>es</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ke.svg" width="32" alt="SW"/><br/>스와힐리어<br/><code>sw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/se.svg" width="32" alt="SV"/><br/>스웨덴어<br/><code>sv</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ph.svg" width="32" alt="TL"/><br/>타갈로그어<br/><code>tl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TA"/><br/>타밀어 <b>신규</b><br/><code>ta</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TE"/><br/>텔루구어<br/><code>te</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/th.svg" width="32" alt="TH"/><br/>태국어<br/><code>th</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tr.svg" width="32" alt="TR"/><br/>터키어<br/><code>tr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ua.svg" width="32" alt="UK"/><br/>우크라이나어<br/><code>uk</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pk.svg" width="32" alt="UR"/><br/>우르두어<br/><code>ur</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/uz.svg" width="32" alt="UZ"/><br/>우즈베크어<br/><code>uz</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/vn.svg" width="32" alt="VI"/><br/>베트남어<br/><code>vi</code></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 스크린샷

### 관리자 패널

<p align="center">
  <b>AI 글로벌 검색 (Ctrl+K)</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-search.png" alt="AI 글로벌 검색" width="80%"/>
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
      <b>게시물</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/03.png" alt="게시물" width="100%"/>
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
      <b>설정 &rarr; 백업</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/backup-page.png" alt="설정 - 백업" width="100%"/>
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
    <td width="33%" align="center"><b>403 금지됨</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/09.png" alt="403" width="100%"/></td>
  </tr>
  <tr>
    <td width="33%" align="center"><b>404 찾을 수 없음</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/10.png" alt="404" width="100%"/></td>
    <td width="33%" align="center"><b>405 잘못된 요청 방법</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/11.png" alt="405" width="100%"/></td>
    <td width="33%" align="center"><b>429 속도 제한 초과</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/13.png" alt="429" width="100%"/></td>
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
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/changelog.svg" width="28" alt=""/> | [변경 로그](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) | RJ CMS의 전체 릴리스 기록 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="28" alt=""/> | [RJBuilder 변경 로그](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) | 페이지 빌더의 릴리스 기록 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="28" alt=""/> | [테마 및 플러그인](https://github.com/rj-nexus/rj-registration) | 사용 가능한 테마 및 플러그인 카탈로그 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/video.svg" width="28" alt=""/> | [설치 비디오](https://www.youtube.com/watch?v=BU4UXY2D3FU) | YouTube의 단계별 가이드 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="28" alt=""/> | [소스 코드](https://github.com/rj-nexus/rj-nexus) | RJ CMS 코어 저장소 |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [토론](https://github.com/orgs/rj-nexus/discussions) | 질문, 제안 및 불만 |

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## 커뮤니티 및 지원

질문, 제안 또는 불만이 있으신가요? [GitHub Discussions](https://github.com/orgs/rj-nexus/discussions)에서 대화에 참여하세요.

## 기여

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/contribute.svg" width="40" height="40" align="left" alt=""/>

버그 보고, 기능 아이디어 및 풀 리퀘스트를 환영합니다. 큰 변경 작업을 시작하기 전에 이슈를 열고, 저장소를 포크하고, 기능 브랜치를 만들고, PSR-12를 따르고, 명확한 설명과 함께 풀 리퀘스트를 엽니다.

<br clear="left"/>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<div align="center">

**Ruhid Javadov** 제작 &nbsp;&bull;&nbsp; MIT 라이선스로 배포 &nbsp;&bull;&nbsp; [rjnexus.org](https://rjnexus.org)

</div>