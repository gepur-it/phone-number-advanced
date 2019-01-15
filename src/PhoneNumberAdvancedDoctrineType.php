<?php
/**
 * @author: Marina Mileva m934222258@gmail.com
 * @since: 26.11.18
 */

namespace GepurIt\PhoneNumberAdvanced;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

/**
 * phone_number Doctrine mapping
 *
 * Class PhoneNumberDoctrineType
 * @package GepurIt\PhoneNumber
 */
class PhoneNumberAdvancedDoctrineType extends Type
{
    const TYPE_NAME = 'phone_number_advanced';
    const TYPE_LENGTH = 20;

    /**
     * @param $value
     * @param AbstractPlatform $platform
     * @return mixed|null|string
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof PhoneNumberAdvanced) {
            throw new ConversionException('Expected '. PhoneNumberAdvanced::class.', got ' . gettype($value));
        }

        /** @var PhoneNumberAdvanced $value */
        $stringToSave = $value->getNumber();

        return $stringToSave;
    }

    /**
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return PhoneNumberAdvanced
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof PhoneNumberAdvanced) {
            return $value;
        }

        $result = null;
        $phone = parent::convertToPHPValue($value, $platform);

        if(is_string($value)) {
            $result = new PhoneNumberAdvanced($phone);
        }

        return $result;
    }

    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param array                                     $fieldDeclaration The field declaration.
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform         The currently used database platform.
     *
     * @return string
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'VARCHAR('.self::TYPE_LENGTH.')';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $e = explode('\\', get_class($this));

        return str_replace('DoctrineType', '', end($e));
    }

    /**
     * Gets the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return self::TYPE_NAME;
    }
}
