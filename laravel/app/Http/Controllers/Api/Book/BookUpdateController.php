<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use Archivus\Domain\Book\Update\Request as Command;
use Archivus\Domain\Book\Update\UseCase;
use Archivus\Domain\Book\Shared\Exceptions\BookRemoveException;
use Illuminate\Http\Response;
use Throwable;

class
BookUpdateController extends Controller
{
    public function __construct(private readonly UseCase $useCase)
    { ; }

    public function __invoke(BookRequest $request, int $bookId): Response
    {
        try {
            $data = $request->validated();
            $data['id'] = $bookId;

            $command = Command::fromArray($data);

            $this->useCase->execute($command);

            return response(status: Response::HTTP_CREATED);

        } catch (BookRemoveException) { return response(status: Response::HTTP_BAD_REQUEST);
        } catch (Throwable) { return response(status: Response::HTTP_INTERNAL_SERVER_ERROR); }
    }
}
