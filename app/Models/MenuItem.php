<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'rj_menu_items';

    protected $fillable = [
        'menu_id',
        'parent_id',
        'type',
        'label',
        'translations',
        'url',
        'target',
        'object_id',
        'object_type',
        'sort_order',
        'css_class',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'translations' => 'array',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order');
    }

    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    public static function types(): array
    {
        return [
            'custom' => [
                'label' => __('Custom Link'),
                'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>',
            ],
            'page' => [
                'label' => __('Page'),
                'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
            ],
            'post' => [
                'label' => __('Post'),
                'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>',
            ],
            'category' => [
                'label' => __('Category'),
                'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>',
            ],
            'tag' => [
                'label' => __('Tag'),
                'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5a2 2 0 011.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>',
            ],
        ];
    }

    public function typeLabel(): string
    {
        return static::types()[$this->type]['label'] ?? $this->type;
    }

    public function labelFor(?string $locale = null): string
    {
        $locale = $locale ?: app()->getLocale();

        if ($locale === config('app.locale')) {
            return $this->label;
        }

        $t = $this->translations[$locale] ?? null;

        return $t ?: $this->label;
    }

    public function resolvedUrl(): string
    {
        if ($this->type === 'custom' && $this->url) {
            return $this->url;
        }

        if ($this->type === 'category' && $this->object_id) {
            $cat = Category::find($this->object_id);

            if ($cat) {
                return url('/category/' . $cat->slug);
            }
        }

        if ($this->type === 'tag' && $this->object_id) {
            $tag = Tag::find($this->object_id);

            if ($tag) {
                return url('/tag/' . $tag->slug);
            }
        }

        if ($this->url) {
            return $this->url;
        }

        return '#';
    }
}
