<?php

namespace Maris\Symfony\Direction\Collections;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Maris\Symfony\Direction\Entity\Step;
use Maris\Symfony\Direction\Entity\Waypoint;
use Maris\Symfony\Direction\Iterators\StepIterator;
use Traversable;

/**
 * Список путевых точек
 */
class StepList extends AbstractList
{
    public function __construct( Collection|array $waypoints = new ArrayCollection())
    {
        parent::__construct(
            (is_array($waypoints)) ? new ArrayCollection( $waypoints ) : $waypoints
            , Step::class );
    }

    public function offsetGet(mixed $offset):?Step
    {
        return parent::offsetGet($offset);
    }

    public function get( int|string $key ):?Step
    {
        return $this->offsetGet( $key );
    }

    public function first():?Step
    {
        return parent::first() ?? null;
    }

    public function last():?Step
    {
        return parent::last() ?? null;
    }

    public function getIterator(): StepIterator
    {
        return new StepIterator( $this );
    }


}