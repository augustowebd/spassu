<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Domain\Subject\Shared\ValueObject\Description;
use Archivus\Shared\Exceptions\InvalidStringArgumentException;

final class DescriptionTest extends TestCase
{
    public function testCanBeCreatedWithValidString(): void
    {
        $desc = new Description('Assunto');
        $this->assertSame('Assunto', $desc->value);
    }

    public function testThrowsExceptionWhenTooLong(): void
    {
        $this->expectException(InvalidStringArgumentException::class);

        new Description(str_repeat('a', 21));
    }

    public function testSlugMethod(): void
    {
        $desc = new Description('Assunto PHP!');
        $this->assertSame('assunto-php', $desc->slug());
    }

    public function testToString(): void
    {
        $desc = new Description('Assunto');
        $this->assertSame('Assunto', $desc->toString());
        $this->assertSame('Assunto', (string) $desc);
    }

    public function testFromAndIfNotEmpty(): void
    {
        $desc = Description::from('Assunto', 5);
        $this->assertSame('Assun', $desc->value);

        $desc2 = Description::ifNotEmpty('Teste');
        $this->assertInstanceOf(Description::class, $desc2);

        $desc3 = Description::ifNotEmpty('');
        $this->assertNull($desc3);
    }
}
