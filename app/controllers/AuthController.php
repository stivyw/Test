<?php
class AuthController extends MyController {

	public function getIndex()
	{
//		$this->res->tk = Request::header('X-CSRF-Token');
		$this->res->ok = Auth::check() && Session::token() == Request::header('X-CSRF-Token');
//		if($this->res->user = Auth::user())
//			$this->res->user->perms = unserialize($this->res->user->perms);
		return Response::json($this->res);
	}

	public function postIndex()
	{
		$userdata = array(
			'username' => Input::get('username'),
			'password' => Input::get('password')
		);
		if($userdata['username'] && $userdata['password']){
			if(Auth::attempt($userdata))
				$this->res->token = Session::token();
			else
				$this->res->error = true;
		}
		
		$this->res->user = Auth::user();
		if($this->res->user)
			$this->res->user->perms = unserialize($this->res->user->perms);

		return Response::json($this->res);
	}
	public function getLogout()
	{
		!Auth::guest() && Auth::logout();
		$this->res->ok = true;
		return Response::json($this->res);

	}

}
