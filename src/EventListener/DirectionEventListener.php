<?php

namespace Maris\Symfony\Direction\EventListener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Maris\Symfony\Direction\Collections\WaypointList;
use Maris\Symfony\Direction\Entity\Direction;
use ReflectionClass;
use ReflectionException;

/***
 * Прослушивать событий для Direction
 */
#[AsEntityListener(event: "postLoad",method:'postLoad',entity: Direction::class )]
class DirectionEventListener
{
    /**
     * @var ReflectionClass<Direction>
     */
    protected ReflectionClass $reflection;

    /**
     *
     */
    public function __construct( )
    {
        $this->reflection = new ReflectionClass(Direction::class);
    }

    /**
     * Событие получение значений из базы данных
     * @param Direction $direction
     * @param PostLoadEventArgs $args
     * @return void
     * @throws ReflectionException
     */
    public function postLoad( Direction $direction,PostLoadEventArgs $args ):void
    {
        $this->reflection->getProperty("waypoints")->setValue($direction,
            new WaypointList(
                $this->reflection->getProperty("waypoints")->getValue( $direction )
            )
        );
    }
}