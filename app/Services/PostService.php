<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\PostType;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PostService
{
    protected array $seoFields = [
        'seo_title',
        'seo_description',
        'seo_image',
        'focus_keyword',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'robots',
        'schema_type',
    ];

    public function create(array $data, Request $request): Post
    {
        $type = $data['type'] ?? 'post';
        $title = $data['title'] ?? '';

        $baseSlug = $this->uniqueSlugForLocale(
            $this->pickSlugInput($data['slug'] ?? null, $title),
            $type,
            config('app.base_locale', config('app.locale'))
        );

        $post = Post::create([
            'title' => $title,
            'slug' => $baseSlug,
            'content' => $data['content'] ?? '',
            'edit_mode' => $data['edit_mode'] ?? 'classic',
            'theme_template' => $data['theme_template'] ?? null,
            'excerpt' => $data['excerpt'] ?? null,
            'featured_image' => $data['featured_image'] ?? null,
            'type' => $type,
            'status' => $data['status'] ?? 'draft',
            'is_sticky' => !empty($data['is_sticky']),
            'allow_comments' => $data['allow_comments'] ?? true,
            'author_id' => auth()->id(),
            'template_id' => $data['template_id'] ?? null,
            'settings' => $data['settings'] ?? [],
            'meta' => $data['meta'] ?? [],
            'published_at' => $this->resolvePublishedAt($data),
        ]);

        $this->syncCategories($post, $data['categories'] ?? []);
        $this->syncTags($post, $data['tags'] ?? []);
        $this->syncTranslations($post, $this->collectTranslations($data), $post->slug);

        return $post->fresh();
    }

    public function update(Post $post, array $data, Request $request): Post
    {
        $previousBaseSlug = $post->slug;
        $title = $data['title'] ?? $post->title;

        $baseSlug = $this->uniqueSlugForLocale(
            $this->pickSlugInput($data['slug'] ?? null, $title),
            $post->type,
            config('app.base_locale', config('app.locale')),
            $post->id
        );

        $payload = [
            'title' => $title,
            'slug' => $baseSlug,
            'content' => $data['content'] ?? $post->content,
            'excerpt' => $data['excerpt'] ?? null,
            'featured_image' => $data['featured_image'] ?? null,
            'status' => $data['status'] ?? $post->status,
            'is_sticky' => !empty($data['is_sticky']),
            'allow_comments' => $data['allow_comments'] ?? $post->allow_comments,
            'template_id' => $data['template_id'] ?? null,
            'settings' => $data['settings'] ?? $post->settings,
            'meta' => $data['meta'] ?? $post->meta,
            'published_at' => $this->resolvePublishedAt($data, $post),
        ];

        if (array_key_exists('edit_mode', $data)) {
            $payload['edit_mode'] = $data['edit_mode'] ?: 'classic';
        }

        if (array_key_exists('theme_template', $data)) {
            $payload['theme_template'] = $data['theme_template'] ?: null;
        }

        $post->update($payload);

        if (array_key_exists('categories', $data)) {
            $this->syncCategories($post, $data['categories']);
        }

        if (array_key_exists('tags', $data)) {
            $this->syncTags($post, $data['tags']);
        }

        $this->syncTranslations($post, $this->collectTranslations($data), $previousBaseSlug);

        return $post->fresh();
    }

    public function delete(Post $post): void
    {
        $post->categories()->detach();
        $post->tags()->detach();
        $post->translations()->delete();
        $post->delete();
    }

    public function duplicate(Post $post): Post
    {
        $copy = $post->replicate(['slug', 'view_count']);
        $copy->title = $post->title . ' (Copy)';
        $copy->slug = $this->uniqueSlugForLocale($copy->title, $post->type, config('app.base_locale', config('app.locale')));
        $copy->status = 'draft';
        $copy->published_at = null;
        $copy->view_count = 0;
        $copy->author_id = auth()->id();
        $copy->save();

        $copy->categories()->sync($post->categories()->pluck('id')->toArray());
        $copy->tags()->sync($post->tags()->pluck('id')->toArray());

        foreach ($post->translations as $t) {
            $newSlug = $this->uniqueSlugForLocale(
                $t->slug ?: $copy->title,
                $post->type,
                $t->locale
            );

            $copy->translations()->create(array_merge(
                $t->only([
                    'locale',
                    'title',
                    'content',
                    'excerpt',
                    'seo_title',
                    'seo_description',
                    'seo_image',
                    'focus_keyword',
                    'canonical_url',
                    'og_title',
                    'og_description',
                    'og_image',
                    'twitter_card',
                    'twitter_title',
                    'twitter_description',
                    'twitter_image',
                    'robots',
                    'schema_type',
                ]),
                ['slug' => $newSlug]
            ));
        }

        return $copy;
    }

    public function publish(Post $post): void
    {
        $post->update([
            'status' => 'published',
            'published_at' => $post->published_at ?? now(),
        ]);
    }

    public function unpublish(Post $post): void
    {
        $post->update(['status' => 'draft']);
    }

    public function schedule(Post $post, string $datetime): void
    {
        $post->update([
            'status' => 'scheduled',
            'published_at' => $datetime,
        ]);
    }

    public function trash(Post $post): void
    {
        $post->update(['status' => 'trash']);
    }

    public function restore(Post $post): void
    {
        $post->update(['status' => 'draft']);
    }

    public function bulkAction(array $ids, string $action): int
    {
        $query = Post::whereIn('id', $ids);

        return match ($action) {
            'publish' => $query->update(['status' => 'published', 'published_at' => now()]),
            'draft' => $query->update(['status' => 'draft']),
            'trash' => $query->update(['status' => 'trash']),
            'delete' => $query->delete(),
            'sticky' => $query->update(['is_sticky' => true]),
            'unsticky' => $query->update(['is_sticky' => false]),
            default => 0,
        };
    }

    public function uniqueSlugForLocale(string $slug, string $type, string $locale, ?int $ignoreId = null): string
    {
        $base = $this->makeSlug($slug, $locale);
        $candidate = $base;
        $i = 1;

        $isBase = $locale === config('app.base_locale', config('app.locale'));

        while (
            ($isBase && Post::query()
                ->where('slug', $candidate)
                ->where('type', $type)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists())
            ||
            PostTranslation::query()
                ->where('slug', $candidate)
                ->where('locale', $locale)
                ->when($ignoreId, fn($q) => $q->where('post_id', '!=', $ignoreId))
                ->exists()
        ) {
            $candidate = $base . '-' . $i;
            $i++;
        }

        return $candidate;
    }

    protected function makeSlug(string $text, string $locale): string
    {
        $text = trim($text);

        if ($text === '') {
            return 'post';
        }

        $slug = Str::slug($text);

        if ($slug === '') {
            $slug = mb_strtolower($text, 'UTF-8');
            $slug = preg_replace('/\s+/u', '-', $slug);
            $slug = preg_replace('/[^\p{L}\p{N}\-]+/u', '', $slug);
            $slug = preg_replace('/-+/', '-', $slug);
            $slug = trim($slug, '-');
        }

        return $slug !== '' ? $slug : 'post';
    }

    protected function pickSlugInput(?string $slug, string $title): string
    {
        $slug = trim((string) $slug);
        if ($slug !== '') {
            return $slug;
        }
        return (string) $title;
    }

    protected function syncCategories(Post $post, array $categories): void
    {
        $ids = $this->resolveIds($categories, Category::class);

        $post->categories()->sync($ids);

        $this->refreshTaxonomyCounts(Category::class, $ids);
    }

    protected function syncTags(Post $post, array $tags): void
    {
        $ids = $this->resolveIds($tags, Tag::class);

        $post->tags()->sync($ids);

        $this->refreshTaxonomyCounts(Tag::class, $ids);
    }

    protected function resolveIds(array $items, string $modelClass): array
    {
        if (empty($items)) {
            return [];
        }

        if (is_string($items)) {
            $items = array_filter(array_map('trim', explode(',', $items)));
        }

        $ids = [];

        foreach ($items as $item) {
            if (is_numeric($item)) {
                $ids[] = (int) $item;
                continue;
            }

            if (is_array($item)) {
                $id = $item['id'] ?? null;
                if ($id) $ids[] = (int) $id;
                continue;
            }

            if (is_string($item) && $item !== '') {
                $slug = Str::slug($item);
                $existing = $modelClass::query()->where('slug', $slug)->first();

                if (!$existing && $modelClass === Tag::class) {
                    $existing = Tag::create(['name' => $item, 'slug' => $slug]);
                }

                if ($existing) {
                    $ids[] = $existing->id;
                }
            }
        }

        return array_values(array_unique($ids));
    }

    protected function collectTranslations(array $data): array
    {
        $base = config('app.base_locale', config('app.locale'));
        $locales = rj_frontend_locales();

        $translations = $data['translations'] ?? [];

        if (!is_array($translations)) {
            $translations = [];
        }

        $out = [];

        foreach ($locales as $locale) {
            $entry = $translations[$locale] ?? [];

            if (!is_array($entry)) {
                $entry = [];
            }

            if ($locale === $base) {
                $entry['title'] = $data['title'] ?? null;
                $entry['content'] = $data['content'] ?? null;
                $entry['excerpt'] = $data['excerpt'] ?? null;
                $entry['slug'] = $data['slug'] ?? null;

                foreach ($this->seoFields as $field) {
                    if (array_key_exists($field, $data)) {
                        $entry[$field] = $data[$field];
                    }
                }
            }

            if (empty($entry['slug']) && !empty($entry['title'])) {
                $entry['slug'] = $this->makeSlug($entry['title'], $locale);
            }

            $out[$locale] = $entry;
        }

        return $out;
    }

    protected function syncTranslations(Post $post, array $translations, ?string $previousBaseSlug = null): void
    {
        $base = config('app.base_locale', config('app.locale'));
        $baseEntry = $translations[$base] ?? [];

        if ($previousBaseSlug === null) {
            $previousBaseSlug = $post->slug;
        }

        foreach ($translations as $locale => $data) {
            if (!is_string($locale) || !is_array($data)) {
                continue;
            }

            $payload = [];

            foreach (array_merge(['title', 'content', 'excerpt'], $this->seoFields) as $field) {
                if (array_key_exists($field, $data)) {
                    $value = $data[$field];

                    if (is_string($value)) {
                        $value = trim($value);
                    }

                    $payload[$field] = $value === '' ? null : $value;
                }
            }

            if ($locale !== $base) {
                foreach (array_merge(['title', 'content', 'excerpt'], $this->seoFields) as $field) {
                    if (empty($payload[$field] ?? null) && !empty($baseEntry[$field])) {
                        $payload[$field] = $baseEntry[$field];
                    }
                }
            }

            $rawSlug = trim((string) ($data['slug'] ?? ''));

            if ($rawSlug === '' && !empty($data['title'])) {
                $rawSlug = $this->makeSlug($data['title'], $locale);
            }

            if ($locale === $base) {
                if ($rawSlug !== '') {
                    $payload['slug'] = $this->uniqueSlugForLocale(
                        $rawSlug,
                        $post->type,
                        $locale,
                        $post->id
                    );
                } else {
                    $payload['slug'] = $previousBaseSlug;
                }

                if (empty($payload['title']) && !empty($post->getRawOriginal('title'))) {
                    $payload['title'] = $post->getRawOriginal('title');
                }

                if (empty($payload['content']) && !empty($post->getRawOriginal('content'))) {
                    $payload['content'] = $post->getRawOriginal('content');
                }
            } else {
                $existingTranslation = $post->translations->firstWhere('locale', $locale);
                $existingSlug = $existingTranslation?->slug;

                if ($rawSlug !== '') {
                    $payload['slug'] = $this->uniqueSlugForLocale(
                        $rawSlug,
                        $post->type,
                        $locale,
                        $post->id
                    );
                } elseif ($existingSlug !== null && $existingSlug !== '') {
                    $payload['slug'] = $existingSlug;
                } elseif (!empty($payload['title'])) {
                    $payload['slug'] = $this->uniqueSlugForLocale(
                        $payload['title'],
                        $post->type,
                        $locale,
                        $post->id
                    );
                } else {
                    $payload['slug'] = null;
                }
            }

            if (empty($payload)) {
                continue;
            }

            $post->translations()->updateOrCreate(['locale' => $locale], $payload);
        }
    }

    protected function resolvePublishedAt(array $data, ?Post $existing = null)
    {
        $status = $data['status'] ?? ($existing?->status ?? 'draft');
        $publishedAt = $data['published_at'] ?? $existing?->published_at;

        if ($status === 'published' && !$publishedAt) {
            return now();
        }

        if ($status === 'draft' && !array_key_exists('published_at', $data)) {
            return $existing?->published_at;
        }

        return $publishedAt;
    }

    protected function refreshTaxonomyCounts(string $modelClass, array $ids): void
    {
        foreach ($ids as $id) {
            $term = $modelClass::find($id);

            if (!$term) continue;

            $count = $term->posts()->count();

            $term->update(['post_count' => $count]);
        }
    }

    public function stats(): array
    {
        return [
            'all' => Post::count(),
            'published' => Post::where('status', 'published')->count(),
            'draft' => Post::where('status', 'draft')->count(),
            'scheduled' => Post::where('status', 'scheduled')->count(),
            'trash' => Post::where('status', 'trash')->count(),
            'posts' => Post::where('type', 'post')->count(),
            'pages' => Post::where('type', 'page')->count(),
        ];
    }
}
