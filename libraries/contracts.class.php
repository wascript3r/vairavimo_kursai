<?php

class contracts {

	private $sutartys_lentele = '';
	private $filialai_lentele = '';
	private $moksleiviai_lentele = '';
	private $pavaru_dezes_lentele = '';
	private $sutarties_tipai_lentele = '';
	private $sutarties_busenos_lentele = '';

	public function __construct() {
		$this->sutartys_lentele = 'SUTARTYS';
		$this->filialai_lentele = 'FILIALAI';
		$this->moksleiviai_lentele = 'MOKSLEIVIAI';
		$this->pavaru_dezes_lentele = 'pavaru_dezes';
		$this->sutarties_tipai_lentele = 'sutarties_tipai';
		$this->sutarties_busenos_lentele = 'sutarties_busenos';
	}

	public function getContract($id) {
		$query = "  SELECT *
					FROM {$this->sutartys_lentele}
					WHERE `id`='{$id}'";
		$data = mysql::select($query);

		return $data[0];
	}

	public function getContractList($limit = null, $offset = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";

			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}
		}

		$query = "  SELECT  `{$this->sutartys_lentele}`.`id`,
                            `{$this->moksleiviai_lentele}`.`vardas` AS `moksleivio_vardas`,
						   `{$this->moksleiviai_lentele}`.`pavarde` AS `moksleivio_pavarde`,
						   `{$this->sutarties_tipai_lentele}`.`name` AS `sutarties_tipas`,
						   `{$this->sutarties_busenos_lentele}`.`name` AS `sutarties_busena`,
						   `{$this->pavaru_dezes_lentele}`.`name` AS `pavaru_deze`,
						   `{$this->sutartys_lentele}`.`suma`
					FROM {$this->sutartys_lentele}
					    LEFT JOIN `{$this->moksleiviai_lentele}`
							ON `{$this->sutartys_lentele}`.`fk_MOKSLEIVIS_id`=`{$this->moksleiviai_lentele}`.`id`
						LEFT JOIN `{$this->sutarties_tipai_lentele}`
							ON `{$this->sutartys_lentele}`.`tipas`=`{$this->sutarties_tipai_lentele}`.`id_sutarties_tipai`
						LEFT JOIN `{$this->sutarties_busenos_lentele}`
							ON `{$this->sutartys_lentele}`.`busena`=`{$this->sutarties_busenos_lentele}`.`id_sutarties_busenos`
		                LEFT JOIN `{$this->pavaru_dezes_lentele}`
							ON `{$this->sutartys_lentele}`.`automobilio_pavaru_deze`=`{$this->pavaru_dezes_lentele}`.`id_pavaru_dezes`{$limitOffsetString}";
		$data = mysql::select($query);

		return $data;
	}

	public function getContractListCount() {
		$query = "  SELECT COUNT(`id`) as `kiekis`
					FROM {$this->sutartys_lentele}";
		$data = mysql::select($query);

		return $data[0]['kiekis'];
	}

	public function insertContract($data) {
		$query = "  INSERT INTO {$this->sutartys_lentele}
								(
									`sudarymo_data`,
									`pasirasymo_data`,
									`suma`,
									`tipas`,
									`busena`,
									`automobilio_pavaru_deze`,
									`fk_FILIALAS_id`,
									`fk_MOKSLEIVIS_id`
								)
								VALUES
								(
									'{$data['sudarymo_data']}',
									" . ($data['pasirasymo_data'] == '' ? "NULL" : "'{$data['pasirasymo_data']}'") . ",
									'{$data['suma']}',
									'{$data['tipas']}',
									'{$data['busena']}',
									" . ($data['automobilio_pavaru_deze'] == '' ? "NULL" : "'{$data['automobilio_pavaru_deze']}'") . ",
									'{$data['fk_FILIALAS_id']}',
									'{$data['fk_MOKSLEIVIS_id']}'
								)";
		mysql::query($query);
	}

	public function updateContract($data) {
		$query = "  UPDATE {$this->sutartys_lentele}
					SET    `sudarymo_data`='{$data['sudarymo_data']}',
					       `pasirasymo_data`=" . ($data['pasirasymo_data'] == '' ? "NULL" : "'{$data['pasirasymo_data']}'") . ",
					       `suma`='{$data['suma']}',
					       `tipas`='{$data['tipas']}',
					       `busena`='{$data['busena']}',
					       `automobilio_pavaru_deze`=" . ($data['automobilio_pavaru_deze'] == '' ? "NULL" : "'{$data['automobilio_pavaru_deze']}'") . ",
					       `fk_FILIALAS_id`='{$data['fk_FILIALAS_id']}',
					       `fk_MOKSLEIVIS_id`='{$data['fk_MOKSLEIVIS_id']}'
					WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}

	public function deleteContract($id) {
		$query = "  DELETE FROM {$this->sutartys_lentele}
					WHERE `id`='{$id}'";
		mysql::query($query);
	}
}