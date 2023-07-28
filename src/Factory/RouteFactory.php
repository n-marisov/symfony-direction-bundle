<?php

namespace Maris\Symfony\Direction\Factory;

use Maris\Symfony\Direction\Collections\LegList;
use Maris\Symfony\Direction\Entity\Direction;
use Maris\Symfony\Direction\Entity\Route;
use ReflectionProperty;


/**
 * Фабрика для создания объекта Direction
 */
abstract class RouteFactory extends SegmentFactory
{

    protected ReflectionProperty $direction;

    protected LegFactory $factory;

    public function __construct( LegFactory $factory )
    {
        parent::__construct( Route::class );

        $this->direction = $this->reflection->getProperty("direction");

        $this->factory = $factory;
    }


    public function create( array $route , $direction ): Route
    {
        $this->buildInstance();

            $this->setDirection( $direction );

            $this->setId( $this->extractId( $route ) );

            $this->setDistance( $this->extractDistance( $route ) );
            $this->setDuration( $this->extractDuration( $route ) );

            $this->setLegs(
                $this->createLegList(
                    $this->extractArrayLegs( $route )
                )
            );
        return $this->clearInstance();
    }

    /**
     * @param Direction $direction
     * @return void
     */
    protected function setDirection( Direction $direction ): void
    {
        $this->direction->setValue($this->instance,$direction);
    }






    protected function setLegs( LegList $list ):void
    {
        if(isset($this->instance))
            $this->children->setValue( $this->instance, $list );
    }

    abstract protected function extractArrayLegs( array $route ):array;

    protected function createLegList( array $legs ):LegList
    {
        $list = new LegList();
        foreach ($legs as $leg)
            $list->add( $this->factory->create( $leg, $this->instance ) );
        return $list;
    }
}