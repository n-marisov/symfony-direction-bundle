<?php

namespace Maris\Symfony\Direction\Entity;


use Maris\Symfony\Geo\Entity\Polyline;
use Traversable;

/***
 * @property-read Polyline $geometry
 * @property-read Polyline $polyline
 */
class Step extends Segment
{
    /**
     * @var Polyline
     */
    protected Polyline $geometry;

    /**
     *
     */
    public function __construct()
    {
        $this->geometry = new Polyline();
    }

    public function __get(string $name)
    {
        return match ($name){
            "polyline", "geometry" => $this->geometry,
            default => parent::__get($name)
        };
    }


    public function getIterator(): Traversable
    {
        return $this->geometry->getIterator();
    }
}