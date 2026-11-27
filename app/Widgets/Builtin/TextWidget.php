<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

/**
 * Text widget.
 *
 * Two content modes:
 *
 *  - "simple" (default, the original behaviour): one <p> with links and a few inline tags.
 *    Widgets saved before the rich mode existed have no "content_mode" value, so they always
 *    fall back to "simple" and render exactly as before.
 *
 *  - "rich" (opt-in per widget): headings, bold/italic, lists, quotes, images and more,
 *    written with a small Markdown-like syntax or safe HTML.
 */
class TextWidget extends BaseWidget
{
    /**
     * Tags allowed in "simple" mode. Everything else is shown as plain text.
     * The value is the list of attributes that may stay on that tag.
     * (Unchanged, so existing content renders the same.)
     */
    private const ALLOWED_TAGS = [
        'a' => ['href', 'title'],
        'strong' => [],
        'b' => [],
        'em' => [],
        'i' => [],
        'u' => [],
        'br' => [],
        'code' => [],
        'mark' => [],
        'small' => [],
        'sub' => [],
        'sup' => [],
    ];

    /** Tags allowed in "rich" mode. */
    private const RICH_TAGS = [
        'a' => ['href', 'title'],
        'img' => ['src', 'alt', 'width', 'height'],
        'h1' => [], 'h2' => [], 'h3' => [], 'h4' => [], 'h5' => [], 'h6' => [],
        'p' => [],
        'ul' => [], 'ol' => [], 'li' => [],
        'blockquote' => [],
        'hr' => [],
        'strong' => [], 'b' => [],
        'em' => [], 'i' => [],
        'u' => [],
        'del' => [], 's' => [],
        'br' => [],
        'code' => [],
        'mark' => [],
        'small' => [],
        'sub' => [],
        'sup' => [],
    ];

    public function id(): string
    {
        return 'text';
    }

    public function name(): string
    {
        return __('Text');
    }

    public function icon(): string
    {
        return '<svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h10"/></svg>';
    }

    public function category(): string
    {
        return 'basic';
    }

    public function description(): string
    {
        return __('Add a paragraph of text.');
    }

    public function schema(): array
    {
        return [
            [
                'name' => 'text',
                'type' => 'textarea',
                'label' => __('Text'),
                'default' => __('Write something here.'),
                'tab' => 'content',
                'placeholder' => __('Enter your text. Links: [text](https://example.com), <a href="/page">text</a> or a plain URL.')
                    . "\n\n"
                    . __('Rich mode: # Heading, ## Subheading, **bold**, *italic*, - list, > quote, ![alt](image-url)'),
            ],
            [
                'name' => 'content_mode',
                'type' => 'select',
                'label' => __('Content Mode'),
                // Keep "simple" so nothing changes for existing widgets.
                'default' => 'simple',
                'tab' => 'content',
                'options' => [
                    'simple' => __('Simple (paragraph)'),
                    'rich' => __('Rich (headings, bold, lists, images)'),
                ],
            ],
            [
                'name' => 'image',
                'type' => 'text',
                'label' => __('Image URL (Rich mode)'),
                'default' => '',
                'tab' => 'content',
                'placeholder' => 'https://example.com/photo.jpg or /storage/photo.jpg',
            ],
            [
                'name' => 'image_alt',
                'type' => 'text',
                'label' => __('Image Alt Text (Rich mode)'),
                'default' => '',
                'tab' => 'content',
            ],
            [
                'name' => 'image_position',
                'type' => 'select',
                'label' => __('Image Position (Rich mode)'),
                'default' => 'none',
                'tab' => 'content',
                'options' => [
                    'none' => __('No image'),
                    'top' => __('Above text'),
                    'bottom' => __('Below text'),
                    'left' => __('Left of text'),
                    'right' => __('Right of text'),
                ],
            ],
            [
                'name' => 'image_width',
                'type' => 'text',
                'label' => __('Image Width (Rich mode)'),
                'default' => '',
                'tab' => 'content',
                'placeholder' => 'e.g. 300px, 40%',
            ],
            [
                'name' => 'link_color',
                'type' => 'color',
                'label' => __('Link Color'),
                'default' => '#2563eb',
                'tab' => 'content',
            ],
            [
                'name' => 'link_target',
                'type' => 'select',
                'label' => __('Open Links'),
                'default' => 'auto',
                'tab' => 'content',
                'options' => [
                    'auto' => __('Auto (external in new tab)'),
                    '_blank' => __('Always in new tab'),
                    '_self' => __('Same tab'),
                ],
            ],
            [
                'name' => 'size',
                'type' => 'select',
                'label' => __('Size'),
                'default' => 'base',
                'tab' => 'style',
                'options' => [
                    'sm' => __('Small'),
                    'base' => __('Normal'),
                    'lg' => __('Large'),
                    'xl' => __('Extra Large'),
                ],
            ],
            [
                'name' => 'align',
                'type' => 'select',
                'label' => __('Alignment'),
                'default' => 'left',
                'tab' => 'style',
                'options' => [
                    'left' => __('Left'),
                    'center' => __('Center'),
                    'right' => __('Right'),
                    'justify' => __('Justify'),
                ],
            ],
            [
                'name' => 'color',
                'type' => 'color',
                'label' => __('Text Color'),
                'default' => '#374151',
                'tab' => 'style',
            ],
            [
                'name' => 'heading_color',
                'type' => 'color',
                'label' => __('Heading Color (Rich mode)'),
                'default' => '#111827',
                'tab' => 'style',
            ],
            [
                'name' => 'block_gap',
                'type' => 'select',
                'label' => __('Space Between Blocks (Rich mode)'),
                'default' => 'normal',
                'tab' => 'style',
                'options' => [
                    'tight' => __('Tight'),
                    'normal' => __('Normal'),
                    'loose' => __('Loose'),
                ],
            ],
            [
                'name' => 'image_radius',
                'type' => 'select',
                'label' => __('Image Corners (Rich mode)'),
                'default' => 'none',
                'tab' => 'style',
                'options' => [
                    'none' => __('Square'),
                    'sm' => __('Small'),
                    'md' => __('Medium'),
                    'lg' => __('Large'),
                ],
            ],
            [
                'name' => 'font_size',
                'type' => 'text',
                'label' => __('Font Size'),
                'default' => '',
                'tab' => 'style',
                'placeholder' => 'e.g. 16px, 1rem',
            ],
            [
                'name' => 'font_weight',
                'type' => 'select',
                'label' => __('Font Weight'),
                'default' => '400',
                'tab' => 'style',
                'options' => [
                    '300' => '300',
                    '400' => '400',
                    '500' => '500',
                    '600' => '600',
                    '700' => '700',
                ],
            ],
            [
                'name' => 'line_height',
                'type' => 'text',
                'label' => __('Line Height'),
                'default' => '',
                'tab' => 'style',
                'placeholder' => 'e.g. 1.6, 24px',
            ],
            [
                'name' => 'letter_spacing',
                'type' => 'text',
                'label' => __('Letter Spacing'),
                'default' => '',
                'tab' => 'style',
                'placeholder' => 'e.g. 0.5px, 0.02em',
            ],
            [
                'name' => 'text_transform',
                'type' => 'select',
                'label' => __('Text Transform'),
                'default' => 'none',
                'tab' => 'style',
                'options' => [
                    'none' => __('None'),
                    'uppercase' => __('Uppercase'),
                    'lowercase' => __('Lowercase'),
                    'capitalize' => __('Capitalize'),
                ],
            ],
            [
                'name' => 'padding_dim',
                'type' => 'dimensions',
                'label' => __('Padding'),
                'default' => ['top' => '', 'right' => '', 'bottom' => '', 'left' => '', 'unit' => 'px', 'linked' => false],
                'tab' => 'style',
            ],
            [
                'name' => 'margin_dim',
                'type' => 'dimensions',
                'label' => __('Margin'),
                'default' => ['top' => '', 'right' => '', 'bottom' => '', 'left' => '', 'unit' => 'px', 'linked' => false],
                'tab' => 'style',
            ],
        ];
    }

    public function render(array $settings): string
    {
        $text = (string) ($settings['text'] ?? '');
        $rich = $this->isRich($settings);
        $hasImage = $rich && trim((string) ($settings['image'] ?? '')) !== '';

        if ($text === '' && !$hasImage) {
            return '';
        }

        $sizes = [
            'sm' => '0.875rem',
            'base' => '1rem',
            'lg' => '1.125rem',
            'xl' => '1.25rem',
        ];

        $styles = [];

        if (!empty($settings['color'])) {
            $styles[] = 'color:' . $this->escape($settings['color']);
        }

        if (!empty($settings['font_size'])) {
            $styles[] = 'font-size:' . $this->escape($settings['font_size']);
        } elseif (!empty($settings['size']) && isset($sizes[$settings['size']])) {
            $styles[] = 'font-size:' . $sizes[$settings['size']];
        }

        if (!empty($settings['font_weight'])) {
            $styles[] = 'font-weight:' . $this->escape($settings['font_weight']);
        }

        if (!empty($settings['line_height'])) {
            $styles[] = 'line-height:' . $this->escape($settings['line_height']);
        } else {
            $styles[] = 'line-height:1.6';
        }

        if (!empty($settings['letter_spacing'])) {
            $styles[] = 'letter-spacing:' . $this->escape($settings['letter_spacing']);
        }

        if (!empty($settings['text_transform']) && $settings['text_transform'] !== 'none') {
            $styles[] = 'text-transform:' . $this->escape($settings['text_transform']);
        }

        if (!empty($settings['align'])) {
            $styles[] = 'text-align:' . $this->escape($settings['align']);
        }

        $padding = $this->dimensionCss($settings, 'padding_dim');
        if ($padding !== '') {
            $styles[] = 'padding:' . $padding;
        }

        $margin = $this->dimensionCss($settings, 'margin_dim');
        if ($margin !== '') {
            $styles[] = 'margin:' . $margin;
        }

        $bg = $this->backgroundCss($settings);
        if ($bg !== '') {
            $styles[] = rtrim($bg, ';');
        }

        $shadow = $this->boxShadowCss($settings['box_shadow'] ?? null);
        if ($shadow !== '') {
            $styles[] = rtrim($shadow, ';');
        }

        if ($rich) {
            // Contains floated images, so the box must wrap them.
            $styles[] = 'display:flow-root';
        }

        $attrs = [];

        if (!empty($styles)) {
            $attrs['style'] = implode(';', $styles);
        }

        $id = $this->cssId($settings);
        if ($id !== '') {
            $attrs['id'] = $id;
        }

        $class = $this->cssClass($settings);
        if ($class !== '') {
            $attrs['class'] = $class;
        }

        if ($rich) {
            [$before, $after] = $this->featuredImage($settings);
            $body = $text === '' ? '' : $this->formatRich($text, $settings);

            // A <div> is used because headings and lists cannot live inside a <p>.
            $html = '<div' . $this->attr($attrs) . '>' . $before . $body . $after . '</div>';
        } else {
            $safeText = $this->formatText($text, $settings);
            $html = '<p' . $this->attr($attrs) . '>' . $safeText . '</p>';
        }

        return $this->applyAnimation($html, $settings);
    }

    /** Only widgets that explicitly chose "rich" use it. Missing value means "simple". */
    private function isRich(array $settings): bool
    {
        return ($settings['content_mode'] ?? 'simple') === 'rich';
    }

    /* ---------------------------------------------------------------
     |  Simple mode (original behaviour, unchanged)
     | ------------------------------------------------------------- */

    /**
     * Turns the raw textarea value into safe HTML.
     *
     * Supported:
     *  - Markdown links:            [text](https://example.com)
     *  - HTML links:                <a href="/about">text</a>
     *  - Plain URLs:                https://example.com, www.example.com
     *  - Inline tags:               <strong> <b> <em> <i> <u> <br> <code> <mark> <small> <sub> <sup>
     *
     * Any other tag (script, img, iframe, ...) is shown as plain text,
     * all event attributes and unsafe URL schemes (javascript:, data:, ...) are removed.
     */
    private function formatText(string $text, array $settings): string
    {
        $original = $text;

        // 1. [text](url) -> <a href="url">text</a>
        $text = preg_replace_callback(
            '/\[([^\]\r\n]+)\]\(([^)\s]+)\)/u',
            fn (array $m) => '<a href="' . htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8') . '">' . $m[1] . '</a>',
            $text
        ) ?? $text;

        // 2. Every "<" that is not a real allowed tag becomes plain text,
        //    so "a<b and 3 <3" or "<img onerror=...>" stay harmless text.
        $simple = implode('|', array_diff(array_keys(self::ALLOWED_TAGS), ['a']));
        $text = preg_replace(
            '~<(?!/(?:' . $simple . '|a)\s*>|(?:' . $simple . ')\s*/?>|a\s[^<>]*>)~i',
            '&lt;',
            $text
        ) ?? $text;

        // 3. Parse, sanitize, auto-link and decorate links.
        $previous = libxml_use_internal_errors(true);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $loaded = $dom->loadHTML(
            '<?xml encoding="UTF-8"><div>' . $text . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $loaded ? $dom->getElementsByTagName('div')->item(0) : null;

        if (!$root instanceof \DOMElement) {
            return nl2br($this->escape($original));
        }

        $this->sanitizeChildren($root, $dom, false);
        $this->decorateLinks($root, $settings);

        $html = '';
        foreach ($root->childNodes as $child) {
            $html .= $dom->saveHTML($child);
        }

        return nl2br($html);
    }

    /* ---------------------------------------------------------------
     |  Rich mode
     | ------------------------------------------------------------- */

    /**
     * Rich syntax (all optional):
     *
     *   # Heading 1   ## Heading 2   ### Heading 3   #### Heading 4
     *   **bold**   *italic*   ~~strikethrough~~   `code`
     *   - bullet item          1. numbered item
     *   > quote                --- (divider line)
     *   [link text](https://example.com)
     *   ![alt text](https://example.com/image.jpg)
     *
     * Safe HTML is accepted too (h1-h6, p, ul, ol, li, blockquote, hr, img, a, strong, em ...).
     * Anything else is shown as plain text. Event attributes and unsafe URLs are removed.
     */
    private function formatRich(string $text, array $settings): string
    {
        $original = $text;

        $text = $this->markdownToHtml($text);

        // Every "<" that is not an allowed tag becomes plain text.
        $simple = implode('|', array_diff(array_keys(self::RICH_TAGS), ['a', 'img']));
        $text = preg_replace(
            '~<(?!/(?:' . $simple . '|a)\s*>|(?:' . $simple . ')\s*/?>|(?:a|img)\s[^<>]*>)~i',
            '&lt;',
            $text
        ) ?? $text;

        $previous = libxml_use_internal_errors(true);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $loaded = $dom->loadHTML(
            '<?xml encoding="UTF-8"><div>' . $text . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $loaded ? $dom->getElementsByTagName('div')->item(0) : null;

        if (!$root instanceof \DOMElement) {
            return nl2br($this->escape($original));
        }

        $this->sanitizeChildren($root, $dom, false, self::RICH_TAGS);
        $this->decorateLinks($root, $settings);
        $this->decorateRich($root, $settings);

        $html = '';
        foreach ($root->childNodes as $child) {
            $html .= $dom->saveHTML($child);
        }

        return $html;
    }

    /** Converts the block syntax (headings, lists, quotes, paragraphs) to HTML. */
    private function markdownToHtml(string $text): string
    {
        // \x1A is used internally as a placeholder marker, so it must not come from the user.
        $text = str_replace("\x1A", '', str_replace(["\r\n", "\r"], "\n", $text));

        $html = [];
        $kind = null;       // p, q, ul, ol
        $para = [];
        $quote = [];
        $items = [];

        $flush = function () use (&$html, &$kind, &$para, &$quote, &$items): void {
            if ($kind === 'p' && $para) {
                $html[] = '<p>' . implode('<br>', $para) . '</p>';
            } elseif ($kind === 'q' && $quote) {
                $html[] = '<blockquote>' . implode('<br>', $quote) . '</blockquote>';
            } elseif (($kind === 'ul' || $kind === 'ol') && $items) {
                $html[] = '<' . $kind . '>'
                    . implode('', array_map(fn (string $i) => '<li>' . $i . '</li>', $items))
                    . '</' . $kind . '>';
            }

            $kind = null;
            $para = [];
            $quote = [];
            $items = [];
        };

        foreach (explode("\n", $text) as $line) {
            $line = rtrim($line);

            if (trim($line) === '') {
                $flush();
                continue;
            }

            // Headings: # to ######
            if (preg_match('/^\s{0,3}(#{1,6})\s+(.+?)\s*$/u', $line, $m)) {
                $flush();
                $n = strlen($m[1]);
                $html[] = '<h' . $n . '>' . $this->inlineMarkdown($m[2]) . '</h' . $n . '>';
                continue;
            }

            // Divider: --- *** ___
            if (preg_match('/^\s{0,3}([-*_])(?:\s*\1){2,}\s*$/', $line)) {
                $flush();
                $html[] = '<hr>';
                continue;
            }

            // Quote
            if (preg_match('/^\s{0,3}>\s?(.*)$/u', $line, $m)) {
                if ($kind !== 'q') {
                    $flush();
                    $kind = 'q';
                }
                $quote[] = $this->inlineMarkdown($m[1]);
                continue;
            }

            // Bullet list
            if (preg_match('/^\s{0,3}[-*+]\s+(.+)$/u', $line, $m)) {
                if ($kind !== 'ul') {
                    $flush();
                    $kind = 'ul';
                }
                $items[] = $this->inlineMarkdown($m[1]);
                continue;
            }

            // Numbered list
            if (preg_match('/^\s{0,3}\d{1,3}[.)]\s+(.+)$/u', $line, $m)) {
                if ($kind !== 'ol') {
                    $flush();
                    $kind = 'ol';
                }
                $items[] = $this->inlineMarkdown($m[1]);
                continue;
            }

            // A line that already starts with a block-level HTML tag is kept as written
            // (it is sanitized later like everything else).
            if (preg_match('~^\s*</?(?:h[1-6]|p|ul|ol|li|blockquote|hr)\b~i', $line)) {
                $flush();
                $html[] = $line;
                continue;
            }

            // Normal paragraph text (consecutive lines stay in one paragraph with line breaks)
            if ($kind !== 'p') {
                $flush();
                $kind = 'p';
            }
            $para[] = $this->inlineMarkdown($line);
        }

        $flush();

        return implode("\n", $html);
    }

    /** Converts inline syntax: `code`, images, links, bold, italic, strikethrough. */
    private function inlineMarkdown(string $s): string
    {
        $tokens = [];
        $stash = function (string $html) use (&$tokens): string {
            $tokens[] = $html;

            return "\x1A" . (count($tokens) - 1) . "\x1A";
        };
        $h = static fn (string $v): string => htmlspecialchars($v, ENT_QUOTES, 'UTF-8');

        // `code` (its content is never formatted further)
        $s = preg_replace_callback(
            '/`([^`\r\n]+)`/u',
            fn (array $m) => $stash('<code>' . htmlspecialchars($m[1], ENT_NOQUOTES, 'UTF-8') . '</code>'),
            $s
        ) ?? $s;

        // ![alt](url)
        $s = preg_replace_callback(
            '/!\[([^\]\r\n]*)\]\(([^)\s]+)\)/u',
            fn (array $m) => $stash('<img src="' . $h($m[2]) . '" alt="' . $h($m[1]) . '">'),
            $s
        ) ?? $s;

        // [text](url)
        $s = preg_replace_callback(
            '/\[([^\]\r\n]+)\]\(([^)\s]+)\)/u',
            fn (array $m) => $stash('<a href="' . $h($m[2]) . '">' . $this->emphasis($m[1]) . '</a>'),
            $s
        ) ?? $s;

        $s = $this->emphasis($s);

        // Put the stashed pieces back (a link text can contain a stashed code piece).
        for ($i = 0; $i < 3 && str_contains($s, "\x1A"); $i++) {
            $s = preg_replace_callback(
                '/\x1A(\d+)\x1A/',
                fn (array $m) => $tokens[(int) $m[1]] ?? '',
                $s
            ) ?? $s;
        }

        return $s;
    }

    private function emphasis(string $s): string
    {
        // **bold**
        $s = preg_replace('/\*\*(?=\S)(.+?)(?<=\S)\*\*/us', '<strong>$1</strong>', $s) ?? $s;
        // ~~strikethrough~~
        $s = preg_replace('/~~(?=\S)(.+?)(?<=\S)~~/us', '<del>$1</del>', $s) ?? $s;
        // *italic*
        $s = preg_replace('/(?<![*\w])\*(?=\S)([^*\r\n]+?)(?<=\S)\*(?![*\w])/u', '<em>$1</em>', $s) ?? $s;
        // _italic_ (not inside words, so snake_case and URLs are safe)
        $s = preg_replace('/(?<![\w_])_(?=\S)([^_\r\n]+?)(?<=\S)_(?![\w_])/u', '<em>$1</em>', $s) ?? $s;

        return $s;
    }

    /** Explicit inline styles are needed because the theme's CSS reset removes default styling. */
    private function decorateRich(\DOMElement $root, array $settings): void
    {
        $gap = $this->blockGap($settings);
        $radius = $this->imageRadius($settings);
        $headingColor = $this->safeColor((string) ($settings['heading_color'] ?? ''));

        $headings = [
            'h1' => '2em',
            'h2' => '1.6em',
            'h3' => '1.3em',
            'h4' => '1.15em',
            'h5' => '1em',
            'h6' => '0.9em',
        ];

        foreach (iterator_to_array($root->getElementsByTagName('*')) as $el) {
            $tag = strtolower($el->tagName);
            $inItem = $el->parentNode instanceof \DOMElement && strtolower($el->parentNode->tagName) === 'li';

            $style = match (true) {
                isset($headings[$tag]) => 'font-size:' . $headings[$tag]
                    . ';font-weight:700;line-height:1.25;margin:1.4em 0 0.5em'
                    . ($headingColor !== '' ? ';color:' . $headingColor : ''),
                $tag === 'p' => 'margin:0 0 ' . $gap,
                $tag === 'ul', $tag === 'ol' => ($inItem ? 'margin:0.4em 0 0' : 'margin:0 0 ' . $gap)
                    . ';padding-left:1.5em;list-style:' . ($tag === 'ul' ? 'disc' : 'decimal'),
                $tag === 'li' => 'margin:0 0 0.35em',
                $tag === 'blockquote' => 'margin:0 0 ' . $gap
                    . ';padding:0.2em 0 0.2em 1em;border-left:4px solid rgba(0,0,0,0.18);opacity:0.9',
                $tag === 'hr' => 'border:0;border-top:1px solid rgba(0,0,0,0.15);margin:1.5em 0',
                $tag === 'code' => 'font-family:ui-monospace,SFMono-Regular,Menlo,Consolas,monospace;'
                    . 'font-size:0.9em;background:rgba(0,0,0,0.06);padding:0.15em 0.4em;border-radius:4px',
                $tag === 'img' => 'max-width:100%;height:auto;vertical-align:middle'
                    . ($radius !== '' ? ';border-radius:' . $radius : ''),
                default => '',
            };

            if ($style !== '') {
                $el->setAttribute('style', $style);
            }

            if ($tag === 'img') {
                $el->setAttribute('loading', 'lazy');
                $el->setAttribute('decoding', 'async');
            }
        }

        // No extra space above the first block and below the last block.
        $blocks = ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'ul', 'ol', 'blockquote'];

        $first = $root->firstElementChild;
        if ($first instanceof \DOMElement && in_array(strtolower($first->tagName), $blocks, true)) {
            $first->setAttribute('style', $first->getAttribute('style') . ';margin-top:0');
        }

        $last = $root->lastElementChild;
        if ($last instanceof \DOMElement && in_array(strtolower($last->tagName), $blocks, true)) {
            $last->setAttribute('style', $last->getAttribute('style') . ';margin-bottom:0');
        }
    }

    /**
     * Image set in the widget settings.
     *
     * @return array{0: string, 1: string} HTML placed before and after the text
     */
    private function featuredImage(array $settings): array
    {
        $src = trim((string) ($settings['image'] ?? ''));
        $position = (string) ($settings['image_position'] ?? 'none');

        if ($src === '' || !in_array($position, ['top', 'bottom', 'left', 'right'], true) || !$this->isSafeImageUrl($src)) {
            return ['', ''];
        }

        $gap = $this->blockGap($settings);
        $radius = $this->imageRadius($settings);
        $width = $this->safeLength((string) ($settings['image_width'] ?? ''));

        $style = 'max-width:100%;height:auto;' . ($radius !== '' ? 'border-radius:' . $radius . ';' : '');

        switch ($position) {
            case 'left':
                $style .= 'float:left;width:' . ($width !== '' ? $width : '40%') . ';margin:0 1.2em 0.8em 0;';
                break;
            case 'right':
                $style .= 'float:right;width:' . ($width !== '' ? $width : '40%') . ';margin:0 0 0.8em 1.2em;';
                break;
            case 'bottom':
                $style .= 'display:block;' . ($width !== '' ? 'width:' . $width . ';' : '') . 'margin:' . $gap . ' 0 0;';
                break;
            default: // top
                $style .= 'display:block;' . ($width !== '' ? 'width:' . $width . ';' : '') . 'margin:0 0 ' . $gap . ';';
        }

        $img = '<img src="' . htmlspecialchars($src, ENT_QUOTES, 'UTF-8') . '"'
            . ' alt="' . htmlspecialchars((string) ($settings['image_alt'] ?? ''), ENT_QUOTES, 'UTF-8') . '"'
            . ' style="' . $style . '" loading="lazy" decoding="async">';

        return $position === 'bottom' ? ['', $img] : [$img, ''];
    }

    private function blockGap(array $settings): string
    {
        $gaps = ['tight' => '0.5em', 'normal' => '1em', 'loose' => '1.6em'];

        return $gaps[(string) ($settings['block_gap'] ?? 'normal')] ?? '1em';
    }

    private function imageRadius(array $settings): string
    {
        $radii = ['none' => '', 'sm' => '6px', 'md' => '12px', 'lg' => '20px'];

        return $radii[(string) ($settings['image_radius'] ?? 'none')] ?? '';
    }

    /** Accepts values like 300, 300px, 40%, 20rem. Returns '' when invalid. */
    private function safeLength(string $value): string
    {
        $value = trim($value);

        if (preg_match('/^\d+(?:\.\d+)?$/', $value)) {
            return $value . 'px';
        }

        if (preg_match('/^\d+(?:\.\d+)?(?:px|%|rem|em|vw|vh)$/i', $value)) {
            return $value;
        }

        return '';
    }

    /* ---------------------------------------------------------------
     |  Shared sanitizing helpers
     | ------------------------------------------------------------- */

    /**
     * @param array<string, string[]> $allowed tag => allowed attributes
     */
    private function sanitizeChildren(\DOMNode $node, \DOMDocument $dom, bool $insideLink, array $allowed = self::ALLOWED_TAGS): void
    {
        $children = [];
        foreach ($node->childNodes as $child) {
            $children[] = $child;
        }

        foreach ($children as $child) {
            if ($child instanceof \DOMText) {
                if (!$insideLink) {
                    $this->autoLinkTextNode($child, $dom);
                }
                continue;
            }

            // Comments, processing instructions, etc.
            if (!$child instanceof \DOMElement) {
                $node->removeChild($child);
                continue;
            }

            $tag = strtolower($child->tagName);

            // Not allowed: keep its text, drop the tag.
            if (!isset($allowed[$tag])) {
                $this->sanitizeChildren($child, $dom, $insideLink, $allowed);
                $this->unwrap($child);
                continue;
            }

            foreach (iterator_to_array($child->attributes) as $attr) {
                if (!in_array(strtolower($attr->name), $allowed[$tag], true)) {
                    $child->removeAttribute($attr->name);
                }
            }

            if ($tag === 'img') {
                $src = trim($child->getAttribute('src'));

                if (!$this->isSafeImageUrl($src)) {
                    $node->removeChild($child);
                    continue;
                }

                $child->setAttribute('src', $src);

                foreach (['width', 'height'] as $dimension) {
                    if ($child->hasAttribute($dimension) && !preg_match('/^\d{1,4}$/', $child->getAttribute($dimension))) {
                        $child->removeAttribute($dimension);
                    }
                }
                continue;
            }

            if ($tag === 'a') {
                $href = trim($child->getAttribute('href'));

                if (!$this->isSafeUrl($href)) {
                    $this->sanitizeChildren($child, $dom, true, $allowed);
                    $this->unwrap($child);
                    continue;
                }

                $child->setAttribute('href', $href);
                $this->sanitizeChildren($child, $dom, true, $allowed);
                continue;
            }

            $this->sanitizeChildren($child, $dom, $insideLink, $allowed);
        }
    }

    /** Replace an element with its children. */
    private function unwrap(\DOMElement $element): void
    {
        $parent = $element->parentNode;

        while ($element->firstChild) {
            $parent->insertBefore($element->firstChild, $element);
        }

        $parent->removeChild($element);
    }

    /** Wrap bare URLs (https://..., www....) found inside a text node in <a> tags. */
    private function autoLinkTextNode(\DOMText $node, \DOMDocument $dom): void
    {
        $value = $node->nodeValue;

        if (!preg_match_all('~(?:https?://|www\.)[^\s<>"\']+~iu', $value, $matches, PREG_OFFSET_CAPTURE)) {
            return;
        }

        $fragment = $dom->createDocumentFragment();
        $offset = 0;

        foreach ($matches[0] as [$url, $pos]) {
            // Do not swallow trailing punctuation: "see https://x.com."
            $clean = rtrim($url, '.,;:!?)]}\'"');

            if ($clean === '' || $clean === 'http://' || $clean === 'https://') {
                continue;
            }

            $fragment->appendChild($dom->createTextNode(substr($value, $offset, $pos - $offset)));

            $a = $dom->createElement('a');
            $a->setAttribute('href', stripos($clean, 'www.') === 0 ? 'https://' . $clean : $clean);
            $a->appendChild($dom->createTextNode($clean));
            $fragment->appendChild($a);

            $offset = $pos + strlen($clean);
        }

        $fragment->appendChild($dom->createTextNode(substr($value, $offset)));
        $node->parentNode->replaceChild($fragment, $node);
    }

    /** Only http(s), mailto, tel, anchors and relative URLs are allowed. */
    private function isSafeUrl(string $url): bool
    {
        if ($url === '') {
            return false;
        }

        // Browsers ignore control characters/spaces inside the scheme ("java\nscript:").
        $clean = preg_replace('/[\x00-\x20\x7F]+/', '', $url) ?? '';

        if (preg_match('/^(?:https?:|mailto:|tel:)/i', $clean)) {
            return true;
        }

        if (preg_match('/^(?:\/|#|\?|\.\.?\/)/', $clean)) {
            return true;
        }

        // No scheme at all (e.g. "about/team") is a relative link.
        return !preg_match('/^[a-z][a-z0-9+.\-]*:/i', $clean);
    }

    /** Images: http(s) and relative paths only. No data:, javascript:, etc. */
    private function isSafeImageUrl(string $url): bool
    {
        if ($url === '') {
            return false;
        }

        $clean = preg_replace('/[\x00-\x20\x7F]+/', '', $url) ?? '';

        if ($clean === '') {
            return false;
        }

        if (preg_match('/^https?:\/\//i', $clean)) {
            return true;
        }

        // Anything else with a scheme (data:, javascript:, file:, ...) is rejected.
        return !preg_match('/^[a-z][a-z0-9+.\-]*:/i', $clean);
    }

    private function decorateLinks(\DOMElement $root, array $settings): void
    {
        $color = $this->safeColor((string) ($settings['link_color'] ?? '#2563eb'));
        $mode = (string) ($settings['link_target'] ?? 'auto');
        $currentHost = $this->currentHost();

        foreach (iterator_to_array($root->getElementsByTagName('a')) as $a) {
            $href = $a->getAttribute('href');

            // Tailwind's reset removes link styling, so style the link explicitly.
            $style = [];
            if ($color !== '') {
                $style[] = 'color:' . $color;
            }
            $style[] = 'text-decoration:underline';
            $a->setAttribute('style', implode(';', $style));

            $isAnchor = str_starts_with($href, '#');
            $isContact = (bool) preg_match('/^(?:mailto|tel):/i', $href);

            $openNew = !$isAnchor
                && !$isContact
                && ($mode === '_blank' || ($mode === 'auto' && $this->isExternal($href, $currentHost)));

            if ($openNew) {
                $a->setAttribute('target', '_blank');
                $a->setAttribute('rel', 'noopener noreferrer');
            } else {
                $a->removeAttribute('target');
                $a->removeAttribute('rel');
            }
        }
    }

    private function isExternal(string $href, string $currentHost): bool
    {
        $host = parse_url(str_starts_with($href, '//') ? 'https:' . $href : $href, PHP_URL_HOST);

        if (!is_string($host) || $host === '') {
            return false; // relative link
        }

        $strip = static fn (string $h): string => preg_replace('/^www\./i', '', $h) ?? $h;

        return strcasecmp($strip($host), $strip($currentHost)) !== 0;
    }

    private function currentHost(): string
    {
        try {
            return (string) request()->getHost();
        } catch (\Throwable) {
            return '';
        }
    }

    /** Accepts #hex, rgb()/rgba() and simple color names only. */
    private function safeColor(string $color): string
    {
        $color = trim($color);

        if (preg_match('/^(?:#[0-9a-fA-F]{3,8}|[a-zA-Z]+|rgba?\([\d\s.,%]+\))$/', $color)) {
            return $color;
        }

        return '';
    }
}