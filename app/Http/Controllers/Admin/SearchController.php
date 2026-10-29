<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FreeAiService;

class SearchController extends Controller
{
    public function search(Request $request, FreeAiService $ai)
    {
        $query = trim($request->input('q', ''));

        if (empty($query)) {
            return response()->json(['success' => true, 'results' => []]);
        }

        $menus = $this->getMenus();
        $queryLower = strtolower($query);

        $localResults = [];
        foreach ($menus as $menu) {
            $score = 0;
            if (stripos($menu['title'], $query) !== false) $score += 10;
            if (stripos($menu['keywords'], $query) !== false) $score += 5;
            if (stripos($menu['desc'], $query) !== false) $score += 2;

            if ($score > 0) {
                $menu['score'] = $score;
                $localResults[] = $menu;
            }
        }

        usort($localResults, fn($a, $b) => $b['score'] - $a['score']);
        $localResults = array_slice($localResults, 0, 3);

        try {
            $menusJson = json_encode(array_map(function($m) {
                return ['title' => $m['title'], 'url' => $m['url'], 'desc' => $m['desc']];
            }, $menus));

            $prompt = "You are an admin panel search router. User query: '{$query}'.\n";
            $prompt .= "Here is the list of available menus: {$menusJson}\n";
            $prompt .= "Return ONLY a valid JSON array of the top 3 most relevant matches. Example: [{\"title\":\"Posts\",\"url\":\"/admin/posts\",\"desc\":\"Manage posts\"}]. If none match, return []. Do not include any other text, markdown formatting, or explanations.";

            $response = $ai->ask($prompt, 'Admin Menu Search');

            if ($response['success']) {
                $answer = $response['answer'];
                $answer = preg_replace('/```json/i', '', $answer);
                $answer = preg_replace('/```/i', '', $answer);
                $answer = trim($answer);

                $aiResults = json_decode($answer, true);

                if (is_array($aiResults) && !empty($aiResults)) {
                    return response()->json(['success' => true, 'results' => $aiResults, 'source' => 'ai']);
                }
            }
        } catch (\Throwable $e) {
            // AI xətası zamanı heç nə etmirik, aşağıdakı fallback işləyəcək
        }

        return response()->json(['success' => true, 'results' => $localResults, 'source' => 'local']);
    }

    protected function getMenus(): array
    {
        return [
            ['title' => 'Dashboard', 'url' => '/admin/dashboard', 'desc' => 'Overview and stats', 'keywords' => 'dashboard, home, stats, overview, ana səhifə'],
            ['title' => 'Posts', 'url' => '/admin/posts', 'desc' => 'Manage blog posts and articles', 'keywords' => 'posts, blog, article, write, news, yazı, məqalə'],
            ['title' => 'Pages', 'url' => '/admin/pages', 'desc' => 'Manage static pages', 'keywords' => 'pages, static, about, contact, səhifə'],
            ['title' => 'Media', 'url' => '/admin/media', 'desc' => 'Manage images, videos and files', 'keywords' => 'media, images, photos, files, upload, şəkil, fayl'],
            ['title' => 'Comments', 'url' => '/admin/comments', 'desc' => 'Moderate user comments', 'keywords' => 'comments, replies, spam, şərh'],
            ['title' => 'Categories', 'url' => '/admin/posts/categories', 'desc' => 'Manage post categories', 'keywords' => 'category, categories, section, kateqoriya'],
            ['title' => 'Tags', 'url' => '/admin/posts/tags', 'desc' => 'Manage post tags', 'keywords' => 'tags, keywords, teq, etiket'],
            ['title' => 'RJ Builder', 'url' => '/admin/rjbuilder', 'desc' => 'Drag and drop visual page builder', 'keywords' => 'builder, design, layout, template, header, footer, popup, drag, drop'],
            ['title' => 'Global Widgets', 'url' => '/admin/global-widgets', 'desc' => 'Reusable blocks across the site', 'keywords' => 'global, widgets, reusable, blocks, shared'],
            ['title' => 'Menus', 'url' => '/admin/menus', 'desc' => 'Navigation menus (header, footer)', 'keywords' => 'menu, navigation, links, header, footer, menyu'],
            ['title' => 'Themes', 'url' => '/admin/themes', 'desc' => 'Manage site themes', 'keywords' => 'theme, design, template, appearance, tema'],
            ['title' => 'Appearance Colors', 'url' => '/admin/appearance/colors', 'desc' => 'Admin and site color palette', 'keywords' => 'colors, palette, theme color, rəng'],
            ['title' => 'Users', 'url' => '/admin/users', 'desc' => 'Manage users and accounts', 'keywords' => 'users, accounts, staff, profile, istifadəçi'],
            ['title' => 'Roles & Permissions', 'url' => '/admin/roles', 'desc' => 'Manage access control', 'keywords' => 'roles, permissions, access, admin, editor, rol'],
            ['title' => 'Activity Log', 'url' => '/admin/activity-log', 'desc' => 'System audit trail and history', 'keywords' => 'activity, log, history, audit, tracking, jurnal'],
            ['title' => 'Settings General', 'url' => '/admin/settings/general', 'desc' => 'Site name, URL, timezone', 'keywords' => 'general, settings, site name, timezone, url, ayarlar'],
            ['title' => 'Settings SEO', 'url' => '/admin/settings/seo', 'desc' => 'Meta tags, sitemap, robots.txt', 'keywords' => 'seo, meta, sitemap, robots, schema'],
            ['title' => 'Settings Email', 'url' => '/admin/settings/email', 'desc' => 'SMTP and email configuration', 'keywords' => 'email, smtp, mail, server, məktub'],
            ['title' => 'Settings Security', 'url' => '/admin/settings/security', 'desc' => '2FA, captcha, login limits', 'keywords' => 'security, captcha, 2fa, login, firewall, təhlükəsizlik'],
            ['title' => 'Settings Backup', 'url' => '/admin/settings/backup', 'desc' => 'Database and file backups', 'keywords' => 'backup, restore, save, ehtiyat nüsxə'],
            ['title' => 'Settings Cache', 'url' => '/admin/settings/cache', 'desc' => 'Clear site cache', 'keywords' => 'cache, clear, optimize, performance, keş'],
            ['title' => 'Settings AI', 'url' => '/admin/settings/ai', 'desc' => 'OpenRouter API and AI models', 'keywords' => 'ai, settings, openrouter, model, api key'],
            ['title' => 'Settings Advanced', 'url' => '/admin/settings/advanced', 'desc' => 'Debug mode, Maintenance mode, Custom CSS', 'keywords' => 'advanced, debug, maintenance, custom css, js, texniki'],
            ['title' => 'Plugins', 'url' => '/admin/plugins', 'desc' => 'Install and manage plugins', 'keywords' => 'plugins, extensions, addons, commerce, plagin'],
            ['title' => 'Forms', 'url' => '/admin/plugin/forms', 'desc' => 'Form builder and submissions', 'keywords' => 'forms, contact form, submissions, input'],
            ['title' => 'Newsletter', 'url' => '/admin/newsletter', 'desc' => 'Email subscribers and bulk send', 'keywords' => 'newsletter, subscribers, email marketing, abunə'],
            ['title' => 'KYC Verification', 'url' => '/admin/kyc', 'desc' => 'User identity verification', 'keywords' => 'kyc, identity, verification, passport, təsdiq'],
            ['title' => 'Updates', 'url' => '/admin/updates', 'desc' => 'System and plugin updates', 'keywords' => 'updates, upgrade, version, yeniləmə'],
            ['title' => 'AI Center', 'url' => '/admin/ai', 'desc' => 'AI usage stats and prompts', 'keywords' => 'ai, center, prompts, usage'],
            ['title' => 'AI Tools', 'url' => '/admin/ai/tools', 'desc' => 'Bulk translate, SEO audit', 'keywords' => 'ai, tools, translate, seo audit, generate'],
            ['title' => 'Import', 'url' => '/admin/tools/import', 'desc' => 'Import content from WordPress', 'keywords' => 'import, wordpress, migrate, idxal'],
            ['title' => 'Export', 'url' => '/admin/tools/export', 'desc' => 'Export site data', 'keywords' => 'export, download, json, xml, ixrac'],
            ['title' => 'System Logs', 'url' => '/admin/tools/logs', 'desc' => 'Laravel error logs', 'keywords' => 'logs, errors, laravel log, debug, xəta'],
            ['title' => 'Health Check', 'url' => '/admin/tools/health', 'desc' => 'Server health and stats', 'keywords' => 'health, server, cpu, ram, status'],
        ];
    }
}
