<?php

namespace App\Http\Controllers\Api\Subject;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectRequest;
use Archivus\Domain\Subject\Create\Request as Command;
use Archivus\Domain\Subject\Create\UseCase;
use Illuminate\Http\Response;
use Throwable;

class
SubjectCreateController extends Controller
{
    public function __construct(private readonly UseCase $useCase)
    { ; }

    public function __invoke(SubjectRequest $request): Response
    {
        try {
            $data = $request->validated();

            $command = Command::fromArray($data);

            $this->useCase->execute($command);

            return response(status: Response::HTTP_CREATED);
        } catch (Throwable $th) { return response(status: Response::HTTP_INTERNAL_SERVER_ERROR); }
    }
}
