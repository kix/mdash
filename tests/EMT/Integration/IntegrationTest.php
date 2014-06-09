<?php
/**
 * Created by PhpStorm.
 * User: kix
 * Date: 03/06/14
 * Time: 11:55
 */

namespace EMTTests\Integration;

use EMT\EMTypograph;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{

    /**
     */
    private $typographer;

    public function setUp()
    {
        $this->typographer = new EMTypograph();
    }

    public function testRun()
    {
        $this->typographer->setup();

        $text = <<<TEXT
Я - странный текст с уродливыми "кавычками", и неразрывных пробелов во мне тоже нет. 1/4. (с)б 50dpi, 40lpi, см.стр.13,г.Москва,
36м3, 41м2
TEXT;

        $this->typographer->set_text($text);
        $result = $this->typographer->apply();
    }

} 