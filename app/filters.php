<?php

App::error(function(Exception $exception, $code)
{
	$err = new stdClass;

	$pathInfo = Request::getPathInfo();
	$err->message = $exception->getMessage();

//	Log::error("$code - $message @ $pathInfo\r\n$exception");

	if (Config::get('app.debug')) {
		return;
	}
//return Response::make('errors/asfd');

	
	$err->code=$code;

	if(empty($err->message))
		switch ($code)
		{
			case 403:$err->message = 'Erro( '. $message .' )';break;
			case 404:$err->message = 'Erro! Este local não existe.';break;
			case 500:$err->message = 'Erro interno do servidor( '. $message .' )';break;
			default: $err->message = 'Erro( '. $message .' )';
		}
	$res['error'][] = $err;
	return Response::json($res);
});

App::before(function($request)
{
	$gbl = new stdClass;
	if(Auth::check()){
		$gbl->u = Auth::user()->toArray();
		//$gbl->u['perms'] = unserialize($gbl->u['perms']);
		$gbl->perms = unserialize($gbl->u['perms']);
	}
	App::instance('gbl', $gbl);

});


App::after(function($request, $response)
{
	//return Response::json($response);
});


Route::filter('auth', function()
{ die('Filter auth');
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic('username');
});


Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/** /
Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
/**/

Route::filter('csrf', function()
{
  if(Request::json() && !Input::get('_token'))
  {
    if(Session::token() != Request::header('X-CSRF-Token'))
//      throw new Illuminate\Session\TokenMismatchException;
    	App::abort(403, 'Sua sessão expirou ou você não tem permissão para acessar! Por favor, refaça o login.');
  } else if (!Request::json()) {
    if(Session::token() != Input::get('_token'))
//      throw new Illuminate\Session\TokenMismatchException;
    	App::abort(403, 'Sua sessão expirou ou você não tem permissão para acessar.! Por favor, refaça o login.');
  }
});
/**/
