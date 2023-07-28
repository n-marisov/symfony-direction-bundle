<?php

namespace Maris\Symfony\Direction\Iterators;

use Iterator;
use Maris\Symfony\Direction\Collections\RouteList;
use Maris\Symfony\Direction\Entity\Route;

/**
 * Итератор для переборки маршрута.
 * Необходим, чтобы запретить прямой доступ к списку маршрутов
 * в объекте Direction.
 */
class RouteIterator implements Iterator
{
    /**
     * Список маршрутов
     * @var RouteList
     */
    protected RouteList $elements;

    /**
     * Количество маршрутов в списке
     * @var int
     */
    protected int $count;

    /**
     * @param RouteList $elements
     */
    public function __construct( RouteList $elements )
    {
        $this->elements = $elements;
        $this->count = count( $elements );
    }


    /**
     * @inheritDoc
     */
    public function current(): Route
    {
        return $this->elements->current();
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        $this->elements->next();
    }

    /**
     * @inheritDoc
     */
    public function key(): int
    {
        return $this->elements->key();
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return $this->key() < $this->count;
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        $this->elements->first();
    }
}