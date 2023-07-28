<?php

namespace Maris\Symfony\Direction\Entity;

use Doctrine\Common\Collections\Collection;
use Exception;
use IteratorAggregate;
use Maris\Symfony\Direction\Collections\RouteList;
use Maris\Symfony\Direction\Collections\WaypointList;
use Maris\Symfony\Direction\Exceptions\DirectionException;
use Maris\Symfony\Direction\Iterators\RouteIterator;

/**
 * Модель маршрута.
 * Не имеет мутаторов, создается фабриками и является неизменяемым.
 * Является перебираемым (перебирает маршруты).
 * Доступ к свойствам осуществляется через __get()
 *
 * @property-read int|null $id Идентификатор записи в базе данных.
 * @property-read bool $success Статус успешного получения маршрута от какого либо сервиса.
 * @property-read string $status Статус ответа от сервиса.
 * @property-read string $message Сообщение от сервиса в случае провала.
 * @property-read Exception $error Подготовленный объект исключения в случае провала.
 * @property-read WaypointList $waypoints Список путевых точек.
 * @property-read RouteList $routes Список маршрутов.
 */
class Direction implements IteratorAggregate
{
    /**
     * ID в базе данных
     * @var int|null
     */
    protected ?int $id = null;

    /**
     * Список маршрутов
     * @var Collection<Route>
     */
    protected Collection $routes;

    /**
     * Список путевых точек
     * @var Collection<Waypoint>
     */
    protected Collection $waypoints;

    /**
     * Статус валидности маршрута
     * @var string
     */
    protected string $status;

    /**
     * Сообщение об ошибке.
     * @var string|null
     */
    protected ?string $message = null;

    protected function __construct()
    {
        $this->routes = new RouteList();
        $this->waypoints = new WaypointList();
    }

    public function __get(string $name)
    {
        return match ($name){
            "id" => $this->id,
            "success" => $this->status === "Ok",
            "status" => $this->status,
            "message" => $this->message,
            "waypoints" => $this->waypoints,
            "routes" => $this->routes,
            "error" => new DirectionException( $this->message, $this->status ),
            default => null
        };
    }

    /**
     * Перебирает маршруты
     * @return RouteIterator
     * @throws Exception
     */
    public function getIterator(): RouteIterator
    {
        return $this->routes->getIterator();
    }

}