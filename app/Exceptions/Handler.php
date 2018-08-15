<?php

namespace App\Exceptions;

use Anetwork\Respond\Facades\Respond;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an json exception into an HTTP response.
     *
     * @param  \Exception $exception
     * @return Respond
     */
    public function renderJsonResponse(Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {

            return \Respond::notFound();
        } elseif ($exception instanceof NotFoundHttpException) {

            return \Respond::notfound();
        } elseif ($exception instanceof BadRequestHttpException) {

            return \Respond::setStatusCode(400)
                ->setStatusText('Bad request !')
                ->respondWithResult($exception->getMessage());

        } elseif($exception instanceof MethodNotAllowedHttpException) {

            return \Respond::methodNotAllowed();
        } elseif($exception instanceof ValidationException) {

            return \Respond::setStatusCode( 422 )
                ->setStatusText('fail')
                ->respondWithResult([
                    'message' => $exception->getMessage(),
                    'data' => $exception->validator->errors()
                ]);
        } elseif($exception instanceof HttpException){

            return \Respond::setStatusCode( $exception->getStatusCode() )
                ->setStatusText('fail')
                ->respondWithResult($exception->getMessage());
        }

        return \Respond::setStatusCode(400)
            ->setStatusText('ErrorException !')
            ->respondWithMessage([
                'message' => $exception->getMessage(),
                'trace' => $exception->getTrace()
            ]);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param $request
     * @param  \Exception $exception
     * @return Respond
     */
    public function render($request, Exception $exception)
    {
        return $this->renderJsonResponse($exception);
    }
}
