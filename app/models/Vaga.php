<?php
class Unidade extends MyModel{

	public function orgao(){
		return $this->belongsTo('Orgao');
	}

	public function scopeFilter($q, $filter){
		if(is_array($filter)){
			foreach($filter as $k=>$v){
				switch($k){
					case 'unidade':$q->where('unidade_id', $v);break;
					case 'servidor':$q->where('servidor_id', $v);break;
					default:;
				}

			}
		}
	}
}