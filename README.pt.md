<div align="center">

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/banner.svg" alt="RJ Nexus" width="100%"/>

<!-- README-I18N:START -->
[English](./README.md) | **Português** | [中文](./README.zh.md) | [Español](./README.es.md) | [한국어](./README.ko.md) | [日本語](./README.ja.md) | [Русский](./README.ru.md)
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

[Site](https://rjnexus.org) &nbsp;&bull;&nbsp; [Histórico de alterações](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) &nbsp;&bull;&nbsp; [Histórico de alterações do RJBuilder](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) &nbsp;&bull;&nbsp; [Temas e plugins](https://rj-nexus.github.io/rj-registration/) &nbsp;&bull;&nbsp; [Discussões](https://github.com/orgs/rj-nexus/discussions) &nbsp;&bull;&nbsp; [Código-fonte](https://github.com/rj-nexus/rj-nexus)

</div>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Sobre

O **RJ CMS** é um sistema de gerenciamento de conteúdo moderno e auto-hospedado, criado com **Laravel 12**. Você o instala na sua própria hospedagem, mantém a propriedade total dos seus dados e o amplia por meio de um sistema isolado de plugins e temas. Ele inclui um construtor visual de páginas (RJBuilder) com mais de 80 widgets, um **Gerador de postagens de marketing** integrado, um mecanismo de IA duplo, **55 idiomas** com URLs por idioma, um **sistema de cache em duas camadas** (Response Cache + LiteSpeed LSCache) e um instalador no navegador que funciona em qualquer hospedagem compartilhada ou VPS.

A **RJ Nexus** é a organização por trás do projeto. Ela hospeda o núcleo do CMS e o ecossistema ao redor dele.

Site oficial: **[rjnexus.org](https://rjnexus.org)**

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Novidades da v1.12.1

Esta versão traz o **Gerador de postagens de marketing**, um estúdio de design integrado que transforma suas postagens em imagens prontas para compartilhar. Ela também adiciona a **Edição rápida** para postagens e páginas, **notificações do navegador** com mais de 20 sons e quatro novos idiomas, chegando a um total de **55**. A lista completa de alterações está disponível no [Histórico de alterações](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md).

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>Gerador de postagens de marketing</b><br/>
      Escolha uma das suas postagens e crie uma imagem para redes sociais sem sair do painel de administração. Escolha entre <b>8 layouts</b> e <b>8 estilos rápidos</b>, defina seus próprios gradientes ou imagem, adicione seu logotipo e sua marca e exporte em <b>PNG, JPG ou WebP</b>. Receba todos os formatos de redes sociais (1:1, 4:5, 9:16, 16:9, 4:3) em um único <b>ZIP</b>, copie a imagem para a área de transferência ou salve seu design como um modelo reutilizável. Abra-o pelo botão <b>Create Marketing Post</b> na página de postagens.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Edição rápida de postagens e páginas</b><br/>
      Altere o <b>título</b>, o <b>slug</b> e o <b>status</b> direto pela lista. Por exemplo, volte uma postagem publicada para rascunho em um único passo, sem abrir o editor completo.
    </td>
  </tr>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>Notificações do navegador e mais de 20 sons</b><br/>
      Seja avisado no instante em que uma nova notificação chegar, mesmo com a aba de administração em segundo plano. Escolha entre <b>mais de 20 sons de notificação</b> e veja um indicador nos cartões do site quando chegarem novas notificações. As configurações de notificações também ficaram mais leves e simples.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>4 novos idiomas: 55 no total</b><br/>
      O <b>norueguês</b> (<code>no</code>), o <b>finlandês</b> (<code>fi</code>), o <b>búlgaro</b> (<code>bg</code>) e o <b>sérvio</b> (<code>sr</code>) já estão disponíveis. Também foram adicionadas as strings de tradução que faltavam em todos os idiomas.
    </td>
  </tr>
</table>

Também nesta versão: uma nova seção **RJ Apps** na barra lateral, títulos e slugs longos não quebram mais o layout de postagens e páginas, as bandeiras dos idiomas agora aparecem corretamente nas telas de edição e criação de páginas, a bandeira da Dinamarca foi adicionada e as entradas do Registro de atividades voltaram a poder ser excluídas.

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Instalação

O RJ CMS é instalado em qualquer hospedagem compartilhada ou VPS sem que você precise tocar em uma única linha de código.

1. **Envie os arquivos.** Baixe o ZIP da versão mais recente e extraia-o no seu servidor web (por exemplo, `public_html`).
2. **Execute o instalador.** Abra `https://seudominio.com/install.php` no seu navegador.
3. **Siga as etapas.** Escolha um idioma, verifique os requisitos do servidor, informe as credenciais do banco de dados e crie sua conta de administrador.
4. **Dados de demonstração.** O instalador importa páginas, menus e modelos do construtor padrão, para que seu site não comece vazio.
5. **Proteja o site.** Exclua o `install.php` e a pasta `installer/` quando o assistente pedir.

### Guia em vídeo

<a href="https://www.youtube.com/watch?v=BU4UXY2D3FU">
  <img src="https://img.youtube.com/vi/BU4UXY2D3FU/0.jpg" alt="Guia de instalação do RJ CMS" width="480"/>
</a>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Principais recursos

<table>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="44" height="44" alt=""/><br/>
      <b>RJBuilder: mais de 80 widgets</b><br/>
      Construtor visual de páginas no estilo Elementor, com <b>mais de 80 widgets prontos</b>, arrastar e soltar, controles responsivos e tags dinâmicas. Veja o <a href="https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md">histórico de alterações do RJBuilder</a>.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/ai.svg" width="44" height="44" alt=""/><br/>
      <b>Integração com IA</b><br/>
      Geração de conteúdo, tradução em massa que preserva o HTML e auditorias de SEO automáticas.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/security.svg" width="44" height="44" alt=""/><br/>
      <b>Segurança avançada</b><br/>
      Autenticação em duas etapas, verificação de e-mail e limitação de requisições.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/roles.svg" width="44" height="44" alt=""/><br/>
      <b>Funções e permissões</b><br/>
      Controle de acesso detalhado, baseado em funções, para cada seção do painel de administração.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/activity.svg" width="44" height="44" alt=""/><br/>
      <b>Registro de atividades</b><br/>
      Acompanhe o que acontece no seu painel de administração, com revisões para postagens e páginas.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/language.svg" width="44" height="44" alt=""/><br/>
      <b>Multilíngue e RTL</b><br/>
      <b>55 idiomas</b> com URLs por idioma e renderização automática da direita para a esquerda para árabe, curdo e outros idiomas RTL.
    </td>
  </tr>
  <tr>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Desempenho em primeiro lugar</b><br/>
      Cache de páginas em duas camadas (Response Cache + LiteSpeed LSCache), otimização WebP, carregamento sob demanda e compilação rápida de recursos com o Vite.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>Arquitetura modular</b><br/>
      Plugins e temas são totalmente isolados, com suas próprias rotas, views e migrations.
    </td>
    <td width="33%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="44" height="44" alt=""/><br/>
      <b>Temas e plugins</b><br/>
      Explore o catálogo completo na <a href="https://github.com/rj-nexus/rj-registration">lista de temas e plugins</a>.
    </td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<a id="caching"></a>

## Demonstração ao vivo

Você pode experimentar o RJ Nexus na demonstração abaixo.

> **Observação:** O site de demonstração pode não estar executando a versão mais recente neste momento. Ele serve apenas para dar uma ideia da aparência e do funcionamento do RJ Nexus.

| | | |
|:-:|---|---|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/globe.svg" width="20" height="20" alt="" /> | **Site de demonstração** | [rj-nexus.onrender.com](https://rj-nexus.onrender.com) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/layers.svg" width="20" height="20" alt="" /> | **Painel de administração** | Adicione `/admin` ao final da URL da demonstração: [rj-nexus.onrender.com/admin](https://rj-nexus.onrender.com/admin) |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file-text.svg" width="20" height="20" alt="" /> | **E-mail** | `admin@admin.com` |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/update-1.11.1/file.svg" width="20" height="20" alt="" /> | **Senha** | `admin123` |

---

## Cache

O RJ CMS traz um sistema de cache de páginas integrado e em duas camadas, para que seu site continue rápido com tráfego real, mesmo em uma hospedagem compartilhada modesta.

<table>
  <tr>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/performance.svg" width="44" height="44" alt=""/><br/>
      <b>Response Cache</b><br/>
      Desenvolvido com <a href="https://github.com/spatie/laravel-responsecache"><code>laravel-responsecache</code></a>. As respostas completas da aplicação são armazenadas e entregues diretamente nas requisições repetidas, o que evita a maior parte do trabalho do framework. Funciona em qualquer hospedagem, sem exigir um servidor especial.
    </td>
    <td width="50%" valign="top">
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="44" height="44" alt=""/><br/>
      <b>LiteSpeed Cache (LSCache)</b><br/>
      Desenvolvido com <a href="https://github.com/litespeedtech/lscache-laravel"><code>litespeed/lscache-laravel</code></a>. Em hospedagens LiteSpeed e OpenLiteSpeed, as páginas são armazenadas em cache no nível do servidor web e entregues antes mesmo de o PHP ser iniciado.
    </td>
  </tr>
</table>

| | Response Cache | LiteSpeed LSCache |
|---|---|---|
| Pacote | `laravel-responsecache` | `litespeed/lscache-laravel` |
| Nível do cache | Aplicação (Laravel) | Servidor web (LiteSpeed) |
| Requisito de hospedagem | Qualquer hospedagem com PHP | LiteSpeed / OpenLiteSpeed |
| Ideal para | Ganho de velocidade básico e universal | Velocidade máxima em hospedagens LiteSpeed |

O comportamento do cache é gerenciado em **Admin &rarr; Settings &rarr; Cache**.

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Idiomas compatíveis

São 55 idiomas compatíveis, com URLs por idioma (por exemplo, `/en/about` e `/az/haqqimizda`).

<table>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/de.svg" width="32" alt="DE"/><br/>Alemão<br/><code>de</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/et.svg" width="32" alt="AM"/><br/>Amárico<br/><code>am</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/sa.svg" width="32" alt="AR"/><br/>Árabe<br/><code>ar</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/am.svg" width="32" alt="HY"/><br/>Armênio<br/><code>hy</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/az.svg" width="32" alt="AZ"/><br/>Azerbaijano<br/><code>az</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/bd.svg" width="32" alt="BN"/><br/>Bengali<br/><code>bn</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/bg.svg" width="32" alt="BG"/><br/>Búlgaro <b>NOVO</b><br/><code>bg</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kz.svg" width="32" alt="KK"/><br/>Cazaque<br/><code>kk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cz.svg" width="32" alt="CS"/><br/>Checo<br/><code>cs</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/cn.svg" width="32" alt="ZH"/><br/>Chinês (simplificado)<br/><code>zh</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tw.svg" width="32" alt="ZH-TW"/><br/>Chinês (tradicional)<br/><code>zh_TW</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kr.svg" width="32" alt="KO"/><br/>Coreano<br/><code>ko</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ht.svg" width="32" alt="HT"/><br/>Crioulo haitiano<br/><code>ht</code></td>
    <td align="center" width="16%"><b>KU</b><br/>Curdo<br/><code>ku</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/dk.svg" width="32" alt="DA"/><br/>Dinamarquês<br/><code>da</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/es.svg" width="32" alt="ES"/><br/>Espanhol<br/><code>es</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ee.svg" width="32" alt="ET"/><br/>Estoniano<br/><code>et</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/fi.svg" width="32" alt="FI"/><br/>Finlandês <b>NOVO</b><br/><code>fi</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/fr.svg" width="32" alt="FR"/><br/>Francês<br/><code>fr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ge.svg" width="32" alt="KA"/><br/>Georgiano<br/><code>ka</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gr.svg" width="32" alt="EL"/><br/>Grego<br/><code>el</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ng.svg" width="32" alt="HA"/><br/>Hauçá<br/><code>ha</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/il.svg" width="32" alt="HE"/><br/>Hebraico<br/><code>he</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="HI"/><br/>Hindi<br/><code>hi</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/nl.svg" width="32" alt="NL"/><br/>Holandês<br/><code>nl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/hu.svg" width="32" alt="HU"/><br/>Húngaro<br/><code>hu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/id.svg" width="32" alt="ID"/><br/>Indonésio<br/><code>id</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/gb.svg" width="32" alt="EN"/><br/>Inglês<br/><code>en</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/it.svg" width="32" alt="IT"/><br/>Italiano<br/><code>it</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/jp.svg" width="32" alt="JA"/><br/>Japonês<br/><code>ja</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/rw.svg" width="32" alt="RW"/><br/>Kinyarwanda<br/><code>rw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/my.svg" width="32" alt="MS"/><br/>Malaio<br/><code>ms</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/nz.svg" width="32" alt="MI"/><br/>Maori<br/><code>mi</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="MR"/><br/>Marata<br/><code>mr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/no.svg" width="32" alt="NO"/><br/>Norueguês <b>NOVO</b><br/><code>no</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ir.svg" width="32" alt="FA"/><br/>Persa<br/><code>fa</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/pl.svg" width="32" alt="PL"/><br/>Polonês<br/><code>pl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pt.svg" width="32" alt="PT"/><br/>Português<br/><code>pt</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/br.svg" width="32" alt="PT-BR"/><br/>Português (Brasil)<br/><code>pt_BR</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pe.svg" width="32" alt="QU"/><br/>Quéchua<br/><code>qu</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/kg.svg" width="32" alt="KY"/><br/>Quirguiz<br/><code>ky</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ro.svg" width="32" alt="RO"/><br/>Romeno<br/><code>ro</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/ru.svg" width="32" alt="RU"/><br/>Russo<br/><code>ru</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/rs.svg" width="32" alt="SR"/><br/>Sérvio <b>NOVO</b><br/><code>sr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ke.svg" width="32" alt="SW"/><br/>Suaíli<br/><code>sw</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/se.svg" width="32" alt="SV"/><br/>Sueco<br/><code>sv</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ph.svg" width="32" alt="TL"/><br/>Tagalo<br/><code>tl</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/th.svg" width="32" alt="TH"/><br/>Tailandês<br/><code>th</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TA"/><br/>Tâmil<br/><code>ta</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/in.svg" width="32" alt="TE"/><br/>Telugo<br/><code>te</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/tr.svg" width="32" alt="TR"/><br/>Turco<br/><code>tr</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/ua.svg" width="32" alt="UK"/><br/>Ucraniano<br/><code>uk</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/pk.svg" width="32" alt="UR"/><br/>Urdu<br/><code>ur</code></td>
    <td align="center" width="16%"><img src="https://flagcdn.com/uz.svg" width="32" alt="UZ"/><br/>Usbeque<br/><code>uz</code></td>
  </tr>
  <tr>
    <td align="center" width="16%"><img src="https://flagcdn.com/vn.svg" width="32" alt="VI"/><br/>Vietnamita<br/><code>vi</code></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Capturas de tela

### Painel de administração

<p align="center">
  <b>Busca global com IA (Ctrl+K)</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-search.png" alt="Busca global com IA" width="80%"/>
</p>

<table>
  <tr>
    <td width="50%" align="center">
      <b>Painel</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/dashboard.png" alt="Painel" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Central de IA</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/ai-center.png" alt="Central de IA" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>RJBuilder (mais de 80 widgets)</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/02.png" alt="RJBuilder" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Postagens</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/yeni_post_sehifesi.png" alt="Postagens" width="100%"/>
    </td>
  </tr>
  <tr>
    <td width="50%" align="center">
      <b>Biblioteca de mídia</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/media-library-page.png" alt="Biblioteca de mídia" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Gerenciamento de KYC</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/kyc-management-page.png" alt="Gerenciamento de KYC" width="100%"/>
    </td>
  </tr>
</table>

#### Ferramentas

<table>
  <tr>
    <td width="50%" align="center">
      <b>Gerador de postagens de marketing</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/marketin-sehifesi.png" alt="Gerador de postagens de marketing" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Ferramentas &rarr; Backup</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/backup_page_new.png" alt="Ferramentas - Backup" width="100%"/>
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
      <b>Configurações de notificações</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-26-11/bildiris_ayarlari_sehifesi.png" alt="Configurações de notificações" width="100%"/>
    </td>
    <td width="50%" align="center">
      <b>Configurações &rarr; Atualizações</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/update-page.png" alt="Configurações - Atualizações" width="100%"/>
    </td>
  </tr>
</table>

### Front-end

<table>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front1.png" alt="Front-end 1" width="100%"/></td>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front2.png" alt="Front-end 2" width="100%"/></td>
  </tr>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front3.png" alt="Front-end 3" width="100%"/></td>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front4.png" alt="Front-end 4" width="100%"/></td>
  </tr>
  <tr>
    <td width="50%" align="center"><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/front5.png" alt="Front-end 5" width="100%"/></td>
    <td width="50%" align="center">
      <b>Conta do usuário</b><br/><br/>
      <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/accout-page.png" alt="Conta do usuário" width="100%"/>
    </td>
  </tr>
</table>

### Páginas de autenticação

<p align="center">
  <b>Login e cadastro</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/01.gif" alt="Login e cadastro" width="100%"/>
</p>

<p align="center">
  <b>Redefinir senha</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/02.gif" alt="Redefinir senha" width="100%"/>
</p>

<p align="center">
  <b>Verificação de e-mail</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/03.gif" alt="Verificação de e-mail" width="100%"/>
</p>

<p align="center">
  <b>Esqueceu a senha?</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/04.gif" alt="Esqueceu a senha?" width="100%"/>
</p>

<p align="center">
  <b>Confirmar senha</b><br/><br/>
  <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/gif/auth/05.gif" alt="Confirmar senha" width="100%"/>
</p>

### Páginas de erro

<table>
  <tr>
    <td width="33%" align="center"><b>400 Requisição inválida</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/400-error.png" alt="400" width="100%"/></td>
    <td width="33%" align="center"><b>401 Autenticação necessária</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/12.png" alt="401" width="100%"/></td>
    <td width="33%" align="center"><b>403 Proibido</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/09.png" alt="403" width="100%"/></td>
  </tr>
  <tr>
    <td width="33%" align="center"><b>404 Não encontrado</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/10.png" alt="404" width="100%"/></td>
    <td width="33%" align="center"><b>405 Método de requisição inválido</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/11.png" alt="405" width="100%"/></td>
    <td width="33%" align="center"><b>429 Limite de requisições excedido</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screensholt/13.png" alt="429" width="100%"/></td>
  </tr>
</table>

<table>
  <tr>
    <td width="50%" align="center"><b>500 Erro do servidor (modo de depuração)</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot/500-error-debug.png" alt="500 Depuração" width="100%"/></td>
    <td width="50%" align="center"><b>504 Tempo limite do gateway esgotado</b><br/><br/><img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/image/screenshot-19-11/504-error.png" alt="504" width="100%"/></td>
  </tr>
</table>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Tecnologias

| Camada | Tecnologia |
|--------|------------|
| Back-end | Laravel 12, PHP 8.2 |
| Banco de dados | MySQL |
| Front-end | Blade, Tailwind CSS v3, Alpine.js |
| Ferramenta de build | Vite |
| Cache | `laravel-responsecache`, `litespeed/lscache-laravel` |
| Mecanismo de IA | OpenRouter e Free AI Proxy |

## Recursos

| | Recurso | Descrição |
|:-:|---------|-----------|
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [rjnexus.org](https://rjnexus.org) | Site oficial |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/changelog.svg" width="28" alt=""/> | [Histórico de alterações](https://github.com/rj-nexus/rj-nexus/blob/main/CHANGELOG.md) | Histórico completo de versões do RJ CMS |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/builder.svg" width="28" alt=""/> | [Histórico de alterações do RJBuilder](https://github.com/rj-nexus/rj-nexus/blob/main/resources/views/rjbuilder/CHANGELOG.md) | Histórico de versões do construtor de páginas |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/themes.svg" width="28" alt=""/> | [Temas e plugins](https://github.com/rj-nexus/rj-registration) | Catálogo de temas e plugins disponíveis |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/video.svg" width="28" alt=""/> | [Vídeo de instalação](https://www.youtube.com/watch?v=BU4UXY2D3FU) | Guia passo a passo no YouTube |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/modular.svg" width="28" alt=""/> | [Código-fonte](https://github.com/rj-nexus/rj-nexus) | Repositório do núcleo do RJ CMS |
| <img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/website.svg" width="28" alt=""/> | [Discussões](https://github.com/orgs/rj-nexus/discussions) | Perguntas, sugestões e reclamações |

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

## Comunidade e suporte

Tem uma dúvida, uma sugestão ou uma reclamação? Participe da conversa no [GitHub Discussions](https://github.com/orgs/rj-nexus/discussions).

## Como contribuir

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/contribute.svg" width="40" height="40" align="left" alt=""/>

Relatos de bugs, ideias de recursos e pull requests são bem-vindos. Abra uma issue antes de começar a trabalhar em uma mudança grande, faça um fork do repositório, crie uma branch de funcionalidade, siga o PSR-12 e abra um pull request com uma descrição clara.

<br clear="left"/>

<img src="https://raw.githubusercontent.com/rj-nexus/rj-nexus.github.io/main/assets/svg/divider.svg" alt="" width="100%"/>

<div align="center">

Criado por **Ruhid Javadov** &nbsp;&bull;&nbsp; Publicado sob a licença MIT &nbsp;&bull;&nbsp; [rjnexus.org](https://rjnexus.org)

</div>