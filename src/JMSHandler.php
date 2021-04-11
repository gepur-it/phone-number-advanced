<?php
/**
 * @author: Andrii yakovlev <yawa20@gmail.com>
 * @since: 29.05.18
 */
declare(strict_types=1);

namespace GepurIt\PhoneNumberAdvanced;

use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\VisitorInterface;
use JMS\Serializer\XmlDeserializationVisitor;

/**
 * Class JMSHandler
 * @package GepurIt\PhoneNumber
 * @codeCoverageIgnore
 */
class JMSHandler implements SubscribingHandlerInterface
{
    /**
     * Return format:
     *
     *      [
     *          [
     *              'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
     *              'format' => 'json',
     *              'type' => 'DateTime',
     *              'method' => 'serializeDateTimeToJson',
     *          ],
     *      ]
     *
     * The direction and method keys can be omitted.
     *
     * @return array
     */
    public static function getSubscribingMethods()
    {
        $methods = [];

        foreach (['json', 'xml', 'yml'] as $format) {
            $methods[] = [
                'type'      => PhoneNumberAdvanced::class,
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format'    => $format,
            ];
            $methods[] = [
                'type'      => PhoneNumberAdvanced::class,
                'format'    => $format,
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'method'    => 'serializePhoneNumberAdvanced',
            ];
        }

        return $methods;
    }

    /**
     * @param VisitorInterface $visitor
     * @param PhoneNumberAdvanced $number
     * @param array $type
     * @param Context $context
     * @return string
     */
    public function serializePhoneNumberAdvanced(
        VisitorInterface $visitor,
        PhoneNumberAdvanced $number,
        array $type,
        Context $context
    ) {
        return $number->getNumber();
    }

    /**
     * @param XmlDeserializationVisitor $visitor
     * @param $data
     * @param array $type
     * @return PhoneNumberAdvanced|null
     */
    public function deserializePhoneNumberAdvancedFromXml(XmlDeserializationVisitor $visitor, $data, array $type)
    {
        return new PhoneNumberAdvanced($data);
    }

    /**
     * @param JsonDeserializationVisitor $visitor
     * @param $data
     * @param array $type
     * @return PhoneNumberAdvanced|null
     */
    public function deserializePhoneNumberAdvancedFromJson(JsonDeserializationVisitor $visitor, $data, array $type)
    {
        return new PhoneNumberAdvanced($data);
    }
}
