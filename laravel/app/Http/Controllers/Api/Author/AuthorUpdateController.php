<?php

namespace App\Http\Controllers\Api\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use Archivus\Domain\Author\Update\Request as Command;
use Archivus\Domain\Author\Update\UseCase;
use Illuminate\Http\Response;
use Throwable;

class
AuthorUpdateController extends Controller
{
    public function __construct(private readonly UseCase $useCase)
    { ; }

    public function __invoke(AuthorRequest $request, int $authorId): Response
    {
        try {
            $data = $request->validated();
            $data['id'] = $authorId;

            $command = Command::fromArray($data);

            $this->useCase->execute($command);

            return response(status: Response::HTTP_OK);

        } catch (Throwable) { return response(status: Response::HTTP_INTERNAL_SERVER_ERROR); }
    }
}
