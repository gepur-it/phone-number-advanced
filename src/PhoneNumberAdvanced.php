<?php
/**
 * @author : Marina Mileva m934222258@gmail.com
 * @since : 26.11.18
 */

namespace GepurIt\PhoneNumberAdvanced;

use GepurIt\PhoneNumber\Constraints as Assert;
use GepurIt\PhoneNumber\PhoneNumber;

/**
 * advise : add JMS\Inline() to phone field annotation
 * Class PhoneNumberAdvanced
 * @package GepurIt\PhoneNumberAdvanced
 * @Assert\PhoneNumber()
 */
class PhoneNumberAdvanced extends PhoneNumber
{
    const DIGITAL_REGEXP = "/[^\d]/";

    // 7 - c сайта бывает, приходит неправильная маска
    // 6 - астериск
    const UA_REGEXP = '/(?<=^38|^8|^7|^6|^)(0\d{9})$/';
    const RU_REGEXP = '/(?<=^8|^7|^)([3-9]\d{9})$/';

    /**
     * @var string fullNumber
     */
    private $fullNumber;

    /**
     * PhoneNumber constructor.
     * @param string $number
     */
    public function __construct(string $number)
    {
        $number = preg_replace(self::DIGITAL_REGEXP, "", $number);
        $this->fullNumber = mb_strcut($number, 0, PhoneNumberAdvancedDoctrineType::TYPE_LENGTH);
        if (preg_match(self::UA_REGEXP, $this->fullNumber, $matches)) {
            $this->fullNumber = "38".$matches[1];
        }
        if (preg_match(self::RU_REGEXP, $this->fullNumber, $matches)) {
            $this->fullNumber = "7".$matches[1];
        }
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->fullNumber;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->fullNumber;
    }
}
