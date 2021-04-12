<?php

class contractTypes {
	
	private $sutarties_tipai_lentele = '';

	public function __construct() {
		$this->sutarties_tipai_lentele = 'sutarties_tipai';
	}

	public function getContractTypeList($limit = null, $offset = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}
		
		$query = "  SELECT id_sutarties_tipai AS id, name
					FROM {$this->sutarties_tipai_lentele}{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}
}