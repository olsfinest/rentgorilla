<?php namespace RentGorilla\Exceptions;

use Log;
use App;
use Redirect;
use Exception;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		HttpException::class,
		ModelNotFoundException::class,
        TokenMismatchException::class
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{

        if ($e instanceof TokenMismatchException)
        {
            Log::error('Token Mismatch Exception', ['url' => $request->fullUrl(), 'ip' => $request->ip(), 'request' => $request->all()]);

            if($request->ajax()) {
                return response()->json(['message' => 'Your session has expired. Please reload page and try again.'], 403);
            } else {
                return redirect()->route('home')->with('flash:success', 'Your session has expired.');
            }
        }

        if ($e instanceof ModelNotFoundException)
        {
            return App::abort(404);
        }

		if ($this->isHttpException($e))
		{
			return $this->renderHttpException($e);
		}
		else
		{
			return parent::render($request, $e);
		}
	}

}
