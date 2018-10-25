<?php

declare(strict_types=1);

namespace tests\App\Infrastructure\Persistence\Doctrine\Type;

use App\Infrastructure\Persistence\Doctrine\Type\DoctrineEnumStationDetailTypeType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;
use tests\Support\Builder\StationDetailTypeBuilder;

class DoctrineEnumStationDetailTypeTypeUnitTest extends TestCase
{
    /** @var DoctrineEnumStationDetailTypeType */
    private $type;

    /** @var AbstractPlatform */
    private $platform;

    /** @test */
    public function it_can_get_name(): void
    {
        $this->assertEquals('enum_station_detail_type_type', $this->type->getName());
    }

    /** @test */
    public function it_can_get_the_sql_declaration(): void
    {
        $fieldDeclaration = ['name' => 'station_detail_type'];

        $this->assertEquals(
            'VARCHAR(255) CHECK(station_detail_type IN (\'BIKE\',\'ELECTRIC_BIKE\'))',
            $this->type->getSqlDeclaration($fieldDeclaration, new PostgreSqlPlatform())
        );
    }

    /** @test */
    public function it_can_convert_to_a_php_value(): void
    {
        $value = 'BIKE';

        $this->assertEquals(
            StationDetailTypeBuilder::create()->withTypeBike()->build(),
            $this->type->convertToPHPValue($value, $this->platform)
        );
    }

    /** @test */
    public function it_can_convert_a_null_value_to_a_php_value(): void
    {
        $this->assertNull($this->type->convertToPHPValue(null, $this->platform));
    }

    /** @test */
    public function it_can_convert_a_station_detail_type_value_to_a_php_value(): void
    {
        $type = StationDetailTypeBuilder::create()->build();

        $this->assertEquals($type, $this->type->convertToPHPValue($type, $this->platform));
    }

    /** @test */
    public function it_can_convert_to_a_database_value(): void
    {
        $type = 'BIKE';

        $this->assertEquals($type, $this->type->convertToDatabaseValue($type, $this->platform));
    }

    /** @test */
    public function it_requires_sql_comment_hint(): void
    {
        $this->assertTrue($this->type->requiresSQLCommentHint($this->platform));
    }

    public static function setUpBeforeClass(): void
    {
        Type::addType('enum_station_detail_type_type_test', DoctrineEnumStationDetailTypeType::class);
    }

    public function setUp(): void
    {
        $this->platform = new PostgreSqlPlatform();
        $this->type = Type::getType('enum_station_detail_type_type_test');
    }

    protected function tearDown(): void
    {
        $this->platform = null;
        $this->type = null;
    }
}
