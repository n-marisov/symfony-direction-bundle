<?php

namespace Maris\Symfony\Direction\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Maris\Symfony\Direction\Collections\StepList;
use Maris\Symfony\Direction\Iterators\StepIterator;
use Traversable;

/**
 * @property-read StepList $steps
 */
class Leg extends Segment
{
    public function __construct()
    {
        $this->children = new StepList();
    }

    public function __get(string $name)
    {
        return match ($name){
          "steps" => $this->children,
          default =>  parent::__get($name)
        };
    }

    /**
     * @return StepList
     */
    public function getSteps(): StepList
    {
        return (is_a($this->children , StepList::class ))
            ? $this->children
            : $this->children = new StepList($this->children);
    }

    public function getIterator(): StepIterator
    {
        return $this->children->getIterator();
    }
}