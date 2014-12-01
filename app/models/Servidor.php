<?php
class Servidor extends MyModel{
	protected $table = 'servidores';
	public function scopeFilter($q, $filter){
		if(is_array($filter)){
			foreach($filter as $k=>$v){
				switch($k){
					case 'nome':$q->where('nome', 'like', '%'.$v.'%');break;
					case 'mail':$q->where('mail', 'like', $v.'%');break;
					default:;
				}

			}
		}
	}}
