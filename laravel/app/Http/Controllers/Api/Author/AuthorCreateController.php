<?php

namespace App\Http\Controllers\Api\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use Archivus\Domain\Author\Create\Request as Command;
use Archivus\Domain\Author\Create\UseCase;
use Illuminate\Http\Response;
use Throwable;

class
AuthorCreateController extends Controller
{
    public function __construct(private readonly UseCase $useCase)
    { ; }

    public function __invoke(AuthorRequest $request): Response
    {
        try {
            $data = $request->validated();

            $command = Command::fromArray($data);

            $this->useCase->execute($command);

            return response(status: Response::HTTP_CREATED);

        } catch (Throwable $th) { return response(status: Response::HTTP_INTERNAL_SERVER_ERROR); }
    }
}
