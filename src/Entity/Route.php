<?php

namespace Maris\Symfony\Direction\Entity;

use Exception;
use Maris\Symfony\Direction\Collections\LegList;
use Maris\Symfony\Direction\Collections\WaypointList;
use Maris\Symfony\Direction\Iterators\LegIterator;
use Traversable;

/***
 * @property-read Direction $direction
 * @property-read LegList $legs
 * @property-read WaypointList $waypoints
 */
class Route extends Segment
{
    /**
     * @var Direction
     */
    protected Direction $direction;


    public function __construct()
    {
        $this->children = new LegList();
    }

    public function __get(string $name)
    {
        return match ($name){
            "direction" => $this->direction,
            "legs" => $this->children,
            "waypoints" => $this->direction->waypoints,
            default => parent::__get( $name )
        };
    }

    /**
     * Перебирает список ног.
     * @return LegIterator
     * @throws Exception
     */
    public function getIterator(): LegIterator
    {
        return $this->children->getIterator();
    }
}