<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {        
        $response = null;
        
        if ($exception instanceof ModelNotFoundException) {
          $response = trans('app.not_found');  
          //$response = 'Entry for '.str_replace('App\\', '', $exception->getModel()).' not found';          
        }else if ($exception instanceof QueryException) {
          $response = $exception->getMessage();
        }else if ($exception instanceof ValidationException) {
          $response = $exception->getMessage();
        }else if ($exception instanceof Exception) {
          $response = $exception->getMessage();
        }else{
          $response = $exception->getMessage();
        }
        
        if (request()->wantsJson()) {
          $arr['status'] = false;
          $arr['msg'] = $response;
          return response()->json($arr); 
        }else{
          if(isset($_GET['redirect'])&&strlen($_GET['redirect'])>0){
            return redirect($_GET['redirect'])->withInput($request->toArray())->withErrors($response);
          }else{
            return back()->withInput($request->toArray())->withErrors($response);
          }
        }                      
        return parent::render($request, $exception);
    }
}
