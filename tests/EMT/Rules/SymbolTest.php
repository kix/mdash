<?php
/**
 * Created by PhpStorm.
 * User: kix
 * Date: 09/06/14
 * Time: 18:03
 */

namespace kix\mdash\tests\EMT\Rules;


use EMT\EMTypograph;

class SymbolTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var EMTypograph
     */
    private $typograph;

    public function setUp()
    {
        $this->typograph = new EMTypograph();
    }

    public function testTMIsReplaced()
    {
        $text = 'Symfony(tm)';

        $this->assertEquals(
            'Symfony™',
            $this->typograph->process($text)
        );
    }

} 