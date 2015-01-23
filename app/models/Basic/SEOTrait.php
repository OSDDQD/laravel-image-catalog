<?php

namespace Basic;

use Patchwork\Utf8;

trait SEOTrait
{

    public static function makeSEOString($value)
    {
        $value = Utf8::toAscii(transliterator_transliterate("Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();", $value));
        $separator = '-';

        // Convert all dashes/underscores into separator
        $flip = $separator == '-' ? '_' : '-';

        $value = preg_replace('![' . preg_quote($flip) . ']+!u', $separator, $value);

        // Remove all characters that are not the separator, letters, numbers, or whitespace.
        $value = preg_replace('![^' . preg_quote($separator) . '\pL\pN\s]+!u', '', mb_strtolower($value));

        // Replace all separator characters and whitespace by a single separator
        $value = preg_replace('![' . preg_quote($separator) . '\s]+!u', $separator, $value);

        return trim($value, $separator);
    }

}