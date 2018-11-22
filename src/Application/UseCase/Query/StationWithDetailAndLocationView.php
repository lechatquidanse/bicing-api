<?php

declare(strict_types=1);

namespace App\Application\UseCase\Query;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Domain\Model\Station\StationDetailType;
use App\Domain\Model\UseCaseInterface;
use Ramsey\Uuid\UuidInterface;
use App\UserInterface\Rest\Controller\StationWithDetailAndLocationCollectionController;

/**
 * @ApiResource(
 *     shortName="station",
 *     routePrefix="/stations",
 *     itemOperations={"get"={"method"="GET", "path"="/{id}"}},
 *     collectionOperations={
 *       "get"={
 *         "method"="GET",
 *         "path"="",
 *         "controller"=StationWithDetailAndLocationCollectionController::class,
 *         "defaults"={"_api_receive"=false},
 *         "swagger_context"={
 *           "parameters"={
 *              {
 *                "name"="geo_location_filter",
 *                "in"="query",
 *                "description"="Query 'latitude,longitude,limit' (example: 41.373,2.17031,450.35). Limit in meter.",
 *                "required"=false,
 *                "type"="string"
 *              }
 *            }
 *          }
 *       }
 *     }
 *  )
 */
final class StationWithDetailAndLocationView implements UseCaseInterface
{
    /**
     * @var UuidInterface
     *
     * @ApiProperty(identifier=true)
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string|null
     */
    public $type;

    /**
     * @var string
     */
    public $address;

    /**
     * @var string|null
     */
    public $addressNumber;

    /**
     * @var string
     */
    public $zipCode;

    /**
     * @var float
     */
    public $latitude;

    /**
     * @var float
     */
    public $longitude;

    /**
     * @param array $array
     *
     * @return StationWithDetailAndLocationView
     */
    public static function fromArray(array $array): StationWithDetailAndLocationView
    {
        $view = new self();

        $view->id = $array['station_id'] ?? null;
        $view->name = $array['name'] ?? null;
        $view->type = $array['type'] instanceof StationDetailType ? $array['type']->__toString() : null;
        $view->address = $array['address'] ?? null;
        $view->addressNumber = $array['address_number'] ?? null;
        $view->zipCode = $array['zip_code'] ?? null;
        $view->latitude = $array['latitude'] ?? null;
        $view->longitude = $array['longitude'] ?? null;

        return $view;
    }
}
