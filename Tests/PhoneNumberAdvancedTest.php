<?php
/**
 * @author: Marina Mileva <m934222258@gmail.com>
 * @since: 04.12.18
 */

namespace GepurIt\PhoneNumberAdvanced\Tests;

use GepurIt\PhoneNumberAdvanced\PhoneNumberAdvanced;
use PHPUnit\Framework\TestCase;

/**
 * Class PhoneNumberTest
 * @package GepurIt\PhoneNumber\Tests
 */
class PhoneNumberAdvancedTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @param string $source
     * @param string $assert
     */
    public function testGetNumber(string $source, string $assert)
    {
        $phone = new PhoneNumberAdvanced($source);
        $this->assertEquals($assert, $phone->getNumber());
    }

    /**
     * @dataProvider dataProvider
     * @param string $source
     */
    public function testToString(string $source)
    {
        $phone = new PhoneNumberAdvanced($source);
        $this->assertEquals($phone->__toString(), $phone->getNumber());
    }


    public function dataProvider()
    {
        return [
          'short ukrainian' => [
              'source' => '0985103975',
              'assert' => '380985103975',
          ],
          'ukrainian_with_six (from asterisk)' => [
              'source' => '60985103975',
              'assert' => '380985103975',
          ],
          'ukrainian_with_eight' => [
              'source' => '80985103975',
              'assert' => '380985103975',
          ],
          'ukrainian_with_seven (invalid detection)' => [
              'source' => '70985103975',
              'assert' => '380985103975',
          ],
          'full_ukrainian' => [
              'source' => '380985103975',
              'assert' => '380985103975',
          ],
          'russian_with_eight (from asterisk)' => [
              'source' => '89155085812',
              'assert' => '79155085812',
          ],
          'russian_with_seven' => [
              'source' => '79155085812',
              'assert' => '79155085812',
          ],
          'russian_short' => [
              'source' => '9155085812',
              'assert' => '79155085812',
          ],
          'unknown 1' => [
              'source' => '39155085812',
              'assert' => '39155085812',
          ],
          'unknown 2' => [
              'source' => '85812',
              'assert' => '85812',
          ],
          'unknown 3' => [
              'source' => '870000000000',
              'assert' => '870000000000',
          ],
        ];
    }
}
