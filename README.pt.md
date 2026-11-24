<div align="center">

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/banner.svg" alt="RJ Nexus" width="100%"/>

<!-- README-I18N:START -->
[English](./README.md) | **Português** | [中文](./README.zh.md) | [Español](./README.es.md) | [한국어](./README.ko.md) | [日本語](./README.ja.md) | [Русский](./README.ru.md)
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

[Site](https://rjnexus.org) &nbsp;&bull;&nbsp; [Registro de Alterações](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) &nbsp;&bull;&nbsp; [Registro de Alterações do RJBuilder](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) &nbsp;&bull;&nbsp; [Temas e Plugins](https://rj-nexus.github.io/rj-registration/) &nbsp;&bull;&nbsp; [Discussões](https://github.com/orgs/rj-nexus/discussions) &nbsp;&bull;&nbsp; [Código-Fonte](https://github.com/rj-nexus/rj-nexus)

</div>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Sobre

**RJ CMS** é um sistema de gerenciamento de conteúdo moderno e auto-hospedado, construído sobre **Laravel 12**. Você o instala em sua própria hospedagem, mantém a propriedade total dos seus dados e o estende através de um sistema isolado de plugins e temas. Ele vem com um construtor visual de páginas (RJBuilder) com mais de 80 widgets, um motor de IA duplo, **51 idiomas** com URLs por idioma, um **sistema de cache em duas camadas** (Response Cache + LiteSpeed LSCache) e um instalador baseado em navegador que funciona em qualquer hospedagem compartilhada ou VPS.

**RJ Nexus** é a organização por trás dele. Ela hospeda o núcleo do CMS e o ecossistema ao seu redor.

Site oficial: **[rjnexus.org](https://rjnexus.org)**

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Novidades na v1.11.2

Esta versão expande o RJBuilder para **mais de 80 widgets** com novos calendários culturais e de feriados, calculadoras, portões de idade, um carrossel de vídeos stories, uma grade Bento, texto Markdown e um leitor de PDF na página. O seletor de mídia agora suporta upload de PDF e muitos mais tipos de arquivo, e o catálogo de idiomas cresce de 47 para **51** com **Chinês Tradicional**, **Malaio**, **Tâmil** e **Dinamarquês**. A lista completa de alterações está disponível no [Registro de Alterações](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md).

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder &mdash; mais de 80 Widgets</b><br/>
      Novos widgets para <b>cultura, religião e feriados</b> (Horários de Oração, Horários do Shabbat, festivais Cristãos, Chineses e Hindus), <b>conversão e calculadoras</b> (Calculadora de Custos, Comparação de Produtos, Portões de Verificação de Idade e Seleção de Idade) e <b>mídia e conteúdo</b> (Carrossel de Vídeos Stories, Vitrine em Grade Bento, Texto Markdown, Leitor de PDF). Veja o <a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">registro de alterações do RJBuilder</a>.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>4 Novos Idiomas &mdash; 51 no Total</b><br/>
      <b>Chinês Tradicional</b> (<code>zh_TW</code>), <b>Malaio</b> (<code>ms</code>), <b>Tâmil</b> (<code>ta</code>) e <b>Dinamarquês</b> (<code>da</code>) agora estão disponíveis no sistema principal e no instalador, com suas bandeiras. Novas chaves de tradução foram adicionadas a todos os arquivos de idioma.
    </td>
  </tr>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>Seletor de Mídia: PDF e Suporte a Mais Formatos</b><br/>
      Arquivos PDF agora podem ser enviados diretamente pelo seletor de mídia. Ele também suporta muito mais formatos de vídeo, áudio, imagem e documento, com filtros separados para <b>PDF</b> e <b>Arquivo</b>.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>Correção de Registro de Widgets</b><br/>
      <code>IconBoxWidget</code>, <code>ImageBoxWidget</code> e <code>AdvancedSearchWidget</code> estavam ausentes da lista de widgets porque não foram registrados. Agora eles aparecem no RJBuilder.
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Instalação

O RJ CMS instala em qualquer hospedagem compartilhada ou VPS sem precisar tocar em uma única linha de código.

1. **Upload.** Baixe a versão mais recente em ZIP e extraia-a para o seu servidor web (por exemplo, `public_html`).
2. **Execute o instalador.** Abra `https://yourdomain.com/install.php` no seu navegador.
3. **Siga os passos.** Escolha um idioma, verifique os requisitos do servidor, insira as credenciais do banco de dados e crie sua conta de administrador.
4. **Dados de demonstração.** O instalador importa páginas padrão, menus e modelos de construtor, para que seu site não comece vazio.
5. **Proteja o site.** Exclua `install.php` e a pasta `installer/` quando o assistente solicitar.

### Guia em Vídeo

<a href="https://www.youtube.com/watch?v=BU4UXY2D3FU">
  <img src="https://img.youtube.com/vi/BU4UXY2D3FU/0.jpg" alt="Guia de Instalação do RJ CMS" width="480"/>
</a>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Principais Recursos

<table>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder &mdash; mais de 80 Widgets</b><br/>
      Construtor visual de páginas semelhante ao Elementor com <b>mais de 80 widgets prontos</b>, arrastar e soltar, controles responsivos e tags dinâmicas. Veja o <a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">registro de alterações do RJBuilder</a>.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/ai.svg" width="44" height="44" alt=""/><br/>
      <b>Integração com IA</b><br/>
      Geração de conteúdo, tradução em massa que preserva o HTML e auditorias automáticas de SEO.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/security.svg" width="44" height="44" alt=""/><br/>
      <b>Segurança Avançada</b><br/>
      Autenticação de dois fatores, verificação de e-mail e limitação de taxa.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/roles.svg" width="44" height="44" alt=""/><br/>
      <b>Funções e Permissões</b><br/>
      Controle de acesso refinado baseado em funções para cada seção administrativa.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>Registro de Atividades</b><br/>
      Acompanhe o que acontece no seu painel administrativo, com revisões para posts e páginas.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>Multilíngue e RTL</b><br/>
      <b>51 idiomas</b> com URLs por idioma e renderização automática da direita para a esquerda para árabe, curdo e outros idiomas RTL.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Desempenho em Primeiro Lugar</b><br/>
      Cache de página em duas camadas (Response Cache + LiteSpeed LSCache), otimização WebP, carregamento preguiçoso e compilação rápida de assets via Vite.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>Arquitetura Modular</b><br/>
      Plugins e temas são totalmente isolados, com suas próprias rotas, views e migrações.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="44" height="44" alt=""/><br/>
      <b>Temas e Plugins</b><br/>
      Navegue pelo catálogo completo na <a href="https://github.com/rj-nexus/rj-registration">lista de temas e plugins</a>.
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<a id="caching"></a>

## Demonstração ao Vivo

Você pode experimentar o RJ Nexus na demonstração abaixo.

> **Nota:** O site de demonstração pode não estar executando a versão mais recente no momento. Ele é fornecido apenas para dar uma ideia de como o RJ Nexus se parece e funciona.

| | | |
|:-:|---|---|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/globe.svg" width="20" height="20" alt="" /> | **Site de demonstração** | [rj-nexus.onrender.com](https://rj-nexus.onrender.com) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/layers.svg" width="20" height="20" alt="" /> | **Painel administrativo** | Adicione `/admin` ao final da URL de demonstração: [rj-nexus.onrender.com/admin](https://rj-nexus.onrender.com/admin) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file-text.svg" width="20" height="20" alt="" /> | **E-mail** | `admin@admin.com` |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file.svg" width="20" height="20" alt="" /> | **Senha** | `admin123` |

---

## Cache

O RJ CMS vem com um sistema de cache de página em duas camadas integrado, para que seu site permaneça rápido sob tráfego real, mesmo em hospedagem compartilhada modesta.

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Response Cache</b><br/>
      Desenvolvido com <a href="https://github.com/spatie/laravel-responsecache"><code>laravel-responsecache</code></a>. Respostas completas da aplicação são armazenadas e servidas diretamente em requisições repetidas, o que pula a maior parte do trabalho do framework. Funciona em qualquer hospedagem, sem necessidade de servidor especial.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>LiteSpeed Cache (LSCache)</b><br/>
      Desenvolvido com <a href="https://github.com/litespeedtech/lscache-laravel"><code>litespeed/lscache-laravel</code></a>. Em hospedagem LiteSpeed e OpenLiteSpeed, as páginas são cacheadas no nível do servidor web e entregues antes mesmo do PHP ser iniciado.
    </td>
  </tr>
</table>

| | Response Cache | LiteSpeed LSCache |
|---|---|---|
| Pacote | `laravel-responsecache` | `litespeed/lscache-laravel` |
| Nível de cache | Aplicação (Laravel) | Servidor web (LiteSpeed) |
| Requisito de hospedagem | Qualquer hospedagem PHP | LiteSpeed / OpenLiteSpeed |
| Melhor para | Aceleração base universal | Velocidade máxima em hospedagens LiteSpeed |

O comportamento do cache é gerenciado em **Admin &rarr; Configurações &rarr; Cache**.

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Idiomas Suportados

51 idiomas são suportados, incluindo URLs por idioma (por exemplo, `/en/about` e `/az/haqqimizda`).

<table>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/et.svg" width="32" alt="AM"/><br/>Amárico<br/><code>am</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/sa.svg" width="32" alt="AR"/><br/>Árabe<br/><code>ar</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/am.svg" width="32" alt="HY"/><br/>Armênio<br/><code>hy</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/az.svg" width="32" alt="AZ"/><br/>Azerbaijano<br/><code>az</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/bd.svg" width="32" alt="BN"/><br/>Bengali<br/><code>bn</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cn.svg" width="32" alt="ZH"/><br/>Chinês (Simplificado)<br/><code>zh</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/tw.svg" width="32" alt="ZH-TW"/><br/>Chinês (Tradicional) <b>NOVO</b><br/><code>zh_TW</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cz.svg" width="32" alt="CS"/><br/>Tcheco<br/><code>cs</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/dk.svg" width="32" alt="DA"/><br/>Dinamarquês <b>NOVO</b><br/><code>da</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nl.svg" width="32" alt="NL"/><br/>Holandês<br/><code>nl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gb.svg" width="32" alt="EN"/><br/>Inglês<br/><code>en</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ee.svg" width="32" alt="ET"/><br/>Estônio<br/><code>et</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/fr.svg" width="32" alt="FR"/><br/>Francês<br/><code>fr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ge.svg" width="32" alt="KA"/><br/>Georgiano<br/><code>ka</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/de.svg" width="32" alt="DE"/><br/>Alemão<br/><code>de</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gr.svg" width="32" alt="EL"/><br/>Grego<br/><code>el</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ht.svg" width="32" alt="HT"/><br/>Crioulo Haitiano<br/><code>ht</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ng.svg" width="32" alt="HA"/><br/>Hauçá<br/><code>ha</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/il.svg" width="32" alt="HE"/><br/>Hebraico<br/><code>he</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="HI"/><br/>Hindi<br/><code>hi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/hu.svg" width="32" alt="HU"/><br/>Húngaro<br/><code>hu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/id.svg" width="32" alt="ID"/><br/>Indonésio<br/><code>id</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/it.svg" width="32" alt="IT"/><br/>Italiano<br/><code>it</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/jp.svg" width="32" alt="JA"/><br/>Japonês<br/><code>ja</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/kz.svg" width="32" alt="KK"/><br/>Cazaque<br/><code>kk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/rw.svg" width="32" alt="RW"/><br/>Kinyarwanda<br/><code>rw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kr.svg" width="32" alt="KO"/><br/>Coreano<br/><code>ko</code></td>
    <td align="center" width="16%"><b>KU</b><br/>Curdo<br/><code>ku</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kg.svg" width="32" alt="KY"/><br/>Quirguiz<br/><code>ky</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/my.svg" width="32" alt="MS"/><br/>Malaio <b>NOVO</b><br/><code>ms</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/nz.svg" width="32" alt="MI"/><br/>Maori<br/><code>mi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="MR"/><br/>Marata<br/><code>mr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ir.svg" width="32" alt="FA"/><br/>Persa<br/><code>fa</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pl.svg" width="32" alt="PL"/><br/>Polonês<br/><code>pl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pt.svg" width="32" alt="PT"/><br/>Português<br/><code>pt</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/br.svg" width="32" alt="PT-BR"/><br/>Português (Brasil)<br/><code>pt_BR</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pe.svg" width="32" alt="QU"/><br/>Quéchua<br/><code>qu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ro.svg" width="32" alt="RO"/><br/>Romeno<br/><code>ro</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ru.svg" width="32" alt="RU"/><br/>Russo<br/><code>ru</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/es.svg" width="32" alt="ES"/><br/>Espanhol<br/><code>es</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ke.svg" width="32" alt="SW"/><br/>Suaíli<br/><code>sw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/se.svg" width="32" alt="SV"/><br/>Sueco<br/><code>sv</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ph.svg" width="32" alt="TL"/><br/>Tagalo<br/><code>tl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TA"/><br/>Tâmil <b>NOVO</b><br/><code>ta</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TE"/><br/>Télugo<br/><code>te</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/th.svg" width="32" alt="TH"/><br/>Tailandês<br/><code>th</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tr.svg" width="32" alt="TR"/><br/>Turco<br/><code>tr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ua.svg" width="32" alt="UK"/><br/>Ucraniano<br/><code>uk</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pk.svg" width="32" alt="UR"/><br/>Urdu<br/><code>ur</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/uz.svg" width="32" alt="UZ"/><br/>Uzbeque<br/><code>uz</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/vn.svg" width="32" alt="VI"/><br/>Vietnamita<br/><code>vi</code></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Capturas de Tela

### Painel Administrativo

<p align="center">
  <b>Busca Global com IA (Ctrl+K)</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-search.png" alt="Busca Global com IA" width="80%"/>
</p>

<table>
  <tr>
    <td width="50%" align="center">
      <b>Dashboard</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/dashboard.png" alt="Dashboard" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Central de IA</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-center.png" alt="Central de IA" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>RJBuilder (mais de 80 Widgets)</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/02.png" alt="RJBuilder" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Posts</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/03.png" alt="Posts" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>Biblioteca de Mídia</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/media-library-page.png" alt="Biblioteca de Mídia" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Gerenciamento de KYC</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/kyc-management-page.png" alt="Gerenciamento de KYC" width="100%"/>
    </td>
  </tr>
</table>

#### Configurações

<table>
  <tr>
    <td width="50%" align="center">
      <b>Configurações &rarr; IA</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/07.png" alt="Configurações - IA" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Configurações &rarr; Cores</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/new-color-page.png" alt="Configurações - Cores" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>Configurações &rarr; Backup</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/backup-page.png" alt="Configurações - Backup" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Configurações &rarr; Atualizações</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/update-page.png" alt="Configurações - Atualizações" width="100%"/>
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
      <b>Conta do Usuário</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/accout-page.png" alt="Conta do Usuário" width="100%"/>
    </td>
  </tr>
</table>

### Páginas de Autenticação

<p align="center">
  <b>Login e Registro</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/01.gif" alt="Login e Registro" width="100%"/>
</p>

<p align="center">
  <b>Redefinir Senha</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/02.gif" alt="Redefinir Senha" width="100%"/>
</p>

<p align="center">
  <b>Verificação de E-mail</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/03.gif" alt="Verificação de E-mail" width="100%"/>
</p>

<p align="center">
  <b>Esqueci a Senha</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/04.gif" alt="Esqueci a Senha" width="100%"/>
</p>

<p align="center">
  <b>Confirmar Senha</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/05.gif" alt="Confirmar Senha" width="100%"/>
</p>

### Páginas de Erro

<table>
  <tr>
    <td width="33%" align="center"><b>400 Solicitação Inválida</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/400-error.png" alt="400" width="100%"/></td>
    <td width="33%" align="center"><b>401 Autenticação Necessária</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/12.png" alt="401" width="100%"/></td>
    <td width="33%" align="center"><b>403 Proibido</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/09.png" alt="403" width="100%"/></td>
  </tr>
  <tr>
    <td width="33%" align="center"><b>404 Não Encontrado</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/10.png" alt="404" width="100%"/></td>
    <td width="33%" align="center"><b>405 Método de Solicitação Inválido</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/11.png" alt="405" width="100%"/></td>
    <td width="33%" align="center"><b>429 Limite de Taxa Excedido</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/13.png" alt="429" width="100%"/></td>
  </tr>
</table>

<table>
  <tr>
    <td width="50%" align="center"><b>500 Erro do Servidor (Modo de Depuração)</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/500-error-debug.png" alt="500 Depuração" width="100%"/></td>
    <td width="50%" align="center"><b>504 Tempo Limite do Gateway</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/504-error.png" alt="504" width="100%"/></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Stack Tecnológico

| Camada | Tecnologia |
|-------|------------|
| Backend | Laravel 12, PHP 8.2 |
| Banco de dados | MySQL |
| Frontend | Blade, Tailwind CSS v3, Alpine.js |
| Ferramenta de build | Vite |
| Cache | `laravel-responsecache`, `litespeed/lscache-laravel` |
| Motor de IA | OpenRouter e Free AI Proxy |

## Recursos

| | Recurso | Descrição |
|:-:|----------|-------------|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [rjnexus.org](https://rjnexus.org) | Site oficial |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/changelog.svg" width="28" alt=""/> | [Registro de Alterações](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) | Histórico completo de lançamentos do RJ CMS |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="28" alt=""/> | [Registro de Alterações do RJBuilder](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) | Histórico de lançamentos do construtor de páginas |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="28" alt=""/> | [Temas e Plugins](https://github.com/rj-nexus/rj-registration) | Catálogo de temas e plugins disponíveis |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/video.svg" width="28" alt=""/> | [Vídeo de Instalação](https://www.youtube.com/watch?v=BU4UXY2D3FU) | Guia passo a passo no YouTube |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="28" alt=""/> | [Código-Fonte](https://github.com/rj-nexus/rj-nexus) | Repositório principal do RJ CMS |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [Discussões](https://github.com/orgs/rj-nexus/discussions) | Perguntas, sugestões e reclamações |

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Comunidade e Suporte

Tem uma pergunta, uma sugestão ou uma reclamação? Junte-se à conversa em [GitHub Discussions](https://github.com/orgs/rj-nexus/discussions).

## Contribuindo

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/contribute.svg" width="40" height="40" align="left" alt=""/>

Relatórios de bugs, ideias de recursos e pull requests são bem-vindos. Abra uma issue antes de começar a trabalhar em uma grande mudança, faça um fork do repositório, crie uma branch de recurso, siga o PSR-12 e abra um pull request com uma descrição clara.

<br clear="left"/>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<div align="center">

Criado por **Ruhid Javadov** &nbsp;&bull;&nbsp; Lançado sob a Licença MIT &nbsp;&bull;&nbsp; [rjnexus.org](https://rjnexus.org)

</div>