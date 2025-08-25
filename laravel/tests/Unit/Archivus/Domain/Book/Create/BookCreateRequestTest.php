<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Domain\Book\Create\Request;

final class BookCreateRequestTest extends TestCase
{
    public function testCanBeInstantiatedWithConstructor(): void
    {
        $request = new Request(
            title: 'Book Title',
            publisher: 'Publisher Name',
            edition: '1st',
            year: 2025,
            price: 49.9,
            authorIds: [1, 2],
            subjectIds: [10, 20]
        );

        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame('Book Title', $request->title);
        $this->assertSame('Publisher Name', $request->publisher);
        $this->assertSame('1st', $request->edition);
        $this->assertSame(2025, $request->year);
        $this->assertSame(49.9, $request->price);
        $this->assertSame([1, 2], $request->authorIds);
        $this->assertSame([10, 20], $request->subjectIds);
    }

    public function testCanBeInstantiatedFromArray(): void
    {
        $data = [
            'title' => 'Book Title',
            'publisher' => 'Publisher Name',
            'edition' => '1st',
            'year' => 2025,
            'price' => 49.9,
            'authorIds' => [1, 2],
            'subjectIds' => [10, 20],
        ];

        $request = Request::fromArray($data);

        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame('Book Title', $request->title);
        $this->assertSame('Publisher Name', $request->publisher);
        $this->assertSame('1st', $request->edition);
        $this->assertSame(2025, $request->year);
        $this->assertSame(49.9, $request->price);
        $this->assertSame([1, 2], $request->authorIds);
        $this->assertSame([10, 20], $request->subjectIds);
    }

    public function testFromArrayUsesEmptyArraysForMissingIds(): void
    {
        $data = [
            'title' => 'Book Title',
            'publisher' => 'Publisher Name',
            'edition' => '1st',
            'year' => 2025,
            'price' => 49.9,
        ];

        $request = Request::fromArray($data);

        $this->assertSame([], $request->authorIds);
        $this->assertSame([], $request->subjectIds);
    }
}
