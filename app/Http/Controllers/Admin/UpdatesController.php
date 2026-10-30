<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Services\GitHubService; // BU SƏTİ ƏLAVƏ ETDİK
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;

class UpdatesController extends Controller
{
    protected string $repo;
    protected string $currentVersion;

    public function __construct()
    {
        $this->repo = rj_get_option('update_repo', 'rj-nexus/rj-nexus');

        $configVersion = ltrim((string) config('rj.version', '1.5.0'), 'v');
        $dbVersion = ltrim((string) rj_get_option('rj_version', '1.5.0'), 'v');

        if (version_compare($configVersion, $dbVersion, '>')) {
            rj_set_option('rj_version', $configVersion);
            $this->currentVersion = $configVersion;
        } else {
            $this->currentVersion = $dbVersion;
        }
    }

    public function index()
    {
        $options = Option::where('option_group', 'updates')
            ->pluck('option_value', 'option_name')
            ->toArray();

        $data = [
            'currentVersion' => $this->currentVersion,
            'lastChecked' => $options['last_checked'] ?? null,
            'lastRelease' => $this->getCachedRelease(),
        ];

        return view('admin.updates.index', compact('options', 'data'));
    }

    public function check(GitHubService $github)
    {
        try {
            $repoParts = explode('/', $this->repo);
            if (count($repoParts) !== 2) {
                return back()->with('error', __('Invalid repository format.'));
            }

            $releases = $github->getReleases($repoParts[0], $repoParts[1]);
            $release = $this->pickLatestRelease($releases);

            if (!$release) {
                return back()->with('error', __('No releases found.'));
            }

            $latest = ltrim($release['tag_name'], 'v');
            $hasUpdate = version_compare($latest, $this->currentVersion, '>');

            Option::set('last_checked', now()->toDateTimeString(), 'updates');
            Option::set('last_release', json_encode([
                'version' => $latest,
                'name' => $release['name'] ?? $release['tag_name'],
                'body' => $release['body'] ?? '',
                'url' => $release['html_url'] ?? '',
                'published_at' => $release['published_at'] ?? null,
                'prerelease' => (bool) ($release['prerelease'] ?? false),
                'has_update' => $hasUpdate,
            ]), 'updates');

            if ($hasUpdate) {
                return back()->with('success', __('New version available: :version', ['version' => $latest]));
            }

            return back()->with('success', __('You are running the latest version.'));
        } catch (\Throwable $e) {
            return back()->with('error', __('Update check failed: :message', ['message' => $e->getMessage()]));
        }
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'update_repo' => ['required', 'string', 'max:255', 'regex:/^[\w\-\.]+\/[\w\-\.]+$/'],
            'auto_check' => ['nullable', 'boolean'],
        ]);

        $data['auto_check'] = $request->boolean('auto_check') ? '1' : '0';

        foreach ($data as $name => $value) {
            Option::set($name, $value, 'updates');
        }

        return back()->with('success', __('Update settings saved.'));
    }

    public function run()
    {
        $release = $this->getCachedRelease();

        if (empty($release) || empty($release['has_update'])) {
            return back()->with('error', __('No update available to install.'));
        }

        try {
            Artisan::call('optimize:clear');

            return back()->with('success', __('Update prepared. Manual installation required for version :version.', ['version' => $release['version']]));
        } catch (\Throwable $e) {
            return back()->with('error', __('Update failed: :message', ['message' => $e->getMessage()]));
        }
    }

    protected function pickLatestRelease(array $releases): ?array
    {
        $best = null;

        foreach ($releases as $release) {
            if (!is_array($release) || !empty($release['draft']) || empty($release['tag_name'])) {
                continue;
            }

            if ($best === null || version_compare(ltrim($release['tag_name'], 'v'), ltrim($best['tag_name'], 'v'), '>')) {
                $best = $release;
            }
        }

        return $best;
    }

    protected function getCachedRelease(): ?array
    {
        $raw = Option::where('option_group', 'updates')
            ->where('option_name', 'last_release')
            ->value('option_value');

        if (!$raw) {
            return null;
        }

        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : null;
    }
}
