<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ rj_dir() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('Dashboard')) - {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
    <style>
        :root { {!! rj_css_variables() !!} }

        [x-cloak] { display: none !important; }

        @property --rj-a {
            syntax: '<angle>';
            inherits: false;
            initial-value: 0deg;
        }

        .rj-sb {
            position: relative;
            isolation: isolate;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            height: 38px;
            padding: 0 10px 0 11px;
            border: 0;
            border-radius: 999px;
            background: transparent;
            color: #64748b;
            font-family: inherit;
            font-size: 13px;
            font-weight: 500;
            line-height: 1;
            cursor: pointer;
            transition: transform .15s ease, box-shadow .25s ease;
            -webkit-tap-highlight-color: transparent;
        }
        .rj-sb::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -2;
            border-radius: inherit;
            background: conic-gradient(from var(--rj-a), #8b5cf6, #ec4899, #f59e0b, #22d3ee, #8b5cf6);
            animation: rj-ang 4s linear infinite;
        }
        .rj-sb::after {
            content: "";
            position: absolute;
            inset: 1.5px;
            z-index: -1;
            border-radius: inherit;
            background: #fff;
        }
        .rj-sb:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 24px -10px rgba(139, 92, 246, .6);
            color: #334155;
        }
        .rj-sb:active { transform: scale(.96); }
        .rj-sb-ic { display: grid; place-items: center; color: #8b5cf6; }
        .rj-sb-ic svg { width: 17px; height: 17px; animation: rj-spark 2.4s ease-in-out infinite; }
        .rj-sb-t {
            display: inline-block;
            min-width: 170px;
            text-align: start;
            white-space: nowrap;
            opacity: 0;
            transform: translateY(5px);
            transition: opacity .25s ease, transform .25s ease;
        }
        .rj-sb-t.is-on { opacity: 1; transform: none; }
        .rj-sb kbd {
            padding: 3px 6px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            background: #f1f5f9;
            color: #94a3b8;
            font-family: ui-sans-serif, system-ui, sans-serif;
            font-size: 10px;
            font-weight: 600;
            line-height: 1;
        }

        .rj-sm {
            position: fixed;
            inset: 0;
            z-index: 100;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 10vh 16px 16px;
        }
        .rj-sm-back {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, .45);
            -webkit-backdrop-filter: blur(8px);
            backdrop-filter: blur(8px);
        }
        .rj-sm-box {
            position: relative;
            isolation: isolate;
            width: 100%;
            max-width: 680px;
        }
        .rj-sm-box::before,
        .rj-sm-box::after {
            content: "";
            position: absolute;
            border-radius: 22px;
            background: conic-gradient(from var(--rj-a), #8b5cf6, #ec4899, #f59e0b, #22d3ee, #8b5cf6);
            animation: rj-ang 5s linear infinite;
        }
        .rj-sm-box::before { inset: -2px; z-index: -2; filter: blur(16px); opacity: .5; }
        .rj-sm-box::after { inset: -1.5px; z-index: -1; opacity: .9; }
        .rj-sm-in {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 30px 70px -20px rgba(15, 23, 42, .5);
        }
        .rj-sm-load {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 2;
            height: 3px;
            overflow: hidden;
            opacity: 0;
            transition: opacity .2s;
        }
        .rj-sm-load.is-on { opacity: 1; }
        .rj-sm-load i {
            display: block;
            width: 40%;
            height: 100%;
            background: linear-gradient(90deg, transparent, #8b5cf6, #ec4899, transparent);
            animation: rj-ld 1s ease-in-out infinite;
        }
        .rj-sm-head {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 18px;
            border-bottom: 1px solid #f1f5f9;
        }
        .rj-sm-head > svg { flex-shrink: 0; width: 22px; height: 22px; color: #8b5cf6; }
        .rj-sm-input {
            flex: 1;
            min-width: 0;
            padding: 0 !important;
            border: 0 !important;
            outline: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
            color: #0f172a;
            font-size: 17px;
        }
        .rj-sm-input::placeholder { color: #94a3b8; }
        .rj-sm-x, .rj-sm-esc {
            flex-shrink: 0;
            padding: 4px 8px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
            color: #94a3b8;
            font-family: inherit;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: color .15s, border-color .15s;
        }
        .rj-sm-x:hover, .rj-sm-esc:hover { color: #475569; border-color: #cbd5e1; }
        .rj-sm-x { display: grid; place-items: center; width: 26px; height: 26px; padding: 0; border-radius: 50%; }
        .rj-sm-x svg { width: 12px; height: 12px; }
        .rj-sm-esc-m { display: none; }

        .rj-sm-list {
            max-height: min(60vh, 460px);
            padding: 8px;
            overflow-y: auto;
            overscroll-behavior: contain;
        }
        .rj-sm-gh {
            padding: 10px 12px 6px;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }
        .rj-sm-it {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 12px;
            color: #0f172a;
            text-decoration: none;
            opacity: 0;
            animation: rj-it .32s cubic-bezier(.16, 1, .3, 1) forwards;
            animation-delay: calc(min(var(--i), 8) * 26ms);
            transition: background .12s;
        }
        .rj-sm-it.is-active { background: linear-gradient(90deg, rgba(139, 92, 246, .11), rgba(236, 72, 153, .05)); }
        .rj-sm-it.is-active::before {
            content: "";
            position: absolute;
            inset-inline-start: 0;
            top: 20%;
            bottom: 20%;
            width: 3px;
            border-radius: 3px;
            background: linear-gradient(#8b5cf6, #ec4899);
        }
        .rj-sm-ic {
            display: grid;
            place-items: center;
            flex: 0 0 38px;
            height: 38px;
            border: 1px solid #eef2f7;
            border-radius: 10px;
            background: #f8fafc;
            color: #94a3b8;
            transition: transform .2s cubic-bezier(.34, 1.56, .64, 1), background .15s, color .15s, border-color .15s;
        }
        .rj-sm-it.is-active .rj-sm-ic { border-color: #ddd6fe; background: #f5f3ff; color: #7c3aed; transform: scale(1.08) rotate(-4deg); }
        .rj-sm-it.is-ai .rj-sm-ic { border-color: transparent; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: #fff; }
        .rj-sm-it.is-ai .rj-sm-ic svg { animation: rj-spark 2s ease-in-out infinite; }
        .rj-sm-tx { flex: 1; min-width: 0; }
        .rj-sm-tx b {
            display: block;
            overflow: hidden;
            font-size: 14px;
            font-weight: 600;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .rj-sm-tx small {
            display: block;
            overflow: hidden;
            color: #64748b;
            font-size: 12px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .rj-sm mark { padding: 0 1px; border-radius: 3px; background: rgba(250, 204, 21, .4); color: inherit; }
        .rj-sm-url {
            max-width: 180px;
            overflow: hidden;
            color: #94a3b8;
            font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
            font-size: 11px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .rj-sm-go {
            flex-shrink: 0;
            width: 18px;
            height: 18px;
            color: #8b5cf6;
            opacity: 0;
            transform: translateX(-4px);
            transition: opacity .15s, transform .15s;
        }
        .rj-sm-it.is-active .rj-sm-go { opacity: 1; transform: none; }
        .rj-sm-empty { padding: 30px 16px 18px; color: #64748b; font-size: 14px; text-align: center; }
        .rj-sm-empty svg { display: block; width: 38px; height: 38px; margin: 0 auto 10px; color: #cbd5e1; animation: rj-float 3s ease-in-out infinite; }
        .rj-sm-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 16px;
            border-top: 1px solid #f1f5f9;
            background: #f8fafc;
            color: #64748b;
            font-size: 11.5px;
        }
        .rj-sm-keys { display: flex; align-items: center; gap: 12px; }
        .rj-sm-keys span { display: inline-flex; align-items: center; gap: 5px; }
        .rj-sm-foot kbd {
            padding: 2px 6px;
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            background: #fff;
            color: #64748b;
            font-family: ui-sans-serif, system-ui, sans-serif;
            font-size: 10px;
            font-weight: 600;
        }
        .rj-sm-pw { display: inline-flex; align-items: center; gap: 6px; }
        .rj-sm-pw svg { width: 13px; height: 13px; color: #8b5cf6; }

        .rj-o-e { transition: opacity .22s ease; }
        .rj-o-l { transition: opacity .16s ease; }
        .rj-o-0 { opacity: 0; }
        .rj-o-1 { opacity: 1; }
        .rj-b-e { transition: opacity .28s ease, transform .4s cubic-bezier(.34, 1.56, .64, 1); }
        .rj-b-l { transition: opacity .16s ease, transform .16s ease; }
        .rj-b-0 { opacity: 0; transform: translateY(-18px) scale(.94); }
        .rj-b-1 { opacity: 1; transform: none; }

        @media (max-width: 1023px) {
            .rj-sb kbd { display: none; }
            .rj-sb-t { min-width: 0; max-width: 130px; overflow: hidden; text-overflow: ellipsis; }
        }
        @media (max-width: 767px) {
            .rj-sb { width: 38px; padding: 0; gap: 0; justify-content: center; }
            .rj-sb-t, .rj-sb kbd { display: none; }
            .rj-sm { padding: 0; }
            .rj-sm-box { max-width: none; }
            .rj-sm-box::before, .rj-sm-box::after { border-radius: 0 0 22px 22px; }
            .rj-sm-in { border-radius: 0 0 20px 20px; }
            .rj-sm-head { padding: 14px; }
            .rj-sm-input { font-size: 16px; }
            .rj-sm-esc { display: none; }
            .rj-sm-esc-m { display: grid; }
            .rj-sm-list { max-height: calc(100vh - 190px); max-height: calc(100dvh - 190px); padding: 6px; }
            .rj-sm-url { display: none; }
            .rj-sm-keys { display: none; }
            .rj-sm-foot { justify-content: center; }
        }
        @media (prefers-reduced-motion: reduce) {
            .rj-sb::before, .rj-sm-box::before, .rj-sm-box::after, .rj-sb-ic svg, .rj-sm-it, .rj-sm-load i, .rj-sm-empty svg { animation: none !important; }
            .rj-sm-it { opacity: 1; }
        }

        @keyframes rj-ang { to { --rj-a: 360deg; } }
        @keyframes rj-spark { 0%, 100% { transform: scale(1) rotate(0); } 50% { transform: scale(1.18) rotate(14deg); } }
        @keyframes rj-ld { from { transform: translateX(-100%); } to { transform: translateX(260%); } }
        @keyframes rj-it { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }
        @keyframes rj-float { 50% { transform: translateY(-5px); } }
    </style>
</head>
<body class="font-sans bg-gray-50 text-gray-900 antialiased">
    @php
        $ic = fn (string $paths) => '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">' . $paths . '</svg>';
        $p = fn (string $d) => '<path stroke-linecap="round" stroke-linejoin="round" d="' . $d . '"/>';

        $coreTop = [
            [
                'label' => __('Dashboard'),
                'icon' => $ic($p('M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10')),
                'url' => route('admin.dashboard'),
                'active' => request()->routeIs('admin.dashboard'),
                'children' => [],
            ],
            [
                'label' => __('Posts'),
                'icon' => $ic($p('M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2z') . $p('M14 4v6h6M8 13h8M8 17h5')),
                'active' => request()->routeIs('admin.posts.*'),
                'children' => [
                    ['label' => __('All Posts'), 'url' => route('admin.posts.index'), 'route' => 'admin.posts.index'],
                    ['label' => __('Add New'), 'url' => route('admin.posts.create'), 'route' => 'admin.posts.create'],
                    ['label' => __('Categories'), 'url' => route('admin.posts.categories'), 'route' => 'admin.posts.categories'],
                    ['label' => __('Tags'), 'url' => route('admin.posts.tags'), 'route' => 'admin.posts.tags'],
                ],
            ],
            [
                'label' => __('Pages'),
                'icon' => $ic($p('M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z')),
                'active' => request()->routeIs('admin.pages.*'),
                'children' => [
                    ['label' => __('All Pages'), 'url' => route('admin.pages.index'), 'route' => 'admin.pages.index'],
                    ['label' => __('Add New'), 'url' => route('admin.pages.create'), 'route' => 'admin.pages.create'],
                ],
            ],
            [
                'label' => __('Media'),
                'icon' => $ic($p('M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2zm6-10a1 1 0 11-2 0 1 1 0 012 0z')),
                'active' => request()->routeIs('admin.media.*'),
                'children' => [
                    ['label' => __('Library'), 'url' => route('admin.media.index'), 'route' => 'admin.media.index'],
                    ['label' => __('Add New'), 'url' => route('admin.media.create'), 'route' => 'admin.media.create'],
                ],
            ],
            [
                'label' => __('Comments'),
                'icon' => $ic($p('M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z')),
                'active' => request()->routeIs('admin.comments.*'),
                'children' => [
                    ['label' => __('All'), 'url' => route('admin.comments.index'), 'route' => 'admin.comments.index'],
                    ['label' => __('Pending'), 'url' => route('admin.comments.pending'), 'route' => 'admin.comments.pending'],
                    ['label' => __('Approved'), 'url' => route('admin.comments.approved'), 'route' => 'admin.comments.approved'],
                    ['label' => __('Spam'), 'url' => route('admin.comments.spam'), 'route' => 'admin.comments.spam'],
                    ['label' => __('Trash'), 'url' => route('admin.comments.trash'), 'route' => 'admin.comments.trash'],
                ],
            ],
            [
                'label' => __('Appearance'),
                'icon' => $ic($p('M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01')),
                'active' => request()->routeIs('admin.appearance.*'),
                'children' => [
                    ['label' => __('Themes'), 'url' => route('admin.appearance.themes'), 'route' => 'admin.appearance.themes'],
                    ['label' => __('Customize'), 'url' => route('admin.appearance.customize'), 'route' => 'admin.appearance.customize'],
                    ['label' => __('Widgets'), 'url' => route('admin.appearance.widgets'), 'route' => 'admin.appearance.widgets'],
                    ['label' => __('Menus'), 'url' => route('admin.appearance.menus'), 'route' => 'admin.appearance.menus'],
                    ['label' => __('Theme Editor'), 'url' => route('admin.appearance.editor'), 'route' => 'admin.appearance.editor'],
                    ['label' => __('Colors'), 'url' => route('admin.appearance.colors'), 'route' => 'admin.appearance.colors'],
                    ['label' => __('Options'), 'url' => route('admin.appearance.options'), 'route' => 'admin.appearance.options'],
                ],
            ],
            [
                'label' => __('Plugins'),
                'icon' => $ic($p('M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z')),
                'active' => request()->routeIs('admin.plugins.*'),
                'children' => [
                    ['label' => __('Installed'), 'url' => route('admin.plugins.index'), 'route' => 'admin.plugins.index'],
                    ['label' => __('Add New'), 'url' => route('admin.plugins.create'), 'route' => 'admin.plugins.create'],
                    ['label' => __('Editor'), 'url' => route('admin.plugins.editor'), 'route' => 'admin.plugins.editor'],
                ],
            ],
            [
                'label' => __('AI Center'),
                'icon' => $ic($p('M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z')),
                'active' => request()->routeIs('admin.ai.*'),
                'children' => [
                    ['label' => __('Overview'), 'url' => route('admin.ai.index'), 'route' => 'admin.ai.index'],
                    ['label' => __('Models'), 'url' => route('admin.ai.models'), 'route' => 'admin.ai.models'],
                    ['label' => __('Prompts'), 'url' => route('admin.ai.prompts'), 'route' => 'admin.ai.prompts'],
                    ['label' => __('Usage'), 'url' => route('admin.ai.usage'), 'route' => 'admin.ai.usage'],
                    ['label' => __('Tools'), 'url' => route('admin.ai.tools'), 'route' => 'admin.ai.tools'],
                ],
            ],
            [
                'label' => __('RJBuilder'),
                'icon' => $ic($p('M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z')),
                'url' => route('admin.rjbuilder.index'),
                'active' => request()->routeIs('admin.rjbuilder.*'),
                'children' => [],
            ],
        ];

        $pluginMenuItems = rj_apply_filters('admin.menu', []) ?? [];
        if (!is_array($pluginMenuItems)) {
            $pluginMenuItems = [];
        }
        usort($pluginMenuItems, fn($a, $b) => ($a['position'] ?? 100) <=> ($b['position'] ?? 100));
        $pluginMenuRoots = array_filter($pluginMenuItems, fn($i) => empty($i['parent']));
        $pluginMenuChildren = array_filter($pluginMenuItems, fn($i) => !empty($i['parent']));

        $defaultPluginIcon = $ic($p('M4 6h16M4 12h16M4 18h7'));
        $resolveUrl = fn($i) => isset($i['route']) && Route::has($i['route']) ? route($i['route']) : ($i['url'] ?? '#');

        $pluginNav = [];
        foreach ($pluginMenuRoots as $item) {
            $itemChildren = array_filter($pluginMenuChildren, fn($c) => ($c['parent'] ?? '') === ($item['id'] ?? ''));
            $children = [];
            foreach ($itemChildren as $child) {
                $children[] = [
                    'label' => $child['title'] ?? '',
                    'url' => $resolveUrl($child),
                    'route' => $child['route'] ?? null,
                ];
            }
            $pluginNav[] = [
                'label' => $item['title'] ?? '',
                'icon' => !empty($item['icon_svg']) ? $item['icon_svg'] : $defaultPluginIcon,
                'url' => $resolveUrl($item),
                'active' => isset($item['route']) && request()->routeIs($item['route'] . '*'),
                'children' => $children,
            ];
        }

        $coreBottom = [
            [
                'label' => __('Users'),
                'icon' => $ic($p('M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z')),
                'url' => route('admin.users.index'),
                'active' => request()->routeIs('admin.users.*'),
                'children' => [],
            ],
            [
                'label' => __('Newsletter'),
                'icon' => $ic($p('M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z')),
                'url' => route('admin.newsletter.index'),
                'active' => request()->routeIs('admin.newsletter.*'),
                'children' => [],
            ],
            [
                'label' => __('KYC Verification'),
                'icon' => $ic($p('M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z')),
                'url' => route('admin.kyc.index'),
                'active' => request()->routeIs('admin.kyc.*'),
                'children' => [],
            ],
            [
                'label' => __('Support'),
                'icon' => $ic($p('M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.656l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z')),
                'active' => request()->routeIs('admin.support.*'),
                'children' => [
                    ['label' => __('Tickets'), 'url' => route('admin.support.index'), 'route' => 'admin.support.index'],
                    ['label' => __('Live Chat'), 'url' => route('admin.support.chat'), 'route' => 'admin.support.chat'],
                    ['label' => __('FAQ'), 'url' => route('admin.support.faq'), 'route' => 'admin.support.faq'],
                    ['label' => __('Contact'), 'url' => route('admin.support.contact'), 'route' => 'admin.support.contact'],
                    ['label' => __('Documentation'), 'url' => route('admin.support.docs'), 'route' => 'admin.support.docs'],
                    ['label' => __('System Status'), 'url' => route('admin.support.status'), 'route' => 'admin.support.status'],
                ],
            ],
            [
                'label' => __('Tools'),
                'icon' => $ic($p('M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z') . $p('M15 12a3 3 0 11-6 0 3 3 0 016 0z')),
                'active' => request()->routeIs('admin.tools.*'),
                'children' => [
                    ['label' => __('Import'), 'url' => route('admin.tools.import'), 'route' => 'admin.tools.import'],
                    ['label' => __('Export'), 'url' => route('admin.tools.export'), 'route' => 'admin.tools.export'],
                    ['label' => __('Site Health'), 'url' => route('admin.tools.health'), 'route' => 'admin.tools.health'],
                    ['label' => __('Backup'), 'url' => route('admin.tools.backup'), 'route' => 'admin.tools.backup'],
                    ['label' => __('Logs'), 'url' => route('admin.tools.logs'), 'route' => 'admin.tools.logs'],
                    ['label' => __('AI Diagnostics'), 'url' => route('admin.tools.diagnostics'), 'route' => 'admin.tools.diagnostics'],
                ],
            ],
            [
                'label' => __('Updates'),
                'icon' => $ic($p('M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15')),
                'url' => route('admin.updates.index'),
                'active' => request()->routeIs('admin.updates.*'),
                'children' => [],
            ],
            [
                'label' => __('RJ Services'),
                'icon' => $ic($p('M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z')),
                'url' => route('admin.services.index'),
                'active' => request()->routeIs('admin.services.*'),
                'children' => [],
            ],
            [
                'label' => __('Settings'),
                'icon' => $ic($p('M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4')),
                'url' => route('admin.settings.index'),
                'active' => request()->routeIs('admin.settings.*'),
                'children' => [],
            ],
            [
                'label' => __('RJ About'),
                'icon' => $ic($p('M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z')),
                'active' => request()->routeIs('admin.about.*'),
                'children' => [
                    ['label' => __('Info'), 'url' => route('admin.about.index'), 'route' => 'admin.about.index'],
                    ['label' => __('API Document'), 'url' => route('admin.about.api'), 'route' => 'admin.about.api'],
                    ['label' => __('Theme Document'), 'url' => route('admin.about.theme'), 'route' => 'admin.about.theme'],
                    ['label' => __('Admin Document'), 'url' => route('admin.about.admin'), 'route' => 'admin.about.admin'],
                    ['label' => __('Plugin Document'), 'url' => route('admin.about.plugin'), 'route' => 'admin.about.plugin'],
                    ['label' => __('Developer Guide'), 'url' => route('admin.about.developer'), 'route' => 'admin.about.developer'],
                    ['label' => __('Hooks Reference'), 'url' => route('admin.about.hooks'), 'route' => 'admin.about.hooks'],
                    ['label' => __('Other Documents'), 'url' => route('admin.about.other'), 'route' => 'admin.about.other'],
                    ['label' => __('Credits'), 'url' => route('admin.about.credits'), 'route' => 'admin.about.credits'],
                    ['label' => __('License'), 'url' => route('admin.about.license'), 'route' => 'admin.about.license'],
                ],
            ],
        ];

        $navSections = [
            ['title' => null, 'items' => $coreTop],
            ['title' => __('Plugins'), 'items' => $pluginNav],
            ['title' => null, 'items' => $coreBottom],
        ];

        $searchIndex = [];
        foreach ($navSections as $section) {
            foreach ($section['items'] as $item) {
                $label = (string) ($item['label'] ?? '');
                $first = $item['url'] ?? ($item['children'][0]['url'] ?? null);
                if ($label !== '' && $first && $first !== '#') {
                    $searchIndex[] = ['title' => $label, 'path' => (string) ($section['title'] ?? ''), 'url' => $first];
                }
                foreach ($item['children'] as $child) {
                    if (!empty($child['label']) && !empty($child['url']) && $child['url'] !== '#') {
                        $searchIndex[] = ['title' => $child['label'], 'path' => $label, 'url' => $child['url']];
                    }
                }
            }
        }
        $searchIndex[] = ['title' => __('Profile'), 'path' => '', 'url' => route('admin.profile.edit')];
        $searchIndex[] = ['title' => __('Notifications'), 'path' => '', 'url' => route('admin.notifications.index')];

        $searchHints = [
            __('Search menus, settings, or ask AI...'),
            __('Try "Backup"'),
            __('Try "Users"'),
            __('Try "Site Health"'),
            __('Ask AI anything'),
        ];

        $searchTexts = [
            'recent'  => __('Recent'),
            'quick'   => __('Quick links'),
            'menu'    => __('Menu'),
            'results' => __('Results'),
            'ai'      => __('AI'),
            'askAi'   => __('Ask AI'),
        ];
    @endphp

    <div class="flex min-h-screen" x-data="rjAdminShell()" @keydown.window.prevent.cmd.k="openSearch()" @keydown.window.prevent.ctrl.k="openSearch()" @keydown.window="onKey($event)" @keydown.escape.window="searchOpen = false; notifMenu = false; langMenu = false; userMenu = false">

        <aside class="w-64 h-screen sticky top-0 self-start z-50 bg-gradient-to-b from-rj-dark-1 via-rj-dark-2 to-rj-dark-1 text-gray-300 flex-shrink-0 flex flex-col">
            <div class="h-20 flex items-center justify-center px-5 border-b border-white/5 flex-shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="hover:opacity-90 transition inline-flex items-center">
                    @php $logoMask = rj_logo_mask_url(); @endphp
                    @if ($logoMask)
                        <div class="rj-logo-mask h-12 w-40" style="-webkit-mask-image: url('{{ $logoMask }}'); mask-image: url('{{ $logoMask }}');"></div>
                    @else
                        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-12 w-auto">
                    @endif
                </a>
            </div>

            <nav class="rj-scrollbar flex-1 overflow-y-auto p-3 space-y-0.5 text-sm">
                @foreach ($navSections as $section)
                    @if (!empty($section['items']))
                        @if ($section['title'])
                            <div class="pt-3 mt-3 border-t border-white/5">
                                <div class="px-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    {{ $section['title'] }}
                                </div>
                        @endif

                        @foreach ($section['items'] as $item)
                            @php
                                $hasChildren = !empty($item['children']);
                                $itemUrl = $item['url'] ?? ($hasChildren ? $item['children'][0]['url'] : '#');

                                $hasActiveChild = false;
                                if ($hasChildren) {
                                    foreach ($item['children'] as $child) {
                                        if (!empty($child['route']) && request()->routeIs($child['route'])) {
                                            $hasActiveChild = true;
                                            break;
                                        }
                                    }
                                }
                                $isParentActive = $item['active'] || $hasActiveChild;
                            @endphp

                            @if ($hasChildren)
                                @if ($isParentActive)
                                    <div>
                                        <a href="{{ $itemUrl }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition bg-white/10 text-white">
                                            <span class="w-5 h-5 flex-shrink-0 flex items-center justify-center text-current">{!! $item['icon'] !!}</span>
                                            <span>{{ $item['label'] }}</span>
                                        </a>
                                        <div class="mt-1 space-y-0.5 ms-4 border-s border-white/10 ps-2">
                                            @foreach ($item['children'] as $child)
                                                @php $childActive = !empty($child['route']) && request()->routeIs($child['route']); @endphp
                                                <a href="{{ $child['url'] }}"
                                                   class="block px-3 py-1.5 rounded-lg text-sm transition {{ $childActive ? 'text-white bg-white/10' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                                                    {{ $child['label'] }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <div class="relative"
                                         x-data="{
                                             open: false,
                                             top: 0,
                                             timer: null,
                                             show(el) {
                                                 clearTimeout(this.timer);
                                                 this.open = true;
                                                 const r = el.getBoundingClientRect();
                                                 this.top = r.top;
                                                 this.$nextTick(() => {
                                                     const h = this.$refs.fly ? this.$refs.fly.offsetHeight : 0;
                                                     this.top = Math.max(8, Math.min(r.top, window.innerHeight - h - 8));
                                                 });
                                             },
                                             hide() {
                                                 this.timer = setTimeout(() => { this.open = false; }, 150);
                                             },
                                             keep() {
                                                 clearTimeout(this.timer);
                                             }
                                         }"
                                         @mouseenter="show($el)"
                                         @mouseleave="hide()">

                                        <a href="{{ $itemUrl }}" class="flex items-center gap-3 px-3 py-2 rounded-lg transition hover:bg-white/5 hover:text-white">
                                            <span class="w-5 h-5 flex-shrink-0 flex items-center justify-center text-current">{!! $item['icon'] !!}</span>
                                            <span>{{ $item['label'] }}</span>
                                        </a>

                                        <div x-show="open" x-cloak x-ref="fly"
                                             @mouseenter="keep()"
                                             @mouseleave="hide()"
                                             class="fixed z-[99999] ps-2"
                                             :style="`top:${top}px; inset-inline-start:16rem;`">
                                            <div class="min-w-[12rem] overflow-hidden rounded-lg border border-white/10 shadow-2xl py-2 text-sm bg-gradient-to-b from-rj-dark-1 via-rj-dark-2 to-rj-dark-1"
                                                 style="background-color:#14121f;">
                                                <div class="px-4 pb-1.5 mb-1 border-b border-white/10 text-white font-semibold">{{ $item['label'] }}</div>
                                                @foreach ($item['children'] as $child)
                                                    @php $childActive = !empty($child['route']) && request()->routeIs($child['route']); @endphp
                                                    <a href="{{ $child['url'] }}"
                                                       class="block px-4 py-1.5 transition {{ $childActive ? 'text-white bg-white/10' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                                                        {{ $child['label'] }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <a href="{{ $itemUrl }}"
                                   class="flex items-center gap-3 px-3 py-2 rounded-lg transition {{ $item['active'] ? 'bg-gradient-to-r from-rj-purple/30 to-rj-pink/20 text-white border-s-2 border-rj-purple-light' : 'hover:bg-white/5 hover:text-white' }}">
                                    <span class="w-5 h-5 flex-shrink-0 flex items-center justify-center text-current">{!! $item['icon'] !!}</span>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            @endif
                        @endforeach

                        @if ($section['title'])
                            </div>
                        @endif
                    @endif
                @endforeach
            </nav>

            <div class="p-3 border-t border-white/5 text-xs text-gray-500 flex items-center justify-between flex-shrink-0">
                <span>v{{ rj_get_option('rj_version', '1.0.0') }}</span>
                <a href="{{ route('home') }}" target="_blank" class="hover:text-white transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    {{ __('View Site') }}
                </a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 relative z-10">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-40">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">@yield('title', __('Dashboard'))</h1>
                </div>

                <div class="flex items-center gap-4">

                    <button type="button" class="rj-sb" @click="openSearch()" aria-label="{{ __('Search') }}">
                        <span class="rj-sb-ic">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        </span>
                        <span class="rj-sb-t" :class="hintShow ? 'is-on' : ''" x-text="hints[hintIdx]"></span>
                        <kbd x-text="isMac ? '⌘K' : 'Ctrl K'"></kbd>
                    </button>

                    <div class="relative" @click.away="notifMenu = false">
                        <button @click="notifMenu = !notifMenu" class="relative p-2 text-gray-400 hover:text-gray-600 transition rounded-full hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span x-show="unreadCount > 0" x-cloak class="absolute top-1.5 right-1.5 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white ring-2 ring-white" x-text="unreadCount"></span>
                        </button>

                        <div x-show="notifMenu" x-cloak x-transition class="absolute end-0 mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden z-50">
                            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 bg-gray-50">
                                <h3 class="text-sm font-bold text-gray-900">{{ __('Notifications') }}</h3>
                                <button type="button" @click="markAllRead()" class="text-xs font-medium text-rj-purple hover:underline">{{ __('Mark all read') }}</button>
                            </div>

                            <div class="max-h-80 overflow-y-auto">
                                <template x-if="notifications.length === 0">
                                    <div class="p-6 text-center text-sm text-gray-500">{{ __('No notifications yet.') }}</div>
                                </template>
                                <template x-for="n in notifications" :key="n.id">
                                    <a :href="n.action_url || '/admin/notifications'" class="block px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition" :class="!n.is_read ? 'bg-indigo-50/30' : ''">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" :style="'background:' + (n.color || '#7c3aed') + '15; color:' + (n.color || '#7c3aed')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-semibold text-gray-900 truncate" x-text="n.title"></p>
                                                <p class="text-xs text-gray-500 line-clamp-2 mt-0.5" x-text="n.message"></p>
                                                <p class="text-[10px] text-gray-400 mt-1" x-text="n.ago"></p>
                                            </div>
                                            <div x-show="!n.is_read" class="w-2 h-2 rounded-full bg-rj-purple flex-shrink-0 mt-1"></div>
                                        </div>
                                    </a>
                                </template>
                            </div>
                            <a href="{{ route('admin.notifications.index') }}" class="block px-4 py-2 text-center text-xs font-medium text-gray-500 bg-gray-50 hover:text-rj-purple transition border-t border-gray-100">
                                {{ __('View All Notifications') }}
                            </a>
                        </div>
                    </div>

                    <div class="relative" @click.away="langMenu = false">
                        <button @click="langMenu = !langMenu" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition text-sm text-gray-600">
                            <span class="uppercase text-xs font-medium">{{ app()->getLocale() }}</span>
                            <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="langMenu" x-cloak x-transition class="absolute end-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 rj-fade-in z-20">
                            @foreach (rj_available_locales() as $locale)
                                <a href="{{ route('admin.lang.switch', $locale) }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ app()->getLocale() === $locale ? 'bg-gray-50 font-medium' : '' }}">
                                    @if (file_exists(public_path("images/flags/{$locale}.svg")))
                                        <img src="{{ asset("images/flags/{$locale}.svg") }}" alt="{{ strtoupper($locale) }}" class="w-5 h-4 object-cover rounded-sm">
                                    @endif
                                    <span class="uppercase">{{ $locale }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="relative" @click.away="userMenu = false">
                        <button @click="userMenu = !userMenu" class="flex items-center gap-3 px-2 py-1.5 rounded-lg hover:bg-gray-100 transition">
                            <div class="h-9 w-9 rounded-full bg-gradient-to-br from-rj-purple to-rj-pink flex items-center justify-center text-white text-sm font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden sm:block text-start">
                                <div class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</div>
                            </div>
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="userMenu" x-cloak x-transition class="absolute end-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-100 py-1 rj-fade-in z-20">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <div class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</div>
                            </div>

                            <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                {{ __('Profile') }}
                            </a>

                            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                {{ __('View Site') }}
                            </a>

                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </header>

            <main class="p-6 flex-1">
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border-s-4 border-red-500 text-red-800 px-4 py-3 rounded-e-lg rj-fade-in">
                        <ul class="text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 bg-green-50 border-s-4 border-green-500 text-green-800 px-4 py-3 rounded-e-lg rj-fade-in">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-50 border-s-4 border-red-500 text-red-800 px-4 py-3 rounded-e-lg rj-fade-in">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

        <div class="rj-sm" x-show="searchOpen" x-cloak role="dialog" aria-modal="true" aria-label="{{ __('Search') }}">
            <div class="rj-sm-back"
                 @click="searchOpen = false"
                 x-show="searchOpen"
                 x-transition:enter="rj-o-e" x-transition:enter-start="rj-o-0" x-transition:enter-end="rj-o-1"
                 x-transition:leave="rj-o-l" x-transition:leave-start="rj-o-1" x-transition:leave-end="rj-o-0"></div>

            <div class="rj-sm-box"
                 x-show="searchOpen"
                 x-transition:enter="rj-b-e" x-transition:enter-start="rj-b-0" x-transition:enter-end="rj-b-1"
                 x-transition:leave="rj-b-l" x-transition:leave-start="rj-b-1" x-transition:leave-end="rj-b-0">
                <div class="rj-sm-in">
                    <div class="rj-sm-load" :class="searchLoading ? 'is-on' : ''"><i></i></div>

                    <div class="rj-sm-head">
                        <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                        <input type="text"
                               class="rj-sm-input"
                               x-ref="searchInput"
                               x-model="searchQuery"
                               @input.debounce.300ms="performSearch()"
                               @keydown.arrow-down.prevent="move(1)"
                               @keydown.arrow-up.prevent="move(-1)"
                               @keydown.enter.prevent="openActive()"
                               placeholder="{{ __('Search menus, settings, or ask AI...') }}"
                               autocomplete="off"
                               spellcheck="false">
                        <button type="button" class="rj-sm-x" x-show="searchQuery.length > 0" x-cloak @click="searchQuery = ''; $refs.searchInput.focus()" aria-label="{{ __('Clear') }}">
                            <svg fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18"/></svg>
                        </button>
                        <button type="button" class="rj-sm-esc" @click="searchOpen = false">ESC</button>
                        <button type="button" class="rj-sm-x rj-sm-esc-m" @click="searchOpen = false" aria-label="{{ __('Close') }}">
                            <svg fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" viewBox="0 0 24 24"><path d="M6 6l12 12M18 6L6 18"/></svg>
                        </button>
                    </div>

                    <div class="rj-sm-list">
                        <template x-for="item in items" :key="item.kind + '|' + item.url">
                            <div>
                                <div class="rj-sm-gh" x-show="item.head" x-text="item.group"></div>
                                <a :href="item.url"
                                   class="rj-sm-it"
                                   :class="{ 'is-active': activeIndex === item.i, 'is-ai': item.kind === 'ai' }"
                                   :data-i="item.i"
                                   :style="'--i:' + item.i"
                                   @mouseenter="activeIndex = item.i"
                                   @click="remember(item)">
                                    <span class="rj-sm-ic" x-html="icons[item.kind]"></span>
                                    <span class="rj-sm-tx">
                                        <b x-html="hl(item.title)"></b>
                                        <small x-show="item.sub" x-html="hl(item.sub)"></small>
                                    </span>
                                    <span class="rj-sm-url" x-show="item.kind !== 'ai'" x-text="short(item.url)"></span>
                                    <svg class="rj-sm-go" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 10l-5 5 5 5M20 4v7a4 4 0 01-4 4H4"/></svg>
                                </a>
                            </div>
                        </template>

                        <div class="rj-sm-empty" x-show="searchQuery.trim().length > 0 && !searchLoading && !hasResults" x-cloak>
                            <svg fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3M8.5 11h5"/></svg>
                            {{ __('No results found for') }} "<strong x-text="searchQuery"></strong>"
                        </div>
                    </div>

                    <div class="rj-sm-foot">
                        <div class="rj-sm-keys">
                            <span><kbd>↑</kbd><kbd>↓</kbd> {{ __('Navigate') }}</span>
                            <span><kbd>↵</kbd> {{ __('Open') }}</span>
                            <span><kbd>Esc</kbd> {{ __('Close') }}</span>
                        </div>
                        <span class="rj-sm-pw">
                            <svg fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            {{ __('Powered by RJ AI Engine') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function rjAdminShell() {
            const urls = {
                recent: @js(route('admin.notifications.recent')),
                markAll: @js(route('admin.notifications.mark-all-read')),
                search: @js(route('admin.search')),
                ai: @js(route('admin.ai.index')),
                csrf: @js(csrf_token())
            };
            const T = @js($searchTexts);
            const svg = function (d) {
                return '<svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="' + d + '"/></svg>';
            };
            const icons = {
                menu: svg('M4 6h16M4 12h16M4 18h7'),
                quick: svg('M13 10V3L4 14h7v7l9-11h-7z'),
                recent: svg('M12 8v4l3 2M21 12a9 9 0 11-18 0 9 9 0 0118 0z'),
                result: svg('M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'),
                ai: svg('M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z')
            };
            const norm = function (s) {
                return String(s || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            };
            const esc = function (s) {
                return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
            };

            return {
                userMenu: false,
                langMenu: false,
                notifMenu: false,
                notifications: [],
                unreadCount: 0,

                searchOpen: false,
                searchQuery: '',
                searchLoading: false,
                serverResults: [],
                activeIndex: 0,
                reqId: 0,
                recent: [],

                hints: @js($searchHints),
                hintIdx: 0,
                hintShow: true,
                isMac: /Mac|iPhone|iPad/i.test(navigator.platform || navigator.userAgent),

                menuIndex: @js($searchIndex),
                icons: icons,

                init() {
                    this.fetchNotifications();
                    setInterval(() => this.fetchNotifications(), 60000);

                    setInterval(() => {
                        this.hintShow = false;
                        setTimeout(() => {
                            this.hintIdx = (this.hintIdx + 1) % this.hints.length;
                            this.hintShow = true;
                        }, 260);
                    }, 3400);

                    this.$watch('searchQuery', () => {
                        this.activeIndex = 0;
                        if (this.searchQuery.trim().length < 2) {
                            this.serverResults = [];
                            this.searchLoading = false;
                        }
                    });

                    this.$watch('searchOpen', (v) => {
                        document.body.style.overflow = v ? 'hidden' : '';
                        if (!v) {
                            this.searchQuery = '';
                            this.serverResults = [];
                            this.searchLoading = false;
                        }
                    });
                },

                fetchNotifications() {
                    fetch(urls.recent, {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.unreadCount = data.unread;
                        this.notifications = data.notifications;
                    })
                    .catch(() => {});
                },

                markAllRead() {
                    fetch(urls.markAll, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': urls.csrf
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            this.unreadCount = 0;
                            this.notifications.forEach(n => n.is_read = true);
                        }
                    })
                    .catch(() => {});
                },

                loadRecent() {
                    try {
                        const raw = JSON.parse(localStorage.getItem('rj-admin-recent') || '[]');
                        this.recent = Array.isArray(raw) ? raw.slice(0, 5) : [];
                    } catch (e) {
                        this.recent = [];
                    }
                },

                remember(item) {
                    if (!item || item.kind === 'ai' || !item.url || item.url === '#') return;
                    const entry = { title: item.title, path: item.path || '', url: item.url };
                    const list = this.recent.filter(r => r.url !== entry.url);
                    list.unshift(entry);
                    this.recent = list.slice(0, 5);
                    try { localStorage.setItem('rj-admin-recent', JSON.stringify(this.recent)); } catch (e) {}
                },

                openSearch() {
                    this.loadRecent();
                    this.activeIndex = 0;
                    this.notifMenu = false;
                    this.langMenu = false;
                    this.userMenu = false;
                    this.searchOpen = true;
                    this.$nextTick(() => { if (this.$refs.searchInput) this.$refs.searchInput.focus(); });
                },

                onKey(e) {
                    if (e.key !== '/' || e.ctrlKey || e.metaKey || e.altKey || this.searchOpen) return;
                    const el = document.activeElement;
                    const tag = el ? el.tagName : '';
                    if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT' || (el && el.isContentEditable)) return;
                    e.preventDefault();
                    this.openSearch();
                },

                performSearch() {
                    const q = this.searchQuery.trim();
                    if (q.length < 2) {
                        this.serverResults = [];
                        this.searchLoading = false;
                        return;
                    }
                    const id = ++this.reqId;
                    this.searchLoading = true;
                    fetch(urls.search + '?q=' + encodeURIComponent(q), {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (id !== this.reqId) return;
                        this.serverResults = (data.results || []).map(r => ({
                            title: r.title || '',
                            sub: r.desc || r.description || '',
                            url: r.url || '#'
                        }));
                        this.searchLoading = false;
                    })
                    .catch(() => {
                        if (id === this.reqId) this.searchLoading = false;
                    });
                },

                localMatches(q) {
                    const tokens = norm(q).split(/\s+/).filter(Boolean);
                    if (!tokens.length) return [];
                    const scored = [];
                    this.menuIndex.forEach((m) => {
                        const title = norm(m.title);
                        const hay = title + ' ' + norm(m.path);
                        if (!tokens.every(t => hay.indexOf(t) > -1)) return;
                        let score = 0;
                        tokens.forEach((t) => {
                            if (title.indexOf(t) === 0) score += 3;
                            else if (title.indexOf(t) > -1) score += 2;
                            else score += 1;
                        });
                        scored.push({ m: m, score: score });
                    });
                    scored.sort((a, b) => b.score - a.score);
                    return scored.slice(0, 8).map(s => s.m);
                },

                get items() {
                    const q = this.searchQuery.trim();
                    let out = [];

                    if (!q) {
                        this.recent.forEach((r) => {
                            out.push({ kind: 'recent', group: T.recent, title: r.title, path: r.path, sub: r.path, url: r.url });
                        });
                        this.menuIndex.filter(m => !m.path).slice(0, 7).forEach((m) => {
                            out.push({ kind: 'quick', group: T.quick, title: m.title, path: '', sub: '', url: m.url });
                        });
                    } else {
                        const seen = {};
                        this.localMatches(q).forEach((m) => {
                            seen[m.url] = true;
                            out.push({ kind: 'menu', group: T.menu, title: m.title, path: m.path, sub: m.path, url: m.url });
                        });
                        this.serverResults.forEach((r) => {
                            if (seen[r.url]) return;
                            seen[r.url] = true;
                            out.push({ kind: 'result', group: T.results, title: r.title, path: '', sub: r.sub, url: r.url });
                        });
                        if (q.length >= 2) {
                            out.push({ kind: 'ai', group: T.ai, title: T.askAi + ': \u201C' + q + '\u201D', path: '', sub: '', url: urls.ai + '?q=' + encodeURIComponent(q) });
                        }
                    }

                    let last = null;
                    out.forEach((it, i) => {
                        it.head = it.group !== last;
                        last = it.group;
                        it.i = i;
                    });
                    return out;
                },

                get hasResults() {
                    return this.items.some(i => i.kind !== 'ai');
                },

                move(d) {
                    const n = this.items.length;
                    if (!n) return;
                    this.activeIndex = (this.activeIndex + d + n) % n;
                    this.$nextTick(() => {
                        const el = this.$root.querySelector('[data-i="' + this.activeIndex + '"]');
                        if (el) el.scrollIntoView({ block: 'nearest' });
                    });
                },

                openActive() {
                    const it = this.items[this.activeIndex];
                    if (!it) return;
                    this.remember(it);
                    window.location.href = it.url;
                },

                short(u) {
                    try {
                        const x = new URL(u, window.location.origin);
                        return x.pathname + x.search;
                    } catch (e) {
                        return u;
                    }
                },

                hl(text) {
                    const s = String(text || '');
                    const toks = this.searchQuery.trim().split(/\s+/).filter(Boolean);
                    if (!toks.length) return esc(s);
                    const re = new RegExp('(' + toks.map(x => x.replace(/[.*+?^$()|[\]\\{}]/g, '\\$&')).join('|') + ')', 'gi');
                    return s.split(re).map((part, i) => i % 2 ? '<mark>' + esc(part) + '</mark>' : esc(part)).join('');
                }
            };
        }
    </script>

    @include('admin.partials.media-picker')

</body>
</html>