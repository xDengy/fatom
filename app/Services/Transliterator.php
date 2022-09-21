<?php
/**
 * @created apr 15 2022 12:01
 * @author Evgeny Berezhnoy svd22286@gmail.com
 */
namespace App\Services;

/**
 * Class Transliterator
 *
 * Auxiliary class that translate symbols from cyrillic to latin
 *
 * Usage
 *
 * ```php
 * $transliterator = $app->get(\App\Service\Transliterator::class);
 * $transliterated = $transliterator->transliterate('Некоторый текст на кириллице');
 * ```
 *
 * @package App\Service
 */
final class Transliterator
{
    private array $mappings = [
        [
            'ж',  'ч',  'щ',   'ш',  'ю',  'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й',
            'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ъ', 'ь', 'я',
            'Ж',  'Ч',  'Щ',   'Ш',  'Ю',  'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й',
            'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ъ', 'Ь', 'Я',
        ],
        [
            'zh', 'ch', 'sh`', 'sh', 'yu', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j',
            'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'y', 'x', 'q',
            'Zh', 'Ch', 'Sh`', 'Sh', 'Yu', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'J',
            'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'c', 'Y', 'X', 'Q',
        ]
    ];

    /**
     * @param string $text
     * @param bool $direction
     * @param string $emptyReplacement Symbol that replaces empty string
     * @param bool $camelCase Use the camel case format when empty string replacement on ''
     * @return string
     */
    public function transliterate(string $text, bool $direction = true, string $emptyReplacement = '', bool $camelCase = true): string
    {
        $text = str_replace('ы', '', $text);
        $text = str_replace('Ы', '', $text);

        $newText = '';
        $counter = 0;
        if (mb_strpos($text, ' ') !== false) {
            $text = explode(' ', $text);

            foreach ($text as $s) {
                $s = $this->_transliterate($s, $direction);

                if ($emptyReplacement === '' && $camelCase) {
                    if ($counter === 0) {
                        //just append first world
                        $newText .= $s;
                        $counter++;
                        continue;
                    } else {
                        $newText .= ucfirst($s);
                        $counter++;
                    }
                } else {
                    if ($counter != count($text) - 1) {
                        $newText .= $s . $emptyReplacement;
                    } else {
                        $newText .= $s;
                    }

                    $counter++;
                }
            }
        }

        if ($counter === 0) {
            $text = $this->_transliterate($text, $direction);
        }
        $text = $newText ?: $text;

        return $newText ?: $text;
    }

    /**
     * Auxiliary method to transliterate part of string (1 world in named column, table...)
     *
     * @param string $s
     * @param bool $direction
     * @return string
     */
    private function _transliterate(string $s, bool $direction): string
    {
        if ($direction) {
            $s = str_replace($this->mappings[0], $this->mappings[1], $s);
        } else {
            $s = str_replace($this->mappings[1], $this->mappings[0], $s);
        }
        return $s;
    }
}
