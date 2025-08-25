<?php

namespace App\Http\Controllers\Api\Author;

use Archivus\Domain\Author\Shared\Exceptions\CannotDeleteAuthorWithBooksException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Archivus\Domain\Author\Remove\UseCase;
use Archivus\Domain\Author\Remove\Request as Command;
use Archivus\Domain\Author\Shared\Exceptions\AuthorRemoveException;
use Throwable;

class AuthorRemoveController extends Controller
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
        } catch (AuthorRemoveException) { return response(status: Response::HTTP_BAD_REQUEST);
        } catch (Throwable) { return response(status: Response::HTTP_INTERNAL_SERVER_ERROR); }
    }
}
