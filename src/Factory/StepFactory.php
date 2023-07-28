<?php

namespace Maris\Symfony\Direction\Factory;

use Maris\Symfony\Direction\Collections\LegList;
use Maris\Symfony\Direction\Entity\Leg;
use Maris\Symfony\Direction\Entity\Route;
use Maris\Symfony\Direction\Entity\Step;
use Maris\Symfony\Geo\Entity\Polyline;
use Maris\Symfony\Geo\Factory\LocationFactory;
use Maris\Symfony\Geo\Service\PolylineEncoder;
use ReflectionProperty;


/**
 * Фабрика для создания объекта Direction
 */
abstract class StepFactory extends SegmentFactory
{
    protected ReflectionProperty $geometry;

    public function __construct()
    {
        parent::__construct(Step::class );
        $this->geometry = $this->reflection->getProperty("geometry");
    }





    public function create( array $step , $leg ): Step
    {
        $this->buildInstance();

            $this->setParent( $leg );

            $this->setId( $this->extractId( $step ) );

            $this->setDistance( $this->extractDistance($step) );
            $this->setDuration( $this->extractDuration($step) );

            $this->setGeometry(
                $this->createGeometry(
                    $this->extractArrayGeometry( $step )
                )
            );

        return $this->clearInstance();
    }

    protected function setGeometry( Polyline $polyline ):void
    {
        if(isset($this->instance))
            $this->geometry->setValue( $this->instance, $polyline );
    }


    abstract protected function extractArrayGeometry( array $step ):array|string;

    protected function createGeometry( array|string $geometry ):Polyline
    {
        $locationFactory = new LocationFactory();
        $list = new Polyline();
        foreach ($geometry as $coordinate )
            $list->addLocation( $locationFactory->create($coordinate) );
        return $list;
    }
}