<?php
namespace Tests\Unit;

use App\Services\Transliterator;
use PHPUnit\Framework\TestCase;

class TransliteratorTest extends TestCase
{
    public string $textToVerifyCyrillic = 'шла щука`по_шоссе+и%сосалаЬ сушку ы ъь';

    public function testRightTransliterate()
    {
        /**
         * @var Transliterator $transliterator
         */
        $transliterator = app()->get(Transliterator::class);
        $transliteratedLat = $transliterator->transliterate($this->textToVerifyCyrillic, true);// шла щука по шоссе и сосала щукьу
        $this->assertSame('shla sh`uka`po_shosse+i%sosalaX sushku  yx', $transliteratedLat);
    }
}
