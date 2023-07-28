<?php

namespace Maris\Symfony\Direction\Entity;
use Maris\Symfony\Geo\Entity\Location;

/**
 * Путевая точка.
 * Не имеет мутаторов.
 *
 *
 * @property-read int|null $id
 * @property-read Direction|null $direction
 * @property-read Location|null $location
 * @property-read float|null $distance
 */
class Waypoint
{
    /**
     * ID в базе данных.
     * @var int|null
     */
    protected ?int $id = null;

    /**
     * Маршрут к которой привязана путевая точка.
     * @var Direction|null
     */
    protected ?Direction $direction = null;


    /**
     * Координаты исходной точки.
     * @var Location|null
     */
    protected ?Location $location = null;

    /**
     * Расстояние между точкой привязки и исходной точкой.
     * @var float|null
     */
    protected ?float $distance = null;

    public function __get( string $name )
    {
        return match ( $name ){
            "id" => $this->id,
            "direction" => $this->direction,
            "location" => $this->location,
            "distance" => $this->distance,
            default => null
        };
    }


}