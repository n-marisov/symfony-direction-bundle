<?php

namespace Maris\Symfony\Direction\Exceptions;

use Exception;

/**
 * Объект ошибки маршрута.
 * Метод getCode возвращает http код ответа сервиса.
 */
class DirectionException extends Exception
{
    const SUCCESS = "SUCCESS";

    const NO_ROUTE = "NO_ROUTE";

    const NO_SEGMENT = "NO_SEGMENT";
    const NO_TOKEN = "NO_TOKEN";

    const INVALID_TOKEN = "INVALID_TOKEN";

    const FORBIDDEN = "FORBIDDEN";

    const PROFILE_NOT_FOUND = "PROFILE_NOT_FOUND";

    const INVALID_INPUT = "INVALID_INPUT";

    public function __construct( string $message , string $status )
    {
        parent::__construct( $message, match ( $status ){
            self::SUCCESS, self::NO_ROUTE,self::NO_SEGMENT => 200,
            self::NO_TOKEN, self::INVALID_TOKEN => 401,
            self::FORBIDDEN => 403,
            self::PROFILE_NOT_FOUND => 404,
            self::INVALID_INPUT => 422,
            default => 0
        });
    }


}