<?php

class RestController extends Controller {
	protected $vrs = array();
	protected $layout = 'layouts.default';
	protected $layout_ajax = 'layouts.ajax';
	protected $ajax = false;

	protected function setupLayout()
	{
		$this->vrs['base'] = URL::to('/');
		

		$this->vrs['user']['login'] = false;
		if(Auth::check()){
			$this->vrs['user'] = Auth::user()->toArray();
			$this->vrs['user']['avatar'] = 'https://scontent-a-gru.xx.fbcdn.net/hphotos-prn2/v/t1.0-9/541899_608907005834244_1196288044_n.jpg?oh=ca0ee85cccd252b6876ffe9986a68924&oe=54863764';
			$this->vrs['user']['login'] = true;
		}
		
		$v = $this->vrs;

		$this->layout = View::make(!Request::ajax()?$this->layout:$this->layout_ajax,$v);
		$this->layout->title = 'Exito do Cariri - ';
		$this->layout->html = array(
	'doctype' => '<!DOCTYPE html>',
	'icon' => '/favicon.ico'
		);
$this->addStyle('http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css');
$this->addStyle('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css');
$this->addStyle($this->vrs['base'] . '/assets/style.css');
$this->addScript('http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js');
$this->addScript('https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js');

	}
	public function missingMethod($params = array()){
		return $this->showError(404);
	}
	protected function showError($code){
		$this->vrs['error'] = $code;
		return $this->layout->nest('main','layouts.errors', $this->vrs);
	}
	protected function addScript($url, $attrs = array()){
		$attrs['src'] = $url;
		$this->layout->html['header'][] = '<script '.$this->attrs($attrs)." /></script>";
		return $this;
	}
	protected function addStyle($url, $attrs=array()){
		$attrs['rel'] = 'stylesheet';
		$attrs['href'] = $url;
		$this->addLink($attrs);
		return $this;
	}
	protected function addLink($attrs){
		$this->layout->html['header'][] = '<link '.$this->attrs($attrs)." />";
		return $this;
	}
	protected function attrs($attrs){
		$res = '';
		if(!empty($attrs))
			foreach($attrs as $an=>$av)
				$res .= $an . '="'.$av.'" ';
		return $res;
	}


}
