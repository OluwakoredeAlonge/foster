<?php

namespace App\Helpers;

class ContentHelper
{
    /**
     * Render blog post content for the public view.
     *
     * Plain-text spacing rules (no HTML block tags present):
     *   · Enter x2  (1 blank line)  → normal paragraph gap
     *   · Enter x3  (2 blank lines) → wide paragraph gap  (approx 2x spacing)
     *   · Enter x4+ (3+ blank lines) → extra-wide gap       (approx 3x spacing)
     *   · Enter x1  (same paragraph) → <br> line break
     *
     * If block-level HTML is detected the content is returned as-is.
     */
    public static function render(?string $content): string
    {
        if (! $content) {
            return '';
        }

        // If content already has block-level HTML, trust it as-is.
        if (preg_match('/<(p|h[1-6]|div|ul|ol|blockquote|pre|hr)\b/i', $content)) {
            return $content;
        }

        // Normalise line endings.
        $content = str_replace("\r\n", "\n", $content);

        // Split keeping the separators (PREG_SPLIT_DELIM_CAPTURE).
        $chunks = preg_split('/([\n][ \t]*[\n][\n \t]*)/', trim($content), -1, PREG_SPLIT_DELIM_CAPTURE);

        $html = '';
        for ($i = 0; $i < count($chunks); $i++) {
            if ($i % 2 === 0) {
                $para = trim($chunks[$i]);
                if ($para === '') {
                    continue;
                }

                $blankLines = 0;
                if ($i > 0 && isset($chunks[$i - 1])) {
                    $blankLines = max(0, substr_count($chunks[$i - 1], "\n") - 1);
                }

                $style = self::spacingStyle($blankLines);

                $para = nl2br(htmlspecialchars($para, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
                $para = self::restoreInlineTags($para);

                $html .= '<p'.($style ? ' style="'.$style.'"' : '').'>'.$para.'</p>'."\n";
            }
        }

        return $html ?: '<p>'.nl2br(htmlspecialchars($content, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')).'</p>';
    }

    /**
     * Map blank-line count to an inline margin-top style.
     */
    private static function spacingStyle(int $blankLines): string
    {
        return match (true) {
            $blankLines >= 3 => 'margin-top:4rem;',
            $blankLines === 2 => 'margin-top:2.5rem;',
            default => '',
        };
    }

    /**
     * After HTML-escaping the plain text we need to put back any safe inline
     * tags the user inserted via the toolbar (a, strong, em, code, etc.).
     */
    private static function restoreInlineTags(string $escaped): string
    {
        $allowed = ['a', 'strong', 'em', 'code', 'mark', 'u', 's', 'abbr', 'span', 'br', 'i', 'b'];
        $pattern = '&lt;(\/?)('.implode('|', $allowed).')(\b[^&]*)?&gt;';

        return preg_replace_callback('/'.$pattern.'/i', function ($m) {
            $close = $m[1];
            $tag = strtolower($m[2]);
            $attrs = isset($m[3]) ? html_entity_decode($m[3], ENT_QUOTES, 'UTF-8') : '';

            // Sanitise href — only allow http(s) and relative paths.
            if (preg_match('/\bhref\s*=\s*["\']([^"\']*)["\']/', $attrs, $hm)) {
                $href = $hm[1];
                if (! preg_match('/^https?:\/\//i', $href) && ! str_starts_with($href, '/')) {
                    $attrs = '';
                }
            }

            return '<'.$close.$tag.($attrs ? ' '.trim($attrs) : '').'>';
        }, $escaped);
    }
}
