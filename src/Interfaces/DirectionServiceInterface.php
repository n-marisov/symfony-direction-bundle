<?php

namespace Maris\Symfony\Direction\Interfaces;

use Maris\Symfony\Direction\Entity\Direction;
use Maris\Symfony\Geo\Entity\Polyline;

/***
 * Интерфейс для сервиса запроса маршрута.
 */
interface DirectionServiceInterface
{

    /***
     * @param Polyline $coordinates
     * @param array $options
     * @return Direction
     */
    public function getDirection( Polyline $coordinates, array $options ):Direction;

}