<?php

declare(strict_types=1);

namespace BitWasp\Bitcoin\Transaction\Mutator;

abstract class AbstractCollectionMutator implements \Iterator, \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * @var \SplFixedArray
     */
    protected $set;

    /**
     * @var \Iterator
     */
    protected $iterator;

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->set->toArray();
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return count($this->set) === 0;
    }

    /**
     * @return \Iterator
     */
    public function getIterator(): \Iterator
    {
        if ($this->iterator === null) {
            $this->iterator = version_compare(PHP_VERSION, '8.0.0', '<') ? $this->set : $this->set->getIterator();
        }

        return $this->iterator;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->set->count();
    }

    /**
     *
     */
    #[\ReturnTypeWillChange]
    public function rewind()
    {
        $this->getIterator()->rewind();
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->getIterator()->current();
    }

    /**
     * @return int
     */
    #[\ReturnTypeWillChange]
    public function key()
    {
        return $this->getIterator()->key();
    }

    /**
     *
     */
    #[\ReturnTypeWillChange]
    public function next()
    {
        $this->getIterator()->next();
    }

    /**
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function valid()
    {
        return $this->getIterator()->valid();
    }

    /**
     * @param int $offset
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return $this->set->offsetExists($offset);
    }

    /**
     * @param int $offset
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new \InvalidArgumentException('Offset does not exist');
        }

        $this->set->offsetUnset($offset);
    }

    /**
     * @param int $offset
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        if (!$this->set->offsetExists($offset)) {
            throw new \OutOfRangeException('Nothing found at this offset');
        }
        return $this->set->offsetGet($offset);
    }

    /**
     * @param int $offset
     * @param mixed $value
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        $this->set->offsetSet($offset, $value);
    }
}
