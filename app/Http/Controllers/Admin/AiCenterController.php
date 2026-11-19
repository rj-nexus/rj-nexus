<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiLog;
use App\Services\OpenRouterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AiCenterController extends Controller
{
    protected OpenRouterService $openRouter;

    public function __construct(OpenRouterService $openRouter)
    {
        $this->openRouter = $openRouter;
    }

    public function index()
    {
        $aiEnabled = $this->openRouter->isConfigured();
        $activeModel = rj_get_option('ai_default_model', 'google/gemini-2.0-flash-exp:free');

        $totalTokens = AiLog::sum('total_tokens');
        $totalCost = AiLog::sum('cost');
        $totalRequests = AiLog::count();

        $todayRequests = AiLog::whereDate('created_at', today())->count();
        $todayCost = AiLog::whereDate('created_at', today())->sum('cost');

        return view('admin.ai.index', compact(
            'aiEnabled', 'activeModel', 'totalTokens', 'totalCost',
            'totalRequests', 'todayRequests', 'todayCost'
        ));
    }

    public function models()
    {
        $cacheKey = 'rj_openrouter_models_slim_v1';

        try {
            $models = Cache::remember($cacheKey, 86400, function () {
                try {
                    $res = Http::withHeaders([
                        'User-Agent' => 'RJ-Nexus/1.0',
                        'Accept' => 'application/json',
                    ])->timeout(15)->get('https://openrouter.ai/api/v1/models');

                    if (!$res->successful()) {
                        return [];
                    }

                    $data = $res->json('data');
                    if (!is_array($data)) {
                        return [];
                    }

                    return array_values(array_map(function ($m) {
                        return [
                            'id' => (string) ($m['id'] ?? ''),
                            'name' => (string) ($m['name'] ?? ($m['id'] ?? '')),
                            'pricing' => [
                                'prompt' => (string) ($m['pricing']['prompt'] ?? ''),
                            ],
                        ];
                    }, $data));
                } catch (\Throwable $e) {
                    return [];
                }
            });
        } catch (\Throwable $e) {
            try { Cache::forget($cacheKey); } catch (\Throwable $ignored) {}
            $models = [];
        }

        if (!empty($models)) {
            try { Cache::forget('rj_openrouter_models'); } catch (\Throwable $ignored) {}
        }

        $defaultModel = rj_get_option('ai_default_model', 'google/gemini-2.0-flash-exp:free');
        $seoModel = rj_get_option('ai_seo_model', $defaultModel);
        $translateModel = rj_get_option('ai_translate_model', $defaultModel);
        $builderModel = rj_get_option('ai_builder_model', $defaultModel);

        return view('admin.ai.models', compact('models', 'defaultModel', 'seoModel', 'translateModel', 'builderModel'));
    }

    public function saveModels(Request $request)
    {
        $validated = $request->validate([
            'default_model' => 'required|string',
            'seo_model' => 'nullable|string',
            'translate_model' => 'nullable|string',
            'builder_model' => 'nullable|string',
        ]);

        rj_set_option('ai_default_model', $validated['default_model']);
        rj_set_option('ai_seo_model', $validated['seo_model'] ?? $validated['default_model']);
        rj_set_option('ai_translate_model', $validated['translate_model'] ?? $validated['default_model']);
        rj_set_option('ai_builder_model', $validated['builder_model'] ?? $validated['default_model']);

        rj_flush_options();

        return back()->with('success', __('AI models updated.'));
    }

    public function prompts()
    {
        $prompts = [
            'seo' => rj_get_option('ai_prompt_seo', $this->defaultSeoPrompt()),
            'translate' => rj_get_option('ai_prompt_translate', $this->defaultTranslatePrompt()),
            'builder' => rj_get_option('ai_prompt_builder', $this->defaultBuilderPrompt()),
        ];

        return view('admin.ai.prompts', compact('prompts'));
    }

    public function savePrompts(Request $request)
    {
        $validated = $request->validate([
            'prompts' => 'required|array',
        ]);

        foreach ($validated['prompts'] as $key => $value) {
            rj_set_option('ai_prompt_' . $key, $value);
        }

        rj_flush_options();

        return back()->with('success', __('Prompts saved.'));
    }

    public function usage(Request $request)
    {
        $query = AiLog::with('user')->orderByDesc('created_at');

        if ($search = $request->input('q')) {
            $query->where(function($q) use ($search) {
                $q->where('model', 'like', '%' . $search . '%')
                  ->orWhere('task', 'like', '%' . $search . '%');
            });
        }

        if ($task = $request->input('task')) {
            $query->where('task', $task);
        }

        $logs = $query->paginate(20)->withQueryString();
        $tasks = AiLog::select('task')->distinct()->pluck('task');

        return view('admin.ai.usage', compact('logs', 'tasks'));
    }

    protected function defaultSeoPrompt(): string
    {
        return 'You are an expert SEO specialist. Generate a compelling SEO title and description based on the provided content.';
    }

    protected function defaultTranslatePrompt(): string
    {
        return 'You are a professional translator. Translate the provided text accurately while maintaining the original tone and formatting.';
    }

    protected function defaultBuilderPrompt(): string
    {
        return 'You are an expert web designer. Suggest a page layout or generate text for a website based on the provided instructions.';
    }
}