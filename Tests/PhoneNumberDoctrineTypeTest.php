<?php
/**
 * @author: Marina Mileva <m934222258@gmail.com>
 * @since: 05.12.18
 */
declare(strict_types=1);

namespace GepurIt\PhoneNumberAdvanced\Tests;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use GepurIt\PhoneNumberAdvanced\PhoneNumberAdvanced;
use GepurIt\PhoneNumberAdvanced\PhoneNumberAdvancedDoctrineType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class PhoneNumberDoctrineTypeTest
 * @package GepurIt\PhoneNumber\Tests
 */
class PhoneNumberDoctrineTypeTest extends TestCase
{
    /**
     * @var PhoneNumberAdvancedDoctrineType
     */
    protected $type;

    /**
     * @throws DBALException
     */
    public static function setUpBeforeClass(): void
    {
        Type::addType(PhoneNumberAdvancedDoctrineType::TYPE_NAME, PhoneNumberAdvancedDoctrineType::class);
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf(PhoneNumberAdvancedDoctrineType::class, $this->type);
    }

    public function testGetName()
    {
        $this->assertSame(PhoneNumberAdvancedDoctrineType::TYPE_NAME, $this->type->getName());
    }

    public function testGetSQLDeclaration()
    {
        /**@var AbstractPlatform|MockObject $platform */
        $platform = $this->createMock(AbstractPlatform::class);

        $this->assertSame('VARCHAR(20)', $this->type->getSQLDeclaration([], $platform));
    }

    public function testToString()
    {
        $this->assertSame('PhoneNumberAdvanced', sprintf('%s', $this->type));
    }

    /**
     * @throws ConversionException
     */
    public function testConvertToDatabaseValueWithNull()
    {
        /**@var AbstractPlatform|MockObject $platform */
        $platform = $this->createMock(AbstractPlatform::class);

        $this->assertNull($this->type->convertToDatabaseValue(null, $platform));
    }

    /**
     * @throws ConversionException
     */
    public function testConvertToDatabaseValueException()
    {
        /**@var AbstractPlatform|MockObject $platform */
        $platform = $this->createMock(AbstractPlatform::class);

        $this->expectException(ConversionException::class);

        $this->type->convertToDatabaseValue(new \stdClass(), $platform);
    }

    /**
     * @throws ConversionException
     */
    public function testConvertToDatabaseValue()
    {
        /**@var AbstractPlatform|MockObject $platform */
        $platform = $this->createMock(AbstractPlatform::class);

        $result = $this->type->convertToDatabaseValue(new PhoneNumberAdvanced('380971234567'), $platform);

        $this->assertEquals('380971234567', $result);
    }

    public function testConvertToPHPValueWithNull()
    {
        /**@var AbstractPlatform|MockObject $platform */
        $platform = $this->createMock(AbstractPlatform::class);

        $this->assertNull($this->type->convertToPHPValue(null, $platform));
    }

    public function testConvertToPHPValueWithNullEmail()
    {
        /**@var AbstractPlatform|MockObject $platform */
        $platform = $this->createMock(AbstractPlatform::class);

        $this->assertInstanceOf(
            PhoneNumberAdvanced::class,
            $this->type->convertToPHPValue(new PhoneNumberAdvanced('380971234567'), $platform)
        );
    }

    public function testConvertToPHPValue()
    {
        /**@var AbstractPlatform|MockObject $platform */
        $platform = $this->createMock(AbstractPlatform::class);

        $this->assertInstanceOf(PhoneNumberAdvanced::class, $this->type->convertToPHPValue('380971234567', $platform));
    }

    /**
     * @throws DBALException
     */
    protected function setUp(): void
    {
        $this->type = Type::getType(PhoneNumberAdvancedDoctrineType::TYPE_NAME);
    }
}
