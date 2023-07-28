<?php

namespace Maris\Symfony\Direction\Collections;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Maris\Symfony\Direction\Entity\Leg;
use Maris\Symfony\Direction\Iterators\LegIterator;

/**
 * Список путевых точек
 */
class LegList extends AbstractList
{
    public function __construct( Collection|array $waypoints = new ArrayCollection())
    {
        parent::__construct(
            (is_array($waypoints)) ? new ArrayCollection( $waypoints ) : $waypoints
            , Leg::class );
    }

    public function offsetGet(mixed $offset):?Leg
    {
        return parent::offsetGet($offset);
    }

    public function get( int|string $key ):?Leg
    {
        return $this->offsetGet( $key );
    }

    public function first():?Leg
    {
        return parent::first() ?? null;
    }

    public function last():?Leg
    {
        return parent::last() ?? null;
    }

    public function getIterator(): LegIterator
    {
        return new LegIterator($this);
    }


}