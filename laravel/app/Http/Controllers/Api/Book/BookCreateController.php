<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use Archivus\Domain\Book\Create\Request as Command;
use Archivus\Domain\Book\Create\UseCase;
use Illuminate\Http\Response;
use Throwable;

class
BookCreateController extends Controller
{
    public function __construct(private readonly UseCase $useCase)
    { ; }

    public function __invoke(BookRequest $request): Response
    {
        try {
            $data = $request->validated();

            $command = Command::fromArray($data);

            $this->useCase->execute($command);

            return response(status: Response::HTTP_CREATED);

        } catch (Throwable) { return response(status: Response::HTTP_INTERNAL_SERVER_ERROR); }
    }
}
