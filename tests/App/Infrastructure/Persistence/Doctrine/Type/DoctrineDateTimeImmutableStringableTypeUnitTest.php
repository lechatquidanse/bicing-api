<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Model\StationState\DateTimeImmutableStringable;
use App\Infrastructure\Persistence\Doctrine\Type\DoctrineDateTimeImmutableStringableType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;

class DoctrineDateTimeImmutableStringableTypeUnitTest extends TestCase
{
    /** @var DoctrineDateTimeImmutableStringableType */
    private $type;

    /** @var AbstractPlatform */
    private $platform;

    /** @test */
    public function it_can_get_name(): void
    {
        $this->assertEquals('date_time_immutable_stringable', $this->type->getName());
    }

    /** @test */
    public function it_can_convert_to_a_php_value(): void
    {
        $value = '2016-12-12 16:01:34';

        $this->assertEquals(
            new DateTimeImmutableStringable($value),
            $this->type->convertToPHPValue($value, $this->platform)
        );
    }

    /** @test */
    public function it_can_convert_a_null_value_to_a_php_value(): void
    {
        $this->assertNull($this->type->convertToPHPValue(null, $this->platform));
    }

    /** @test */
    public function it_can_convert_a_datetime_immutable_stringable_value_to_a_php_value(): void
    {
        $datetime = new DateTimeImmutableStringable();

        $this->assertEquals($datetime, $this->type->convertToPHPValue($datetime, $this->platform));
    }

    /** @test */
    public function it_requires_sql_comment_hint(): void
    {
        $this->assertTrue($this->type->requiresSQLCommentHint($this->platform));
    }

    public static function setUpBeforeClass(): void
    {
        Type::addType('date_time_immutable_stringable_test', DoctrineDateTimeImmutableStringableType::class);
    }

    public function setUp(): void
    {
        $this->platform = new PostgreSqlPlatform();
        $this->type = Type::getType('date_time_immutable_stringable_test');
    }

    protected function tearDown(): void
    {
        $this->platform = null;
        $this->type = null;
    }
}
