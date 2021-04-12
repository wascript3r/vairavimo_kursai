<?php

class contractStatus {
	
	private $sutarties_busenos_lentele = '';

	public function __construct() {
		$this->sutarties_busenos_lentele = 'sutarties_busenos';
	}

	public function getContractStatusList($limit = null, $offset = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}
		
		$query = "  SELECT id_sutarties_busenos AS id, name
					FROM {$this->sutarties_busenos_lentele}{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}
}