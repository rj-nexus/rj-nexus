<?php

namespace App\DynamicTags;

use App\DynamicTags\Builtin\ArchiveDescriptionTag;
use App\DynamicTags\Builtin\ArchiveTitleTag;
use App\DynamicTags\Builtin\CurrentDateTag;
use App\DynamicTags\Builtin\CurrentUserTag;
use App\DynamicTags\Builtin\CustomFieldTag;
use App\DynamicTags\Builtin\PageTitleTag;
use App\DynamicTags\Builtin\PostAuthorTag;
use App\DynamicTags\Builtin\PostContentTag;
use App\DynamicTags\Builtin\PostDateTag;
use App\DynamicTags\Builtin\PostExcerptTag;
use App\DynamicTags\Builtin\PostFeaturedImageTag;
use App\DynamicTags\Builtin\PostTermsTag;
use App\DynamicTags\Builtin\PostTitleTag;
use App\DynamicTags\Builtin\ShortcodeTag;
use App\DynamicTags\Builtin\SiteLogoTag;
use App\DynamicTags\Builtin\SiteTaglineTag;
use App\DynamicTags\Builtin\SiteTitleTag;
use App\DynamicTags\Builtin\SiteUrlTag;
use App\DynamicTags\Builtin\UrlParamTag;

class TagRegistry
{
    protected static ?array $cache = null;

    public static function discover(): array
    {
        if (static::$cache !== null) {
            return static::$cache;
        }

        static::$cache = [
            new SiteTitleTag(),
            new SiteUrlTag(),
            new SiteLogoTag(),
            new SiteTaglineTag(),
            new CurrentDateTag(),
            new CurrentUserTag(),
            new UrlParamTag(),
            new ShortcodeTag(),
            new PageTitleTag(),
            new ArchiveTitleTag(),
            new ArchiveDescriptionTag(),
            new PostTitleTag(),
            new PostContentTag(),
            new PostExcerptTag(),
            new PostFeaturedImageTag(),
            new PostDateTag(),
            new PostAuthorTag(),
            new PostTermsTag(),
            new CustomFieldTag(),
        ];

        return static::$cache;
    }

    public static function all(): array
    {
        return static::discover();
    }

    public static function get(string $id): ?BaseTag
    {
        foreach (static::discover() as $tag) {
            if ($tag->id() === $id) {
                return $tag;
            }
        }

        return null;
    }

    public static function has(string $id): bool
    {
        return static::get($id) !== null;
    }

    public static function grouped(): array
    {
        $groups = [];

        foreach (static::discover() as $tag) {
            $groups[$tag->category()][] = $tag;
        }

        return $groups;
    }

    public static function categories(): array
    {
        return [
            'site' => [
                'label' => __('Site'),
                'icon' => '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline-block; vertical-align:-2px;"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>',
            ],
            'user' => [
                'label' => __('User'),
                'icon' => '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline-block; vertical-align:-2px;"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
            ],
            'post' => [
                'label' => __('Post'),
                'icon' => '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline-block; vertical-align:-2px;"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>',
            ],
            'archive' => [
                'label' => __('Archive'),
                'icon' => '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline-block; vertical-align:-2px;"><path d="M21 8v13H3V8M1 3h22v5H1zM10 12h4"/></svg>',
            ],
        ];
    }

    public static function resolve(?string $tagId, array $options = []): string
    {
        if (!$tagId) {
            return '';
        }

        $tag = static::get($tagId);

        if (!$tag) {
            return '';
        }

        try {
            return $tag->resolve($options);
        } catch (\Throwable $e) {
            return '';
        }
    }

    public static function toArray(): array
    {
        $out = [];

        foreach (static::discover() as $tag) {
            $out[] = [
                'id' => $tag->id(),
                'name' => $tag->name(),
                'category' => $tag->category(),
                'icon' => $tag->icon(),
                'description' => $tag->description(),
                'options' => $tag->options(),
            ];
        }

        return $out;
    }

    public static function reset(): void
    {
        static::$cache = null;
    }
}
