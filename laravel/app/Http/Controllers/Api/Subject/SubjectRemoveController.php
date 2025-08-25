<?php

namespace App\Http\Controllers\Api\Subject;

use App\Http\Controllers\Controller;
use Archivus\Domain\Subject\Shared\Exceptions\CannotDeleteAuthorWithBooksException;
use Archivus\Domain\Subject\Remove\Request as Command;
use Archivus\Domain\Subject\Remove\UseCase;
use Archivus\Domain\Subject\Shared\Exceptions\SubjectRemoveException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class SubjectRemoveController extends Controller
{
    public function __construct(private readonly UseCase $useCase)
    { ; }

    public function __invoke(Request $request, int $id): Response
    {
        try {
            $command = new Command($id);

            $this->useCase->execute($command);

            return response(status: Response::HTTP_NO_CONTENT);

        } catch (CannotDeleteAuthorWithBooksException) { return response(status: Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (SubjectRemoveException $e) { return response(status: Response::HTTP_BAD_REQUEST);
        } catch (Throwable $th) { return response(status: Response::HTTP_INTERNAL_SERVER_ERROR); }
    }
}
