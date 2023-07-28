<?php

namespace Maris\Symfony\Direction\Factory;

use Maris\Symfony\Direction\Collections\WaypointList;
use Maris\Symfony\Direction\Entity\Direction;
use Maris\Symfony\Direction\Entity\Route;
use Maris\Symfony\Direction\Entity\Segment;
use Maris\Symfony\Direction\Entity\Waypoint;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * Абстрактный класс для всех фабрик
 *
 * @template T as object
 */
abstract class AbstractFactory
{
    protected ReflectionClass $reflection;

    protected ReflectionProperty $id;


    protected ?object $instance = null;


    /**
     * @param class-string $class
     * @throws ReflectionException
     */
    public function __construct( string $class )
    {
        $this->reflection = new ReflectionClass($class);
        $this->id = $this->reflection->getProperty("id");
    }

    /**
     * Устанавливает свойство $id объекта Direction
     * @param int|null $id
     * @return void
     */
    protected function setId( int|null $id ): void
    {
        if(isset($this->instance))
            $this->id->setValue( $this->instance, $id );
    }

    /**
     * Создает новый объект в памяти фабрики
     * @return void
     * @throws ReflectionException
     */
    protected function buildInstance():void
    {
        $this->instance =  $this->reflection->newInstanceWithoutConstructor();
    }

    /***
     * Возвращает объект и очищает его из памяти
     * @return T|null
     */
    protected function clearInstance():object|null
    {
        $instance = $this->instance;
        $this->instance = null;
        return $instance;
    }

    /**
     * Генерирует Direction::$id из массива с данными
     * @param array $array
     * @return int|null
     */
    abstract protected function extractId( array $array ): int|null;



}