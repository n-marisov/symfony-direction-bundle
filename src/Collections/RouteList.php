<?php

namespace Maris\Symfony\Direction\Collections;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Maris\Symfony\Direction\Entity\Route;
use Maris\Symfony\Direction\Entity\Waypoint;
use Maris\Symfony\Direction\Iterators\RouteIterator;
use Traversable;

/**
 * Список маршрутов
 */
class RouteList extends AbstractList
{
    public function __construct( Collection|array $waypoints = new ArrayCollection())
    {
        parent::__construct(
            (is_array($waypoints)) ? new ArrayCollection( $waypoints ) : $waypoints
            , Route::class );
    }

    public function offsetGet(mixed $offset):?Route
    {
        return parent::offsetGet($offset);
    }

    public function get( int|string $key ):?Route
    {
        return $this->offsetGet( $key );
    }

    public function first():?Route
    {
        return parent::first() ?? null;
    }

    public function last():?Route
    {
        return parent::last() ?? null;
    }

    public function getIterator(): RouteIterator
    {
        return new RouteIterator($this);
    }


}