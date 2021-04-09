<?php

class branches {
	
	private $filialai_lentele = '';
	private $automobiliai_lentele = '';
	private $instruktoriai_lentele = '';
	private $sutartys_lentele = '';

	public function __construct() {
		$this->filialai_lentele = 'FILIALAI';
		$this->automobiliai_lentele = 'AUTOMOBILIAI';
		$this->instruktoriai_lentele = 'INSTRUKTORIAI';
		$this->sutartys_lentele = 'SUTARTYS';
	}

	public function getBranch($id) {
		$query = "  SELECT *
					FROM {$this->filialai_lentele}
					WHERE `id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}

	public function getBranchList($limit = null, $offset = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}
		
		$query = "  SELECT *
					FROM {$this->filialai_lentele}{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}

	public function getBranchListCount() {
		$query = "  SELECT COUNT(`id`) as `kiekis`
					FROM {$this->filialai_lentele}";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}

	public function insertBranch($data) {
		$query = "  INSERT INTO {$this->filialai_lentele}
								(
									`adresas`,
									`kontaktinis_tel`
								)
								VALUES
								(
									'{$data['adresas']}',
									'{$data['kontaktinis_tel']}'
								)";
		mysql::query($query);
	}

	public function updateBranch($data) {
		$query = "  UPDATE {$this->filialai_lentele}
					SET    `adresas`='{$data['adresas']}',
					       `kontaktinis_tel`='{$data['kontaktinis_tel']}'
					WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}

	public function deleteBranch($id) {
		$query = "  DELETE FROM {$this->filialai_lentele}
					WHERE `id`='{$id}'";
		mysql::query($query);
	}

	public function getCarCountOfBranch($id) {
		$query = "  SELECT COUNT({$this->automobiliai_lentele}.`valstybinis_nr`) AS `kiekis`
					FROM {$this->filialai_lentele}
						INNER JOIN {$this->automobiliai_lentele}
							ON {$this->filialai_lentele}.`id`={$this->automobiliai_lentele}.`fk_FILIALAS_id`
					WHERE {$this->filialai_lentele}.`id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}

	public function getInstructorCountOfBranch($id) {
		$query = "  SELECT COUNT({$this->instruktoriai_lentele}.`id`) AS `kiekis`
					FROM {$this->filialai_lentele}
						INNER JOIN {$this->instruktoriai_lentele}
							ON {$this->filialai_lentele}.`id`={$this->instruktoriai_lentele}.`fk_FILIALAS_id`
					WHERE {$this->filialai_lentele}.`id`='{$id}'";
		$data = mysql::select($query);

		return $data[0]['kiekis'];
	}

	public function getContractCountOfBranch($id) {
		$query = "  SELECT COUNT({$this->sutartys_lentele}.`id`) AS `kiekis`
					FROM {$this->filialai_lentele}
						INNER JOIN {$this->sutartys_lentele}
							ON {$this->filialai_lentele}.`id`={$this->sutartys_lentele}.`fk_FILIALAS_id`
					WHERE {$this->filialai_lentele}.`id`='{$id}'";
		$data = mysql::select($query);

		return $data[0]['kiekis'];
	}
}