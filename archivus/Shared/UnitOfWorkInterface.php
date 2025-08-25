<?php

declare(strict_types=1);

namespace Archivus\Shared;

use Archivus\Shared\Exceptions\UnitOfWorkFailException;

interface UnitOfWorkInterface
{
    /**
     * @throws UnitOfWorkFailException
     */
    public function execute(callable $work): void;
}
