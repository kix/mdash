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

    private $testParagraphWrap = true;

    private $rules = array(
            array(
                'ruleName' => 'TM is replaced',
                'given'    => 'Symfony(tm)',
                'expected' => 'Symfony&trade;',
            ),
            array(
                'ruleName' => '(R) is replaced',
                'given'    => 'Symfony(R)',
                'expected' => 'Symfony&reg;',
            ),
            array(
                'ruleName' => '(c) is replaced',
                'given'    => 'Symfony(c)',
                'expected' => 'Symfony&copy;',
            ),
            array(
                'ruleName' => 'apostrophe is replaced',
                'given'    => 'O\'Reily',
                'expected' => 'O\'Reily',
                'skip'     => true,
            ),
            array(
                'ruleName' => 'Fahrenheit degrees are replaced',
                'given'    => '153F',
                'expected' => '<nobr>153 &deg;F</nobr>',
            )
        );

    public function setUp()
    {
        $this->typograph = new EMTypograph();
    }

    public function provider()
    {
        $rules = $this->rules;
        
        if ($this->testParagraphWrap) {
            $rules = array_map(function($rule) {
                return array(
                    'ruleName' => $rule['ruleName'],
                    'given'    => $rule['given'],
                    'expected' => '<p>' . $rule['expected'] . '</p>',
                    'skip'     => (array_key_exists('skip', $rule)) ? $rule['skip'] : false,
                );
            }, $rules);
        }

        return $rules;
    }

    /**
     * @dataProvider provider
     */
    public function testRule($ruleName, $given, $expected, $skip = false)
    {
        if ($skip) {
            $this->markTestSkipped();
        }

        $this->assertEquals($expected, $this->typograph->process($given), 'Failed asserting that ' . $ruleName);
    }

} 