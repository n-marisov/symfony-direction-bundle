<?php

namespace Maris\Symfony\Direction\Collections;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Maris\Symfony\Direction\Entity\Waypoint;
use Maris\Symfony\Direction\Iterators\WaypointIterator;
use Traversable;

/**
 * Список путевых точек
 */
class WaypointList extends AbstractList
{
    public function __construct( Collection|array $waypoints = new ArrayCollection())
    {
        parent::__construct(
            (is_array($waypoints)) ? new ArrayCollection( $waypoints ) : $waypoints
            , Waypoint::class );
    }

    public function offsetGet(mixed $offset):?Waypoint
    {
        return parent::offsetGet($offset);
    }

    public function get( int|string $key ):?Waypoint
    {
        return $this->offsetGet( $key );
    }

    public function first():?Waypoint
    {
        return parent::first() ?? null;
    }

    public function last():?Waypoint
    {
        return parent::last() ?? null;
    }

    public function getIterator(): Traversable
    {
        return new WaypointIterator( $this );
    }


}