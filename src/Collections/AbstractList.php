<?php

namespace Maris\Symfony\Direction\Collections;

use Closure;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\PersistentCollection;
use Exception;
use Maris\Symfony\Direction\Entity\Waypoint;
use Traversable;

/**
 * Список путевых точек
 */
class AbstractList implements Collection
{
    private string $class;
    protected Collection $elements;

    /**
     * @param Collection $elements
     * @param class-string $class
     */
    public function __construct(Collection $elements, string $class )
    {

        if(!is_a($elements,PersistentCollection::class) || !is_a($elements->getTypeClass()->getName(),$class,true)){
            $newElements = new ArrayCollection();
            foreach ($elements as $element)
                if(is_a( $element, $class ))
                    $newElements->add($element);
            $elements = $newElements;
        }

        $this->elements =  $elements;
        $this->class = $class;
    }

    public function stability():static
    {
        $this->elements = new ArrayCollection( $this->elements->getValues() );
        return $this;
    }


    /**
     * @param mixed $element
     * @return static
     */
    public function add( mixed $element ): static
    {
        if(is_a( $element, $this->class ))
            $this->elements[] = $element;
        return $this;
    }

    public function clear()
    {
        $this->elements->clear();
        return $this;
    }

    public function remove( int|string $key )
    {
        if( is_numeric( $key ) )
            $this->elements->remove( $key );
    }

    public function removeElement( mixed $element )
    {
        $this->elements->removeElement( $element );
    }

    public function set( int|string $key, mixed $value )
    {
        $this->elements->set( $key, $value );
    }

    public function getIterator(): Traversable
    {
        return $this->elements->getIterator();
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->elements->offsetExists($offset);
    }

    public function offsetGet(mixed $offset)
    {
        return $this->elements->offsetGet($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if(!is_a( $value, $this->class ))
            return;
        if( !is_numeric($offset) )
            return;

        $this->offsetSet($offset, $value);
    }

    public function offsetUnset( mixed $offset ): void
    {
        $this->elements->offsetUnset($offset);
    }

    public function count(): int
    {
        return $this->elements->count();
    }

    public function contains(mixed $element):bool
    {
        return $this->elements->contains($element);
    }

    public function isEmpty():bool
    {
        return $this->elements->isEmpty();
    }

    public function containsKey(int|string $key):bool
    {
        return is_numeric($key) && $this->containsKey($key);
    }

    public function get(int|string $key)
    {
        return $this->elements->get($key);
    }

    public function getKeys():array
    {
        return $this->elements->getKeys();
    }

    /**
     * @throws Exception
     */
    public function getValues():static
    {
        return new static( $this->elements->getValues() , $this->class  );
    }

    public function toArray():array
    {
        return $this->elements->toArray();
    }

    public function first()
    {
        return $this->elements->first();
    }

    public function last()
    {
        return $this->elements->last();
    }

    public function key():int
    {
        return $this->key();
    }

    public function current()
    {
        return $this->current();
    }

    public function next()
    {
        $this->elements->next();
    }

    public function slice(int $offset, ?int $length = null)
    {
        return $this->elements->slice( $offset, $length );
    }

    public function exists(Closure $p):bool
    {
        return $this->elements->exists( $p );
    }

    public function filter(Closure $p)
    {
        return $this->elements->filter( $p );
    }

    public function map(Closure $func)
    {
        return $this->elements->map( $func );
    }

    public function partition(Closure $p)
    {
        return $this->partition($p);
    }

    public function forAll(Closure $p)
    {
        return $this->elements->forAll( $p );
    }

    public function indexOf(mixed $element)
    {
        return $this->elements->indexOf( $element );
    }

    public function findFirst(Closure $p)
    {
        return $this->findFirst( $p );
    }

    public function reduce(Closure $func, mixed $initial = null)
    {
        return $this->elements->reduce($func,$initial);
    }
}