<?php

class instructors {
	
	private $instruktoriai_lentele = '';
	private $filialai_lentele = '';
	private $atsiliepimai_lentele = '';
	private $uzsiemimai_lentele = '';
	private $moksleiviai_lentele = '';

	public function __construct() {
		$this->instruktoriai_lentele = 'INSTRUKTORIAI';
		$this->filialai_lentele = 'FILIALAI';
		$this->atsiliepimai_lentele = 'ATSILIEPIMAI';
		$this->uzsiemimai_lentele = 'UZSIEMIMAI';
		$this->moksleiviai_lentele = 'MOKSLEIVIAI';
	}

	public function getInstructor($id) {
		$query = "  SELECT *
					FROM {$this->instruktoriai_lentele}
					WHERE `id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}

	public function getInstructorList($limit = null, $offset = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}
		
		$query = "  SELECT `{$this->instruktoriai_lentele}`.`id`,
						   `{$this->instruktoriai_lentele}`.`vardas`,
						   `{$this->instruktoriai_lentele}`.`pavarde`,
						   `{$this->instruktoriai_lentele}`.`el_pastas`,
						   `{$this->instruktoriai_lentele}`.`tel_nr`,
						   `{$this->instruktoriai_lentele}`.`adresas`,
						   `{$this->instruktoriai_lentele}`.`aprasymas`,
						   `{$this->instruktoriai_lentele}`.`darbo_pradzios_data`,
						   `{$this->instruktoriai_lentele}`.`vairavimo_stazas`,
						   `{$this->filialai_lentele}`.`adresas` AS `filialo_adresas`
					FROM {$this->instruktoriai_lentele}
					    LEFT JOIN `{$this->filialai_lentele}`
							ON `{$this->instruktoriai_lentele}`.`fk_FILIALAS_id`=`{$this->filialai_lentele}`.`id`{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}

	public function getReviews($instructorId) {
		$query = "  SELECT *
					FROM `{$this->atsiliepimai_lentele}`
					WHERE `fk_INSTRUKTORIUS_id`='{$instructorId}'";
		$data = mysql::select($query);

		return $data;
	}

	public function getInstructorListCount() {
		$query = "  SELECT COUNT(`id`) as `kiekis`
					FROM {$this->instruktoriai_lentele}";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}

	public function insertInstructor($data) {
		$query = "  INSERT INTO {$this->instruktoriai_lentele}
								(
									`vardas`,
									`pavarde`,
									`el_pastas`,
									`tel_nr`,
									`adresas`,
									`aprasymas`,
									`darbo_pradzios_data`,
									`vairavimo_stazas`,
									`fk_FILIALAS_id`
								)
								VALUES
								(
									'{$data['vardas']}',
									'{$data['pavarde']}',
									'{$data['el_pastas']}',
									'{$data['tel_nr']}',
									'{$data['adresas']}',
									'{$data['aprasymas']}',
									'{$data['darbo_pradzios_data']}',
									'{$data['vairavimo_stazas']}',
									'{$data['fk_FILIALAS_id']}'
								)";
		mysql::query($query);

		return mysql::getLastInsertedId();
	}

	public function updateInstructor($data) {
		$query = "  UPDATE {$this->instruktoriai_lentele}
					SET    `vardas`='{$data['vardas']}',
					       `pavarde`='{$data['pavarde']}',
					       `el_pastas`='{$data['el_pastas']}',
					       `tel_nr`='{$data['tel_nr']}',
					       `adresas`='{$data['adresas']}',
					       `aprasymas`='{$data['aprasymas']}',
					       `darbo_pradzios_data`='{$data['darbo_pradzios_data']}',
					       `vairavimo_stazas`='{$data['vairavimo_stazas']}',
					       `fk_FILIALAS_id`='{$data['fk_FILIALAS_id']}'
					WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}

	public function updateReviews($data, $instructorId = null) {
	    if ($instructorId != null) {
	        $data['id'] = $instructorId;
        }

	    if (!isset($data['ids']) || sizeof($data['ids']) == 0
            || !isset($data['moksleiviai']) || sizeof($data['moksleiviai']) != sizeof($data['ids'])
            || !isset($data['ivertinimai']) || sizeof($data['ivertinimai']) != sizeof($data['ids'])
            || !isset($data['komentarai']) || sizeof($data['komentarai']) != sizeof($data['ids'])
            || !isset($data['datos']) || sizeof($data['datos']) != sizeof($data['ids'])) {
	        return;
        }

	    foreach($data['ids'] as $key => $val) {
            $query = "  INSERT INTO {$this->atsiliepimai_lentele}
                                    (
                                        `id`,
                                        `ivertinimas`,
                                        `komentaras`,
                                        `data`,
                                        `fk_INSTRUKTORIUS_id`,
                                        `fk_MOKSLEIVIS_id`
                                    )
                                    VALUES
                                    (
                                        " . ($val != '0' ? "'{$val}'" : 'null') . ",
                                        '{$data['ivertinimai'][$key]}',
                                        '{$data['komentarai'][$key]}',
                                        '{$data['datos'][$key]}',
                                        '{$data['id']}',
                                        '{$data['moksleiviai'][$key]}'
                                    )
                        ON DUPLICATE KEY UPDATE `ivertinimas`='{$data['ivertinimai'][$key]}',
                                                  `komentaras`='{$data['komentarai'][$key]}',
                                                  `data`='{$data['datos'][$key]}',
                                                  `fk_MOKSLEIVIS_id`='{$data['moksleiviai'][$key]}'";
            mysql::query($query);
        }
	}

	public function deleteInstructor($id) {
		$query = "  DELETE FROM {$this->instruktoriai_lentele}
					WHERE `id`='{$id}'";
		mysql::query($query);
	}

	public function deleteReview($reviewId) {
		$query = "  DELETE FROM {$this->atsiliepimai_lentele}
					WHERE `id`='{$reviewId}'";
		mysql::query($query);
	}

	public function deleteReviews($instructorId) {
		$query = "  DELETE FROM {$this->atsiliepimai_lentele}
					WHERE `fk_INSTRUKTORIUS_id`='{$instructorId}'";
		mysql::query($query);
	}

	public function deleteLessons($instructorId) {
		$query = "  DELETE FROM {$this->uzsiemimai_lentele}
					WHERE `fk_INSTRUKTORIUS_id`='{$instructorId}'";
		mysql::query($query);
	}
}