<?php

namespace App\Widgets\Builtin;

use App\Widgets\BaseWidget;

class TextWidget extends BaseWidget
{
    /**
     * Tags allowed inside the text. Everything else is shown as plain text.
     * The value is the list of attributes that may stay on that tag.
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
                'placeholder' => __('Enter your text. Links: [text](https://example.com), <a href="/page">text</a> or a plain URL.'),
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
        $text = $settings['text'] ?? '';

        if ($text === '') {
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

        $safeText = $this->formatText($text, $settings);
        $html = '<p' . $this->attr($attrs) . '>' . $safeText . '</p>';

        return $this->applyAnimation($html, $settings);
    }

    /* ---------------------------------------------------------------
     |  Rich text handling (links and basic inline formatting)
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

    private function sanitizeChildren(\DOMNode $node, \DOMDocument $dom, bool $insideLink): void
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
            if (!isset(self::ALLOWED_TAGS[$tag])) {
                $this->sanitizeChildren($child, $dom, $insideLink);
                $this->unwrap($child);
                continue;
            }

            foreach (iterator_to_array($child->attributes) as $attr) {
                if (!in_array(strtolower($attr->name), self::ALLOWED_TAGS[$tag], true)) {
                    $child->removeAttribute($attr->name);
                }
            }

            if ($tag === 'a') {
                $href = trim($child->getAttribute('href'));

                if (!$this->isSafeUrl($href)) {
                    $this->sanitizeChildren($child, $dom, true);
                    $this->unwrap($child);
                    continue;
                }

                $child->setAttribute('href', $href);
                $this->sanitizeChildren($child, $dom, true);
                continue;
            }

            $this->sanitizeChildren($child, $dom, $insideLink);
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