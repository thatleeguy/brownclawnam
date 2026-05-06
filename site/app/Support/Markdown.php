<?php

namespace App\Support;

use Illuminate\Support\HtmlString;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class Markdown
{
    protected static ?GithubFlavoredMarkdownConverter $converter = null;

    public static function render(?string $markdown): HtmlString
    {
        if (! $markdown) {
            return new HtmlString('');
        }

        self::$converter ??= new GithubFlavoredMarkdownConverter([
            'html_input'         => 'escape',
            'allow_unsafe_links' => false,
            'max_nesting_level'  => 12,
        ]);

        return new HtmlString(self::$converter->convert($markdown)->getContent());
    }
}
