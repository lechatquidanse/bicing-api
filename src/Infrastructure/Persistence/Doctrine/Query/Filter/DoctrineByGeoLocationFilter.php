<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Query\Filter;

use App\Application\UseCase\Filter\ByGeoLocationFilter;
use Doctrine\ORM\QueryBuilder;

final class DoctrineByGeoLocationFilter
{
    public static function filter(QueryBuilder $queryBuilder, ByGeoLocationFilter $filter): QueryBuilder
    {
        return $queryBuilder
            ->where(
                'ST_Distance(s.location.geometry, ST_Transform(ST_SetSRID(ST_MakePoint(:lg, :la),4326),2163)) < :lt'
            )
            ->setParameters([
                'la' => $filter->latitude(),
                'lg' => $filter->longitude(),
                'lt' => $filter->limit(),
            ]);
    }
}
