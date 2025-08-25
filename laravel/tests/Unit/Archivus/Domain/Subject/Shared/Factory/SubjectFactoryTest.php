<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Archivus\Domain\Subject\Shared\Factory\SubjectFactory;
use Archivus\Domain\Subject\Subject;

final class SubjectFactoryTest extends TestCase
{
    private SubjectFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new SubjectFactory();
    }

    public function testCreateReturnsSubjectWithNullId(): void
    {
        $descriptionText = 'Matemática';
        $subject = $this->factory->create($descriptionText);

        $this->assertInstanceOf(Subject::class, $subject);
        $this->assertNull($subject->id);
        $this->assertSame($descriptionText, $subject->description->value);
    }

    public function testLoadReturnsSubjectWithGivenId(): void
    {
        $id = 5;
        $descriptionText = 'Física';
        $subject = $this->factory->load($id, $descriptionText);

        $this->assertInstanceOf(Subject::class, $subject);
        $this->assertSame($id, $subject->id);
        $this->assertSame($descriptionText, $subject->description->value);
    }
}
