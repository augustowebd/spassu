<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Domain\Book\Update\Request;

final class UpdateBookRequestTest extends TestCase
{
    public function testCanBeInstantiatedWithConstructor(): void
    {
        $request = new Request(
            id: 1,
            title: 'Livro Teste',
            publisher: 'Editora Alfa',
            edition: '1ª',
            year: 2023,
            price: 99.90,
            authorIds: [1, 2],
            subjectIds: [3, 4]
        );

        $this->assertSame(1, $request->id);
        $this->assertSame('Livro Teste', $request->title);
        $this->assertSame('Editora Alfa', $request->publisher);
        $this->assertSame('1ª', $request->edition);
        $this->assertSame(2023, $request->year);
        $this->assertSame(99.90, $request->price);
        $this->assertSame([1,2], $request->authorIds);
        $this->assertSame([3,4], $request->subjectIds);
    }

    public function testCanBeInstantiatedFromArray(): void
    {
        $data = [
            'id' => 1,
            'title' => 'Livro Teste',
            'publisher' => 'Editora Alfa',
            'edition' => '1ª',
            'year' => 2023,
            'price' => '99,90',
            'authorIds' => [1, 2],
            'subjectIds' => [3, 4]
        ];

        $request = Request::fromArray($data);

        $this->assertSame(1, $request->id);
        $this->assertSame('Livro Teste', $request->title);
        $this->assertSame('Editora Alfa', $request->publisher);
        $this->assertSame('1ª', $request->edition);
        $this->assertSame(2023, $request->year);
        $this->assertSame(99.90, $request->price);
        $this->assertSame([1,2], $request->authorIds);
        $this->assertSame([3,4], $request->subjectIds);
    }

    public function testDefaultsToEmptyArrays(): void
    {
        $data = [
            'id' => 1,
            'title' => 'Livro Teste',
            'publisher' => 'Editora Alfa',
            'edition' => '1ª',
            'year' => 2023,
            'price' => '50,00'
        ];

        $request = Request::fromArray($data);
        $this->assertSame([], $request->authorIds);
        $this->assertSame([], $request->subjectIds);

        $this->assertSame(50.00, $request->price);
    }
}
