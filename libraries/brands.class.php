<?php
/**
 * Automobilių markių redagavimo klasė
 *
 * @author ISK
 */

class brands {
	
	private $markes_lentele = '';
	private $automobiliai_lentele = '';
	
	public function __construct() {
		$this->markes_lentele = 'MARKES';
		$this->automobiliai_lentele = 'AUTOMOBILIAI';
	}

	public function getBrand($id) {
		$query = "  SELECT *
					FROM {$this->markes_lentele}
					WHERE `id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}

	public function getBrandList($limit = null, $offset = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}
		
		$query = "  SELECT *
					FROM {$this->markes_lentele}{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}

	public function getBrandListCount() {
		$query = "  SELECT COUNT(`id`) as `kiekis`
					FROM {$this->markes_lentele}";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}

	public function insertBrand($data) {
		$query = "  INSERT INTO {$this->markes_lentele}
								(
									`pavadinimas`
								)
								VALUES
								(
									'{$data['pavadinimas']}'
								)";
		mysql::query($query);
	}

	public function updateBrand($data) {
		$query = "  UPDATE {$this->markes_lentele}
					SET    `pavadinimas`='{$data['pavadinimas']}'
					WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}

	public function deleteBrand($id) {
		$query = "  DELETE FROM {$this->markes_lentele}
					WHERE `id`='{$id}'";
		mysql::query($query);
	}

	public function getCarCountOfBrand($id) {
		$query = "  SELECT COUNT({$this->automobiliai_lentele}.`valstybinis_nr`) AS `kiekis`
					FROM {$this->markes_lentele}
						INNER JOIN {$this->automobiliai_lentele}
							ON {$this->markes_lentele}.`id`={$this->automobiliai_lentele}.`fk_MARKE_id`
					WHERE {$this->markes_lentele}.`id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
}