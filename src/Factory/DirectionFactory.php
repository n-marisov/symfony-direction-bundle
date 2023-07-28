<?php

namespace Maris\Symfony\Direction\Factory;

use Maris\Symfony\Direction\Collections\RouteList;
use Maris\Symfony\Direction\Collections\WaypointList;
use Maris\Symfony\Direction\Entity\Direction;
use ReflectionException;
use ReflectionProperty;

/**
 * Фабрика для создания объекта Direction
 *
 */
abstract class DirectionFactory extends AbstractFactory
{
    protected ReflectionProperty $status;

    protected ReflectionProperty $message;

    protected ReflectionProperty $routes;


    protected ReflectionProperty $waypoints;

    protected RouteFactory $routeFactory;

    protected WaypointFactory $waypointFactory;


    /**
     * @throws ReflectionException
     */
    public function __construct( RouteFactory $routeFactory, WaypointFactory $waypointFactory )
    {
        parent::__construct( Direction::class );

        $this->routeFactory = $routeFactory;
        $this->waypointFactory = $waypointFactory;

        $this->status = $this->reflection->getProperty("status");
        $this->message = $this->reflection->getProperty("message");
        $this->routes = $this->reflection->getProperty("routes");
        $this->waypoints = $this->reflection->getProperty("waypoints");
    }

    /**
     * @param array $data
     * @return Direction|null
     * @throws ReflectionException
     */
    final public function create( array $data ):?Direction
    {
        $this->buildInstance();

            $this->setId(  $this->extractId( $data ) );
            $this->setStatus( $this->extractStatus( $data ) );
            $this->setMessage( $this->extractMessage( $data ) );

            $this->setRoutes(
                $this->createRouteList(
                    $this->extractArrayRoutes( $data )
                )
            );

            $this->setWaypoints(
                $this->createWaypointList(
                    $this->extractArrayWaypoints( $data )
                )
            );

        return $this->clearInstance();
    }


    /**
     * Генерирует Direction::$status из массива с данными
     * @param array $direction
     * @return string
     */
    abstract protected function extractStatus(array $direction ): string;

    /**
     * Генерирует Direction::$message из массива с данными
     * @param array $direction
     * @return string|null
     */
    abstract protected function extractMessage( array $direction ): ?string;

    /**
     * Возвращает массив с маршрутами из исходного массива
     * @param array $direction
     * @return array
     */
    abstract protected function extractArrayRoutes(array $direction ):array;

    /**
     * Возвращает массив с путевыми точками из исходного массива
     * @param array $direction
     * @return array
     */
    abstract protected function extractArrayWaypoints( array $direction ):array;

        /**
     * Генерирует Direction::$routes из массива с данными
     * @param array $routes
     * @return RouteList
     */
    protected function createRouteList( array $routes ):RouteList
    {
        $list = new RouteList();

        foreach ($routes as $route)
            $list->add( $this->routeFactory->create( $route, $this->instance ) );

        return $list;
    }

    /**
     * Генерирует Direction::$waypoints из массива с данными
     * @param array $waypoints
     * @return WaypointList
     */
    protected function createWaypointList( array $waypoints ):WaypointList
    {
        $list = new WaypointList();

        foreach ( $waypoints as $waypoint )
            $list->add( $this->waypointFactory->create( $waypoint, $this->instance ) );

        return $list;
    }

    /**
     * Устанавливает свойство $status объекта Direction
     * @param string|null $status
     * @return void
     */
    function setStatus( string|null $status): void
    {
        if(isset($this->instance))
            $this->status->setValue( $this->instance, $status );
    }

    /**
     * Устанавливает свойство $message объекта Direction
     * @param string|null $message
     * @return void
     */
    protected function setMessage( string|null $message ): void
    {
        if(isset($this->instance))
        $this->message->setValue( $this->instance, $message );
    }
    /**
     * Устанавливает свойство $routes объекта Direction
     * @param RouteList $routes
     * @return void
     */
     protected function setRoutes( RouteList $routes): void
     {
         if(isset($this->instance))
             $this->routes->setValue( $this->instance, $routes );
     }
    /**
     * Устанавливает свойство $waypoints объекта Direction
     * @param WaypointList $waypoints
     * @return void
     */
     protected function setWaypoints( WaypointList $waypoints ): void
     {
         if(isset($this->instance))
             $this->waypoints->setValue( $this->instance, $waypoints );
     }


}