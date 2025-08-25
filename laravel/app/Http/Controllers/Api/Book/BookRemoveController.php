<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use Archivus\Domain\Book\Remove\Request as Command;
use Archivus\Domain\Book\Remove\UseCase;
use Archivus\Domain\Book\Shared\Exceptions\BookRemoveException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class BookRemoveController extends Controller
{
    public function __construct(private readonly UseCase $useCase)
    { ; }

    public function __invoke(Request $request, int $id): Response
    {
        try {
            $command = new Command($id);

            $this->useCase->execute($command);

            return response(status: Response::HTTP_NO_CONTENT);

        } catch (BookRemoveException) { return response(status: Response::HTTP_BAD_REQUEST);
        } catch (Throwable) { return response(status: Response::HTTP_INTERNAL_SERVER_ERROR); }
    }
}
