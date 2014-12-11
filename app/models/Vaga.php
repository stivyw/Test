<?php
class Vaga extends MyModel{

	public function cargo(){
		return $this->belongsTo('Cargo');
	}
	public function servidor(){
		return $this->belongsTo('Servidor');
	}
	public function unidade(){
		return $this->belongsTo('Unidade');
	}

	public function scopeFilter($q, $filter){
		if(is_array($filter)){
			foreach($filter as $k=>$v){
				switch($k){
					case 'cargo':$q->where('cargo_id', $v);break;
					case 'servidor':$q->where('servidor_id', $v);break;
					case 'unidade':$q->where('unidade_id', $v);break;
					default:;
				}

			}
		}
	}
}