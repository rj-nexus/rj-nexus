<div align="center">

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/banner.svg" alt="RJ Nexus" width="100%"/>

<!-- README-I18N:START -->
[English](./README.md) | [Português](./README.pt.md) | [中文](./README.zh.md) | **Español** | [한국어](./README.ko.md) | [日本語](./README.ja.md) | [Русский](./README.ru.md)
<!-- README-I18N:END -->

<br/>

![Status](https://img.shields.io/badge/Status-Stable-brightgreen)
![Release](https://img.shields.io/badge/Release-RJ%20CORE%201-10b981)
![Version](https://img.shields.io/badge/Version-v1.11.2-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.2-purple)
![Languages](https://img.shields.io/badge/Languages-51-orange)
![Cache](https://img.shields.io/badge/Cache-ResponseCache%20%2B%20LSCache-0ea5e9)

<br/>

[Sitio web](https://rjnexus.org) &nbsp;&bull;&nbsp; [Registro de cambios](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) &nbsp;&bull;&nbsp; [Registro de cambios de RJBuilder](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) &nbsp;&bull;&nbsp; [Temas y complementos](https://rj-nexus.github.io/rj-registration/) &nbsp;&bull;&nbsp; [Debates](https://github.com/orgs/rj-nexus/discussions) &nbsp;&bull;&nbsp; [Código fuente](https://github.com/rj-nexus/rj-nexus)

</div>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Acerca de

**RJ CMS** es un sistema de gestión de contenido moderno y autoalojado, construido sobre **Laravel 12**. Lo instalas en tu propio hosting, mantienes la propiedad total de tus datos y lo amplías mediante un sistema aislado de complementos y temas. Incluye un constructor visual de páginas (RJBuilder) con más de 80 widgets, un motor de IA dual, **51 idiomas** con URLs por idioma, un **sistema de caché de dos capas** (Response Cache + LiteSpeed LSCache) y un instalador basado en navegador que funciona en cualquier hosting compartido o VPS.

**RJ Nexus** es la organización detrás de él. Aloja el núcleo del CMS y el ecosistema que lo rodea.

Sitio web oficial: **[rjnexus.org](https://rjnexus.org)**

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Novedades en la v1.11.2

Esta versión amplía RJBuilder a **más de 80 widgets** con nuevos calendarios culturales y de festividades, calculadoras, controles de edad, un carrusel de historias en vídeo, una cuadrícula Bento, texto Markdown y un lector de PDF en la propia página. El selector de medios ahora admite la carga de PDF y muchos más tipos de archivo, y el catálogo de idiomas crece de 47 a **51** con **chino tradicional**, **malayo**, **tamil** y **danés**. La lista completa de cambios está disponible en el [Registro de cambios](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md).

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder &mdash; más de 80 widgets</b><br/>
      Nuevos widgets para <b>cultura, religión y festividades</b> (horarios de oración, horarios de Shabat, festividades cristianas, chinas e hindúes), <b>conversión y calculadoras</b> (calculadora de costes, comparación de productos, controles de verificación de edad y de selección de edad) y <b>medios y contenido</b> (carrusel de historias en vídeo, escaparate de cuadrícula Bento, texto Markdown, lector de PDF). Consulta el <a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">registro de cambios de RJBuilder</a>.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>4 nuevos idiomas &mdash; 51 en total</b><br/>
      <b>Chino tradicional</b> (<code>zh_TW</code>), <b>malayo</b> (<code>ms</code>), <b>tamil</b> (<code>ta</code>) y <b>danés</b> (<code>da</code>) ya están disponibles en el sistema principal y en el instalador, con sus banderas. Se añadieron nuevas claves de traducción a todos los archivos de idioma.
    </td>
  </tr>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>Selector de medios: PDF y mayor compatibilidad de archivos</b><br/>
      Los archivos PDF ahora se pueden subir directamente desde el selector de medios. También admite muchos más formatos de vídeo, audio, imagen y documento, con filtros separados para <b>PDF</b> y <b>Archivo</b>.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>Corrección del registro de widgets</b><br/>
      <code>IconBoxWidget</code>, <code>ImageBoxWidget</code> y <code>AdvancedSearchWidget</code> faltaban en la lista de widgets porque no estaban registrados. Ahora aparecen en RJBuilder.
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Instalación

RJ CMS se instala en cualquier hosting compartido o VPS sin tocar una sola línea de código.

1. **Subida.** Descarga la última versión en ZIP y extráela en tu servidor web (por ejemplo, `public_html`).
2. **Ejecuta el instalador.** Abre `https://yourdomain.com/install.php` en tu navegador.
3. **Sigue los pasos.** Elige un idioma, verifica los requisitos del servidor, introduce las credenciales de la base de datos y crea tu cuenta de administrador.
4. **Datos de demostración.** El instalador importa páginas, menús y plantillas del constructor por defecto, para que tu sitio no empiece vacío.
5. **Protege el sitio.** Elimina `install.php` y la carpeta `installer/` cuando el asistente te lo solicite.

### Guía en vídeo

<a href="https://www.youtube.com/watch?v=BU4UXY2D3FU">
  <img src="https://img.youtube.com/vi/BU4UXY2D3FU/0.jpg" alt="Guía de instalación de RJ CMS" width="480"/>
</a>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Características principales

<table>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder &mdash; más de 80 widgets</b><br/>
      Constructor visual de páginas similar a Elementor con <b>más de 80 widgets listos para usar</b>, arrastrar y soltar, controles adaptables y etiquetas dinámicas. Consulta el <a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">registro de cambios de RJBuilder</a>.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/ai.svg" width="44" height="44" alt=""/><br/>
      <b>Integración con IA</b><br/>
      Generación de contenido, traducción masiva que preserva el HTML y auditorías SEO automáticas.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/security.svg" width="44" height="44" alt=""/><br/>
      <b>Seguridad avanzada</b><br/>
      Autenticación de dos factores, verificación por correo electrónico y limitación de velocidad.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/roles.svg" width="44" height="44" alt=""/><br/>
      <b>Roles y permisos</b><br/>
      Control de acceso detallado basado en roles para cada sección del panel de administración.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>Registro de actividad</b><br/>
      Sigue lo que ocurre en tu panel de administración, con revisiones de entradas y páginas.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>Multilingüe y RTL</b><br/>
      <b>51 idiomas</b> con URLs por idioma y renderizado automático de derecha a izquierda para árabe, kurdo y otros idiomas RTL.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Rendimiento ante todo</b><br/>
      Caché de página en dos capas (Response Cache + LiteSpeed LSCache), optimización WebP, carga diferida y compilación rápida de recursos mediante Vite.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>Arquitectura modular</b><br/>
      Los complementos y temas están totalmente aislados, con sus propias rutas, vistas y migraciones.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="44" height="44" alt=""/><br/>
      <b>Temas y complementos</b><br/>
      Explora el catálogo completo en la <a href="https://github.com/rj-nexus/rj-registration">lista de temas y complementos</a>.
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<a id="caching"></a>

## Demostración en vivo

Puedes probar RJ Nexus en la demostración a continuación.

> **Nota:** Es posible que el sitio de demostración no ejecute la última versión en este momento. Se proporciona solo para darte una idea de cómo se ve y funciona RJ Nexus.

| | | |
|:-:|---|---|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/globe.svg" width="20" height="20" alt="" /> | **Sitio de demostración** | [rj-nexus.onrender.com](https://rj-nexus.onrender.com) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/layers.svg" width="20" height="20" alt="" /> | **Panel de administración** | Añade `/admin` al final de la URL de demostración: [rj-nexus.onrender.com/admin](https://rj-nexus.onrender.com/admin) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file-text.svg" width="20" height="20" alt="" /> | **Correo electrónico** | `admin@admin.com` |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file.svg" width="20" height="20" alt="" /> | **Contraseña** | `admin123` |

---

## Caché

RJ CMS incluye un sistema integrado de caché de página en dos capas, para que tu sitio se mantenga rápido bajo tráfico real, incluso en un hosting compartido modesto.

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Response Cache</b><br/>
      Impulsado por <a href="https://github.com/spatie/laravel-responsecache"><code>laravel-responsecache</code></a>. Las respuestas completas de la aplicación se almacenan y se sirven directamente en solicitudes repetidas, lo que evita la mayor parte del trabajo del framework. Funciona en cualquier hosting, sin necesidad de un servidor especial.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>LiteSpeed Cache (LSCache)</b><br/>
      Impulsado por <a href="https://github.com/litespeedtech/lscache-laravel"><code>litespeed/lscache-laravel</code></a>. En hostings LiteSpeed y OpenLiteSpeed, las páginas se almacenan en caché a nivel del servidor web y se entregan incluso antes de que PHP se inicie.
    </td>
  </tr>
</table>

| | Response Cache | LiteSpeed LSCache |
|---|---|---|
| Paquete | `laravel-responsecache` | `litespeed/lscache-laravel` |
| Nivel de caché | Aplicación (Laravel) | Servidor web (LiteSpeed) |
| Requisito de hosting | Cualquier hosting PHP | LiteSpeed / OpenLiteSpeed |
| Ideal para | Aceleración base universal | Máxima velocidad en hostings LiteSpeed |

El comportamiento de la caché se gestiona en **Admin &rarr; Ajustes &rarr; Caché**.

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Idiomas compatibles

Se admiten 51 idiomas, incluidas URLs por idioma (por ejemplo, `/en/about` y `/az/haqqimizda`).

<table>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/et.svg" width="32" alt="AM"/><br/>Amárico<br/><code>am</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/sa.svg" width="32" alt="AR"/><br/>Árabe<br/><code>ar</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/am.svg" width="32" alt="HY"/><br/>Armenio<br/><code>hy</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/az.svg" width="32" alt="AZ"/><br/>Azerbaiyano<br/><code>az</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/bd.svg" width="32" alt="BN"/><br/>Bengalí<br/><code>bn</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cn.svg" width="32" alt="ZH"/><br/>Chino (simplificado)<br/><code>zh</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/tw.svg" width="32" alt="ZH-TW"/><br/>Chino (tradicional) <b>NUEVO</b><br/><code>zh_TW</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cz.svg" width="32" alt="CS"/><br/>Checo<br/><code>cs</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/dk.svg" width="32" alt="DA"/><br/>Danés <b>NUEVO</b><br/><code>da</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nl.svg" width="32" alt="NL"/><br/>Neerlandés<br/><code>nl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gb.svg" width="32" alt="EN"/><br/>Inglés<br/><code>en</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ee.svg" width="32" alt="ET"/><br/>Estonio<br/><code>et</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/fr.svg" width="32" alt="FR"/><br/>Francés<br/><code>fr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ge.svg" width="32" alt="KA"/><br/>Georgiano<br/><code>ka</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/de.svg" width="32" alt="DE"/><br/>Alemán<br/><code>de</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gr.svg" width="32" alt="EL"/><br/>Griego<br/><code>el</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ht.svg" width="32" alt="HT"/><br/>Criollo haitiano<br/><code>ht</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ng.svg" width="32" alt="HA"/><br/>Hausa<br/><code>ha</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/il.svg" width="32" alt="HE"/><br/>Hebreo<br/><code>he</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="HI"/><br/>Hindi<br/><code>hi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/hu.svg" width="32" alt="HU"/><br/>Húngaro<br/><code>hu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/id.svg" width="32" alt="ID"/><br/>Indonesio<br/><code>id</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/it.svg" width="32" alt="IT"/><br/>Italiano<br/><code>it</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/jp.svg" width="32" alt="JA"/><br/>Japonés<br/><code>ja</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/kz.svg" width="32" alt="KK"/><br/>Kazajo<br/><code>kk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/rw.svg" width="32" alt="RW"/><br/>Kinyarwanda<br/><code>rw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kr.svg" width="32" alt="KO"/><br/>Coreano<br/><code>ko</code></td>
    <td align="center" width="16%"><b>KU</b><br/>Kurdo<br/><code>ku</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kg.svg" width="32" alt="KY"/><br/>Kirguís<br/><code>ky</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/my.svg" width="32" alt="MS"/><br/>Malayo <b>NUEVO</b><br/><code>ms</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/nz.svg" width="32" alt="MI"/><br/>Maorí<br/><code>mi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="MR"/><br/>Maratí<br/><code>mr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ir.svg" width="32" alt="FA"/><br/>Persa<br/><code>fa</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pl.svg" width="32" alt="PL"/><br/>Polaco<br/><code>pl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pt.svg" width="32" alt="PT"/><br/>Portugués<br/><code>pt</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/br.svg" width="32" alt="PT-BR"/><br/>Portugués (Brasil)<br/><code>pt_BR</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pe.svg" width="32" alt="QU"/><br/>Quechua<br/><code>qu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ro.svg" width="32" alt="RO"/><br/>Rumano<br/><code>ro</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ru.svg" width="32" alt="RU"/><br/>Ruso<br/><code>ru</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/es.svg" width="32" alt="ES"/><br/>Español<br/><code>es</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ke.svg" width="32" alt="SW"/><br/>Suajili<br/><code>sw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/se.svg" width="32" alt="SV"/><br/>Sueco<br/><code>sv</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ph.svg" width="32" alt="TL"/><br/>Tagalo<br/><code>tl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TA"/><br/>Tamil <b>NUEVO</b><br/><code>ta</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TE"/><br/>Telugu<br/><code>te</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/th.svg" width="32" alt="TH"/><br/>Tailandés<br/><code>th</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tr.svg" width="32" alt="TR"/><br/>Turco<br/><code>tr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ua.svg" width="32" alt="UK"/><br/>Ucraniano<br/><code>uk</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pk.svg" width="32" alt="UR"/><br/>Urdu<br/><code>ur</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/uz.svg" width="32" alt="UZ"/><br/>Uzbeko<br/><code>uz</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/vn.svg" width="32" alt="VI"/><br/>Vietnamita<br/><code>vi</code></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Capturas de pantalla

### Panel de administración

<p align="center">
  <b>Búsqueda global con IA (Ctrl+K)</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-search.png" alt="Búsqueda global con IA" width="80%"/>
</p>

<table>
  <tr>
    <td width="50%" align="center">
      <b>Panel</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/dashboard.png" alt="Panel" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Centro de IA</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-center.png" alt="Centro de IA" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>RJBuilder (más de 80 widgets)</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/02.png" alt="RJBuilder" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Entradas</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/03.png" alt="Entradas" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>Biblioteca de medios</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/media-library-page.png" alt="Biblioteca de medios" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Gestión de KYC</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/kyc-management-page.png" alt="Gestión de KYC" width="100%"/>
    </td>
  </tr>
</table>

#### Ajustes

<table>
  <tr>
    <td width="50%" align="center">
      <b>Ajustes &rarr; IA</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/07.png" alt="Ajustes - IA" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Ajustes &rarr; Colores</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/new-color-page.png" alt="Ajustes - Colores" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>Ajustes &rarr; Copia de seguridad</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/backup-page.png" alt="Ajustes - Copia de seguridad" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Ajustes &rarr; Actualizaciones</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/update-page.png" alt="Ajustes - Actualizaciones" width="100%"/>
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
      <b>Cuenta de usuario</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/accout-page.png" alt="Cuenta de usuario" width="100%"/>
    </td>
  </tr>
</table>

### Páginas de autenticación

<p align="center">
  <b>Inicio de sesión y registro</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/01.gif" alt="Inicio de sesión y registro" width="100%"/>
</p>

<p align="center">
  <b>Restablecer contraseña</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/02.gif" alt="Restablecer contraseña" width="100%"/>
</p>

<p align="center">
  <b>Verificación de correo electrónico</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/03.gif" alt="Verificación de correo electrónico" width="100%"/>
</p>

<p align="center">
  <b>Contraseña olvidada</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/04.gif" alt="Contraseña olvidada" width="100%"/>
</p>

<p align="center">
  <b>Confirmar contraseña</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/05.gif" alt="Confirmar contraseña" width="100%"/>
</p>

### Páginas de error

<table>
  <tr>
    <td width="33%" align="center"><b>400 Solicitud incorrecta</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/400-error.png" alt="400" width="100%"/></td>
    <td width="33%" align="center"><b>401 Autenticación requerida</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/12.png" alt="401" width="100%"/></td>
    <td width="33%" align="center"><b>403 Prohibido</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/09.png" alt="403" width="100%"/></td>
  </tr>
  <tr>
    <td width="33%" align="center"><b>404 No encontrado</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/10.png" alt="404" width="100%"/></td>
    <td width="33%" align="center"><b>405 Método de solicitud no válido</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/11.png" alt="405" width="100%"/></td>
    <td width="33%" align="center"><b>429 Límite de solicitudes excedido</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/13.png" alt="429" width="100%"/></td>
  </tr>
</table>

<table>
  <tr>
    <td width="50%" align="center"><b>500 Error del servidor (modo de depuración)</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/500-error-debug.png" alt="500 Depuración" width="100%"/></td>
    <td width="50%" align="center"><b>504 Tiempo de espera de la puerta de enlace agotado</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/504-error.png" alt="504" width="100%"/></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Stack tecnológico

| Capa | Tecnología |
|-------|------------|
| Backend | Laravel 12, PHP 8.2 |
| Base de datos | MySQL |
| Frontend | Blade, Tailwind CSS v3, Alpine.js |
| Herramienta de compilación | Vite |
| Caché | `laravel-responsecache`, `litespeed/lscache-laravel` |
| Motor de IA | OpenRouter y Free AI Proxy |

## Recursos

| | Recurso | Descripción |
|:-:|----------|-------------|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [rjnexus.org](https://rjnexus.org) | Sitio web oficial |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/changelog.svg" width="28" alt=""/> | [Registro de cambios](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) | Historial completo de versiones de RJ CMS |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="28" alt=""/> | [Registro de cambios de RJBuilder](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) | Historial de versiones del constructor de páginas |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="28" alt=""/> | [Temas y complementos](https://github.com/rj-nexus/rj-registration) | Catálogo de temas y complementos disponibles |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/video.svg" width="28" alt=""/> | [Vídeo de instalación](https://www.youtube.com/watch?v=BU4UXY2D3FU) | Guía paso a paso en YouTube |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="28" alt=""/> | [Código fuente](https://github.com/rj-nexus/rj-nexus) | Repositorio principal de RJ CMS |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [Debates](https://github.com/orgs/rj-nexus/discussions) | Preguntas, sugerencias y quejas |

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Comunidad y soporte

¿Tienes una pregunta, una sugerencia o una queja? Únete a la conversación en [GitHub Discussions](https://github.com/orgs/rj-nexus/discussions).

## Contribuir

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/contribute.svg" width="40" height="40" align="left" alt=""/>

Los informes de errores, las ideas de nuevas funciones y las pull requests son bienvenidos. Abre una issue antes de empezar a trabajar en un cambio importante, haz un fork del repositorio, crea una rama de función, sigue el estándar PSR-12 y abre una pull request con una descripción clara.

<br clear="left"/>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<div align="center">

Creado por **Ruhid Javadov** &nbsp;&bull;&nbsp; Publicado bajo la Licencia MIT &nbsp;&bull;&nbsp; [rjnexus.org](https://rjnexus.org)

</div>