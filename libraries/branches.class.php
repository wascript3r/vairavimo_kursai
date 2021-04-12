<?php

class branches {
	
	private $filialai_lentele = '';
	private $automobiliai_lentele = '';
	private $instruktoriai_lentele = '';
	private $sutartys_lentele = '';
	private $uzsiemimai_lentele = '';

	public function __construct() {
		$this->filialai_lentele = 'FILIALAI';
		$this->automobiliai_lentele = 'AUTOMOBILIAI';
		$this->instruktoriai_lentele = 'INSTRUKTORIAI';
		$this->sutartys_lentele = 'SUTARTYS';
		$this->uzsiemimai_lentele = 'UZSIEMIMAI';
	}

	public function getBranch($id) {
		$query = "  SELECT *
					FROM {$this->filialai_lentele}
					WHERE `id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}

	public function getCar($carId) {
		$query = "  SELECT *
					FROM {$this->automobiliai_lentele}
					WHERE `valstybinis_nr`='{$carId}'";
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

	public function getCars($branchId) {
		$query = "  SELECT *
					FROM `{$this->automobiliai_lentele}`
					WHERE `fk_FILIALAS_id`='{$branchId}'";
		$data = mysql::select($query);

		foreach ($data as $key => $val) {
		    $data[$key]['inserted'] = '1';
        }

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

		return mysql::getLastInsertedId();
	}

	public function updateBranch($data) {
		$query = "  UPDATE {$this->filialai_lentele}
					SET    `adresas`='{$data['adresas']}',
					       `kontaktinis_tel`='{$data['kontaktinis_tel']}'
					WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}

	public function updateCars($data, $branchId = null) {
	    if ($branchId != null) {
	        $data['id'] = $branchId;
        }

	    if (!isset($data['valstybiniai_nr']) || sizeof($data['valstybiniai_nr']) == 0
            || !isset($data['metai']) || sizeof($data['metai']) != sizeof($data['valstybiniai_nr'])
            || !isset($data['ridos']) || sizeof($data['ridos']) != sizeof($data['valstybiniai_nr'])
            || !isset($data['isigijimo_datos']) || sizeof($data['isigijimo_datos']) != sizeof($data['valstybiniai_nr'])
            || !isset($data['pavaru_dezes']) || sizeof($data['pavaru_dezes']) != sizeof($data['valstybiniai_nr'])
            || !isset($data['markes']) || sizeof($data['markes']) != sizeof($data['valstybiniai_nr'])) {
	        return;
        }

	    foreach($data['valstybiniai_nr'] as $key => $val) {
            $query = "  INSERT INTO {$this->automobiliai_lentele}
                                    (
                                        `valstybinis_nr`,
                                        `metai`,
                                        `rida`,
                                        `isigijimo_data`,
                                        `pavaru_deze`,
                                        `fk_FILIALAS_id`,
                                        `fk_MARKE_id`
                                    )
                                    VALUES
                                    (
                                        '{$val}',
                                        '{$data['metai'][$key]}',
                                        '{$data['ridos'][$key]}',
                                        '{$data['isigijimo_datos'][$key]}',
                                        '{$data['pavaru_dezes'][$key]}',
                                        '{$data['id']}',
                                        '{$data['markes'][$key]}'
                                    )
                          ON DUPLICATE KEY UPDATE `metai`='{$data['metai'][$key]}',
                                                  `rida`='{$data['ridos'][$key]}',
                                                  `isigijimo_data`='{$data['isigijimo_datos'][$key]}',
                                                  `pavaru_deze`='{$data['pavaru_dezes'][$key]}',
                                                  `fk_MARKE_id`='{$data['markes'][$key]}'";
            mysql::query($query);
        }
	}

	public function deleteBranch($id) {
		$query = "  DELETE FROM {$this->filialai_lentele}
					WHERE `id`='{$id}'";
		mysql::query($query);
	}

	public function deleteCar($carId) {
		$query = "  DELETE FROM {$this->automobiliai_lentele}
					WHERE `valstybinis_nr`='{$carId}'";
		mysql::query($query);
	}

	public function deleteLessons($carId) {
		$query = "  DELETE FROM {$this->uzsiemimai_lentele}
					WHERE `fk_AUTOMOBILIS_valstybinis_nr`='{$carId}'";
		mysql::query($query);
	}

	public function getLessonCountOfCar($carId) {
		$query = "  SELECT COUNT({$this->uzsiemimai_lentele}.`id`) AS `kiekis`
					FROM {$this->automobiliai_lentele}
						INNER JOIN {$this->uzsiemimai_lentele}
							ON {$this->automobiliai_lentele}.`valstybinis_nr`={$this->uzsiemimai_lentele}.`fk_AUTOMOBILIS_valstybinis_nr`
					WHERE {$this->automobiliai_lentele}.`valstybinis_nr`='{$carId}'";
		$data = mysql::select($query);

		return $data[0]['kiekis'];
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