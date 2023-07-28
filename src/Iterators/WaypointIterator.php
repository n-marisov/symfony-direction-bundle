<?php

namespace Maris\Symfony\Direction\Iterators;

use Iterator;
use Maris\Symfony\Direction\Collections\RouteList;
use Maris\Symfony\Direction\Collections\WaypointList;
use Maris\Symfony\Direction\Entity\Route;
use Maris\Symfony\Direction\Entity\Waypoint;

/**
 * Итератор для переборки маршрута.
 * Необходим, чтобы запретить прямой доступ к списку маршрутов
 * в объекте Direction.
 */
class WaypointIterator implements Iterator
{
    /**
     * Список маршрутов
     * @var WaypointList
     */
    protected WaypointList $elements;

    /**
     * Количество маршрутов в списке
     * @var int
     */
    protected int $count;

    /**
     * @param WaypointList $elements
     */
    public function __construct( WaypointList $elements )
    {
        $this->elements = $elements;
        $this->count = count( $elements );
    }


    /**
     * @inheritDoc
     */
    public function current(): Waypoint
    {
        return $this->elements->current();
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        $this->elements->next();
    }

    /**
     * @inheritDoc
     */
    public function key(): int
    {
        return $this->elements->key();
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return $this->key() < $this->count;
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        $this->elements->first();
    }
}