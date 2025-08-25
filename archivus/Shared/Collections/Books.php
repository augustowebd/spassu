<?php

namespace Archivus\Shared\Collections;

use Archivus\Domain\Book\Book;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

class Books implements IteratorAggregate
{
    /** @var Book[] */
    private array $items = [];

    public function __construct(Book ...$books)
    {
        $this->items = $books;
    }

    public function add(Book $book): void
    {
        if (!$this->contains($book)) {
            $this->items[] = $book;
        }
    }

    /**
     * @return Traversable<Book>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function contains(Book $book): bool
    {
        foreach ($this->items as $item) {
            if ($item->id == $book->id) {
                return true;
            }
        }

        return false;
    }

    public function remove(Book $book): void
    {
        $this->items = array_values(array_filter(
            $this->items,
            fn (Book $item) => $item->id != $book->id
        ));
    }
}
