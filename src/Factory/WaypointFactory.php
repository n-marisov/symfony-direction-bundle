<?php

namespace Maris\Symfony\Direction\Factory;

use Maris\Symfony\Direction\Entity\Direction;
use Maris\Symfony\Direction\Entity\Waypoint;
use Maris\Symfony\Geo\Entity\Location;
use Maris\Symfony\Geo\Factory\LocationFactory;

abstract class WaypointFactory extends AbstractFactory
{
    protected \ReflectionProperty $direction;
    protected \ReflectionProperty $location;

    protected \ReflectionProperty $distance;

    protected LocationFactory $locationFactory;

    public function __construct( LocationFactory $factory )
    {
        $this->locationFactory = $factory;
        parent::__construct(Waypoint::class );

        $this->direction = $this->reflection->getProperty("direction");
        $this->location = $this->reflection->getProperty("location");
        $this->distance = $this->reflection->getProperty("distance");
    }


    public function create( array $data, $direction ):Waypoint
    {
        $this->buildInstance();

            $this->setDirection( $direction );

            $this->setId($this->extractId( $data ));

            $this->setDistance(
                $this->extractDistance( $data )
            );

            $this->setLocation(
                $this->locationFactory->create(
                    $this->extractCoordinate($data)
                )
            );

        return $this->clearInstance();
    }

    /**
     * @param Location $location
     * @return void
     */
    public function setLocation( Location $location ): void
    {
        $this->location->setValue( $this->instance, $location );
    }

    /**
     * @param float $distance
     * @return void
     */
    public function setDistance( float $distance ): void
    {
        $this->distance->setValue( $this->instance, $distance );
    }

    /**
     * @param Direction $direction
     * @return void
     */
    public function setDirection( Direction $direction ): void
    {
        $this->direction->setValue( $this->instance, $direction );
    }



    abstract protected function extractDistance( array $waypoint ):float;
    abstract protected function extractCoordinate( array $waypoint ):array;





}