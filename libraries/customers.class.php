<?php
/**
 * Klientų redagavimo klasė
 *
 * @author ISK
 */

class customers {
	
	private $klientai_lentele = '';
	private $sutartys_lentele = '';
	
	public function __construct() {
		$this->klientai_lentele = config::DB_PREFIX . 'klientai';
		$this->sutartys_lentele = config::DB_PREFIX . 'sutartys';
	}
	
	/**
	 * Kliento išrinkimas
	 * @param type $id
	 * @return type
	 */
	public function getCustomer($id) {
		$query = "  SELECT *
					FROM `{$this->klientai_lentele}`
					WHERE `asmens_kodas`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0];
	}
	
	/**
	 * Klientų sąrašo išrinkimas
	 * @param type $limit
	 * @param type $offset
	 * @return type
	 */
	public function getCustomersList($limit = null, $offset = null) {
		$limitOffsetString = "";
		if(isset($limit)) {
			$limitOffsetString .= " LIMIT {$limit}";
		}
		if(isset($offset)) {
			$limitOffsetString .= " OFFSET {$offset}";
		}
		
		$query = "  SELECT *
					FROM `{$this->klientai_lentele}`" . $limitOffsetString;
		$data = mysql::select($query);
		
		return $data;
	}
	
	/**
	 * Klientų kiekio radimas
	 * @return type
	 */
	public function getCustomersListCount() {
		$query = "  SELECT COUNT(`asmens_kodas`) as `kiekis`
					FROM `{$this->klientai_lentele}`";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	
	/**
	 * Kliento šalinimas
	 * @param type $id
	 */
	public function deleteCustomer($id) {
		$query = "  DELETE FROM `{$this->klientai_lentele}`
					WHERE `asmens_kodas`='{$id}'";
		mysql::query($query);
	}
	
	/**
	 * Kliento atnaujinimas
	 * @param type $data
	 */
	public function updateCustomer($data) {
		$query = "  UPDATE `{$this->klientai_lentele}`
					SET    `vardas`='{$data['vardas']}',
						   `pavarde`='{$data['pavarde']}',
						   `gimimo_data`='{$data['gimimo_data']}',
						   `telefonas`='{$data['telefonas']}',
						   `epastas`='{$data['epastas']}'
					WHERE `asmens_kodas`='{$data['asmens_kodas']}'";
		mysql::query($query);
	}
	
	/**
	 * Kliento įrašymas
	 * @param type $data
	 */
	public function insertCustomer($data) {
		$query = "  INSERT INTO `{$this->klientai_lentele}`
								(
									`asmens_kodas`,
									`vardas`,
									`pavarde`,
									`gimimo_data`,
									`telefonas`,
									`epastas`
								) 
								VALUES
								(
									'{$data['asmens_kodas']}',
									'{$data['vardas']}',
									'{$data['pavarde']}',
									'{$data['gimimo_data']}',
									'{$data['telefonas']}',
									'{$data['epastas']}'
								)";
		mysql::query($query);
	}
	
	/**
	 * Sutarčių, į kurias įtrauktas klientas, kiekio radimas
	 * @param type $id
	 * @return type
	 */
	public function getContractCountOfCustomer($id) {
		$query = "  SELECT COUNT(`{$this->sutartys_lentele}`.`nr`) AS `kiekis`
					FROM `{$this->klientai_lentele}`
						INNER JOIN `{$this->sutartys_lentele}`
							ON `{$this->klientai_lentele}`.`asmens_kodas`=`{$this->sutartys_lentele}`.`fk_klientas`
					WHERE `{$this->klientai_lentele}`.`asmens_kodas`='{$id}'";
		$data = mysql::select($query);
		
		return $data[0]['kiekis'];
	}
	
}