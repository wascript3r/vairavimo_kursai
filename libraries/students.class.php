<?php

class students {
	
	private $moksleiviai_lentele = '';
	private $atsiliepimai_lentele = '';
	private $uzsiemimai_lentele = '';
	private $sutartys_lentele = '';

	public function __construct() {
		$this->moksleiviai_lentele = 'MOKSLEIVIAI';
		$this->atsiliepimai_lentele = 'ATSILIEPIMAI';
		$this->uzsiemimai_lentele = 'UZSIEMIMAI';
		$this->sutartys_lentele = 'SUTARTYS';
	}

	public function getStudent($id) {
		$query = "  SELECT *
					FROM {$this->moksleiviai_lentele}
					WHERE `id`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}

	public function getStudentList($limit = null, $offset = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
			
			if(isset($offset)) {
				$limitOffsetString .= " OFFSET {$offset}";
			}	
		}
		
		$query = "  SELECT *
					FROM {$this->moksleiviai_lentele}{$limitOffsetString}";
		$data = mysql::select($query);
		
		return $data;
	}

	public function getStudentListCount() {
		$query = "  SELECT COUNT(`id`) as `kiekis`
					FROM {$this->moksleiviai_lentele}";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}

	public function insertStudent($data) {
		$query = "  INSERT INTO {$this->moksleiviai_lentele}
								(
									`vardas`,
									`pavarde`,
									`el_pastas`,
									`tel_nr`,
									`adresas`
								)
								VALUES
								(
									'{$data['vardas']}',
									'{$data['pavarde']}',
									'{$data['el_pastas']}',
									'{$data['tel_nr']}',
									'{$data['adresas']}'
								)";
		mysql::query($query);
	}

	public function updateStudent($data) {
		$query = "  UPDATE {$this->moksleiviai_lentele}
					SET    `vardas`='{$data['vardas']}',
					       `pavarde`='{$data['pavarde']}',
					       `el_pastas`='{$data['el_pastas']}',
					       `tel_nr`='{$data['tel_nr']}',
					       `adresas`='{$data['adresas']}'
					WHERE `id`='{$data['id']}'";
		mysql::query($query);
	}

	public function deleteStudent($id) {
		$query = "  DELETE FROM {$this->moksleiviai_lentele}
					WHERE `id`='{$id}'";
		mysql::query($query);
	}

	public function deleteReviews($studentId) {
		$query = "  DELETE FROM {$this->atsiliepimai_lentele}
					WHERE `fk_MOKSLEIVIS_id`='{$studentId}'";
		mysql::query($query);
	}

	public function deleteLessons($studentId) {
		$query = "  DELETE FROM {$this->uzsiemimai_lentele}
					WHERE `fk_MOKSLEIVIS_id`='{$studentId}'";
		mysql::query($query);
	}

	public function deleteContracts($studentId) {
		$query = "  DELETE FROM {$this->sutartys_lentele}
					WHERE `fk_MOKSLEIVIS_id`='{$studentId}'";
		mysql::query($query);
	}
}