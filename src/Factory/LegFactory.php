<?php

namespace Maris\Symfony\Direction\Factory;

use Maris\Symfony\Direction\Collections\LegList;
use Maris\Symfony\Direction\Collections\StepList;
use Maris\Symfony\Direction\Entity\Leg;
use Maris\Symfony\Direction\Entity\Route;
use Maris\Symfony\Direction\Entity\Step;


/**
 * Фабрика для создания объекта Direction
 */
abstract class LegFactory extends SegmentFactory
{
    protected StepFactory $factory;
    public function __construct( StepFactory $factory )
    {
        parent::__construct(Leg::class );
        $this->factory = $factory;
    }


    public function create( array $leg , $route ): Leg
    {
        $this->buildInstance();

            $this->setParent($route);

            $this->setId( $this->extractId( $leg ) );

            $this->setDistance( $this->extractDistance($leg) );
            $this->setDuration( $this->extractDuration($leg) );

            $this->setSteps(
                $this->createStepList(
                    $this->extractArraySteps( $leg )
                )
            );
        return $this->clearInstance();
    }

    protected function setSteps( StepList $list ):void
    {
        if(isset($this->instance))
            $this->children->setValue( $this->instance, $list );
    }

    protected function createStepList( array $legs ):StepList
    {
        $list = new StepList();

        foreach ($legs as $leg)
            $list->add( $this->factory->create( $leg ,$this->instance ) );

        return $list;
    }

    abstract protected function extractArraySteps( array $leg ):array;
}