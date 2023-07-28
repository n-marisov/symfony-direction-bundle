<?php

namespace Maris\Symfony\Direction\Factory;

use Maris\Symfony\Direction\Collections\RouteList;
use Maris\Symfony\Direction\Collections\WaypointList;
use Maris\Symfony\Direction\Entity\Direction;
use Maris\Symfony\Direction\Entity\Route;
use Maris\Symfony\Direction\Entity\Segment;
use Maris\Symfony\Direction\Entity\Step;
use Maris\Symfony\Direction\Entity\Waypoint;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * Фабрика для создания объекта Direction
 * @template T as Segment
 */
abstract class SegmentFactory extends AbstractFactory
{
    protected ReflectionProperty $distance;

    protected ReflectionProperty $duration;

    protected ReflectionProperty $children;

    protected ReflectionProperty $parent;

    /**
     * @throws ReflectionException
     */
    public function __construct( string $class )
    {
        parent::__construct( $class );

        $this->distance = $this->reflection->getProperty("distance");
        $this->duration = $this->reflection->getProperty("duration");
        $this->children = $this->reflection->getProperty("children");
        $this->parent = $this->reflection->getProperty("parent");
    }

    /**
     * @param Segment $parent
     * @return void
     */
    public function setParent(Segment $parent): void
    {
        $this->parent->setValue($this->instance,$parent);
    }

    /**
     * @param float $distance
     * @return void
     */
    public function setDistance( float $distance ): void
    {
        if(isset($this->instance))
            $this->distance->setValue( $this->instance, $distance );
    }

    /**
     * @param float $duration
     * @return void
     */
    public function setDuration( float $duration ): void
    {
        if(isset($this->instance))
            $this->duration->setValue( $this->instance, $duration );
    }

    /**
     * Выбирает значение расстояния из массива
     * @param array $segment
     * @return float
     */
    abstract protected function extractDistance( array $segment ):float;

    /**
     * Выбирает значение времени из массива
     * @param array $segment
     * @return float
     */
    abstract protected function extractDuration( array $segment ):float;

}