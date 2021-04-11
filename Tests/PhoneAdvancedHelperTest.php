<?php
/**
 * @author: Marina Mileva <m934222258@gmail.com>
 * @since: 05.12.18
 */
declare(strict_types=1);

namespace GepurIt\PhoneNumberAdvanced\Tests;

use GepurIt\PhoneNumberAdvanced\PhoneAdvancedHelper;
use GepurIt\PhoneNumberAdvanced\PhoneNumberAdvanced;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class PhoneAdvancedHelperTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testIsUkrainianNumber($assertion, $number)
    {
        $helper = new PhoneAdvancedHelper();
        $this->assertEquals($assertion, $helper->isUkrainianNumber(new PhoneNumberAdvanced($number)));
    }

    /**
     * @dataProvider countryDataProvider
     */
    public function testDetectCountry($assertion, $number)
    {
        $helper = new PhoneAdvancedHelper();
        $this->assertEquals($assertion, $helper->detectCountry(new PhoneNumberAdvanced($number)));
    }

    /**
     * @return array
     */
    public function countryDataProvider()
    {
        return [
            ['', '000'],
            ['', '01111111111111111'],
            ['Украина', '380383803808'],
            ['Украина', '0979979485'],
            ['Россия', '79959979485'],
            ['Азейрбаджан', '994799794851'],
            ['Грузия', '995799794851'],
            ['Казахстан', '77123456789'],
            ['Латвия', '371123456789'],
        ];
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
            'invalid number'                                            => [false, '00000000'],
            'russian number'                                            => [false, '789456123457'],
            'ukrainian, but invalid number, should be false'            => [false, '3801234567'],
            'ukrainian with plus, but invalid, should be false'         => [false, '+38012345678'],
            'technical number'                                          => [false, '*4578'],
            'valid ukrainian number, starts with zero and contains ()-' => [true, '(038) 380-38-08'],
            'valid ukrainian number, starts with zero and contains ()'  => [true, '(038) 380 3808'],
            'valid ukrainian number, starts with zero'                  => [true, '038 3803808'],
            'valid number, start with eight'                            => [true, '80383803808'],
            'valid number, start with three'                            => [true, '380383803808'],
            'valid number, starts with plus'                            => [true, '+380253803808'],
            'valid number, starts with plus and contains ()-'           => [true, '+38(025)380-38-08'],
        ];
    }
}