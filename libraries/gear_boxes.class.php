<?php

class gearBoxes {
	
	private $pavaru_dezes_lentele = '';

	public function __construct() {
		$this->pavaru_dezes_lentele = 'pavaru_dezes';
	}

	public function getGearBoxList($limit = null, $offset = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}
		
		$query = "  SELECT id_pavaru_dezes AS id, name
					FROM {$this->pavaru_dezes_lentele}{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}
}