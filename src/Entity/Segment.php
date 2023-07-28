<?php

namespace Maris\Symfony\Direction\Entity;

use Doctrine\Common\Collections\Collection;
use IteratorAggregate;
use Traversable;

/**
 * Любой сегмент дороги (маршрут, нога или шаг).
 * Не имеет мутаторов, создается фабриками и является неизменяемым.
 * Является перебираемым.
 * @property-read int|null $id
 * @property-read float $distance
 * @property-read float $duration
 */
abstract class Segment implements IteratorAggregate
{
    /**
     * ID в базе данных
     * @var int|null
     */
    protected ?int $id = null;

    /**
     * Длинна участка в матрах
     * @var float
     */
    protected float $distance;

    /**
     * Продолжительность участка в секундах
     * @var float
     */
    protected float $duration;

    /**
     * Родительский сегмент
     * @var self|null
     */
    protected ?self $parent = null;

    /**
     * Список дочерних компонентов
     * @var Collection|null
     */
    protected ?Collection $children = null;

    /**
     * @param string $name
     * @return float|int|null
     */
    public function __get( string $name )
    {
        return match ($name){
            "id" => $this->id,
            "distance" => $this->distance,
            "duration" => $this->duration,
            default => null
        };
    }

}