<?php
class Orgao extends MyModel{

	public function scopeFilter($q, $filter){
		if(is_array($filter)){
			foreach($filter as $k=>$v){
				
				switch($k){
					case 'nome':!empty($v) && $q->where('nome', 'like', '%'.$v.'%');break;
					case 'mail':!empty($v) && $q->where('mail', 'like', $v.'%');break;
					case 'end_logradouro':$q->where('end_logradouro', 'like', $v.'%');break;
					default:;
				}

			}
		}
	}
}