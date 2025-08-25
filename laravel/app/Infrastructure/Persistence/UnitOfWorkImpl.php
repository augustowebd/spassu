<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use Exception;
use Illuminate\Support\Facades\DB;
use Archivus\Shared\UnitOfWorkInterface;
use Archivus\Shared\Exceptions\UnitOfWorkFailException;

class UnitOfWorkImpl implements UnitOfWorkInterface
{
    public function execute(callable $work): void
    {
        DB::beginTransaction();
        try {
            $work();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            UnitOfWorkFailException::throwsIf(
                assert: true,
                message: $e->getMessage()
            );
        }
    }
}
