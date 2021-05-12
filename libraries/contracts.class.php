<?php

class contracts {

	private $sutartys_lentele = '';
	private $filialai_lentele = '';
	private $moksleiviai_lentele = '';
	private $pavaru_dezes_lentele = '';
	private $sutarties_tipai_lentele = '';
	private $sutarties_busenos_lentele = '';
	private $instruktoriai_lentele = '';
	private $uzsiemimai_lentele = '';
	private $atsiliepimai_lentele = '';

	public function __construct() {
		$this->sutartys_lentele = 'SUTARTYS';
		$this->filialai_lentele = 'FILIALAI';
		$this->moksleiviai_lentele = 'MOKSLEIVIAI';
		$this->pavaru_dezes_lentele = 'pavaru_dezes';
		$this->sutarties_tipai_lentele = 'sutarties_tipai';
		$this->sutarties_busenos_lentele = 'sutarties_busenos';
		$this->instruktoriai_lentele = 'INSTRUKTORIAI';
		$this->uzsiemimai_lentele = 'UZSIEMIMAI';
		$this->atsiliepimai_lentele = 'ATSILIEPIMAI';
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

	public function getStudentContracts($dateFrom, $dateTo) {
        $query = "
            SELECT * FROM (
                (
                    SELECT
                        s.id AS sutarties_id,
                        s.fk_MOKSLEIVIS_id AS moksleivio_id,
                        CONCAT(m.vardas, ' ', m.pavarde) AS moksleivis,
                        DATE(s.sudarymo_data) AS sudarymo_data,
                        IFNULL(DATE(s.pasirasymo_data), 'nepasirašyta') AS pasirasymo_data,
                        s.suma,
                        st.name AS tipas,
                        sb.name AS busena,
                        IF(
                            instruktoriaus_vardas IS NOT NULL AND instruktoriaus_pavarde IS NOT NULL,
                            CONCAT(instruktoriaus_vardas, ' ', instruktoriaus_pavarde),
                            'dar nepasirinktas'
                        ) AS instruktorius,
                        IFNULL(ivertinimu_vidurkis, 'nėra duomenų') AS ivertinimu_vidurkis,
                        sutarciu_kiekis,
                        kainu_suma
                    FROM {$this->sutartys_lentele} s
                    INNER JOIN {$this->moksleiviai_lentele} m ON m.id = s.fk_MOKSLEIVIS_id
                    INNER JOIN (
                        SELECT
                            fk_MOKSLEIVIS_id,
                            COUNT(id) AS sutarciu_kiekis,
                            SUM(IF(pasirasymo_data IS NOT NULL AND busena != 1, suma, 0)) AS kainu_suma
                        FROM {$this->sutartys_lentele}
                        GROUP BY fk_MOKSLEIVIS_id
                    ) sg ON sg.fk_MOKSLEIVIS_id = s.fk_MOKSLEIVIS_id
                    INNER JOIN {$this->sutarties_tipai_lentele} st ON st.id_sutarties_tipai = s.tipas
                    INNER JOIN {$this->sutarties_busenos_lentele} sb ON sb.id_sutarties_busenos = s.busena
                    LEFT JOIN (
                        SELECT
                            fk_MOKSLEIVIS_id,
                            i.vardas AS instruktoriaus_vardas,
                            i.pavarde AS instruktoriaus_pavarde
                        FROM {$this->uzsiemimai_lentele} u
                        INNER JOIN (
                            SELECT MAX(id) AS max_id
                            FROM {$this->uzsiemimai_lentele}
                            GROUP BY fk_MOKSLEIVIS_id
                        ) uu ON uu.max_id = u.id
                        INNER JOIN {$this->instruktoriai_lentele} i ON i.id = u.fk_INSTRUKTORIUS_id
                    ) ug ON ug.fk_MOKSLEIVIS_id = s.fk_MOKSLEIVIS_id
                    LEFT JOIN (
                        SELECT
                            fk_MOKSLEIVIS_id,
                            ROUND(AVG(ivertinimas), 1) AS ivertinimu_vidurkis
                        FROM {$this->atsiliepimai_lentele}
                        GROUP BY fk_MOKSLEIVIS_id
                    ) ag ON ag.fk_MOKSLEIVIS_id = s.fk_MOKSLEIVIS_id
                )
                UNION ALL
                (
                    SELECT
                        NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL,
                        (SELECT ROUND(AVG(ivertinimas), 1) FROM {$this->atsiliepimai_lentele}) AS ivertinimu_vidurkis,
                        COUNT(id) AS sutarciu_kiekis,
                        SUM(IF(pasirasymo_data IS NOT NULL AND busena != 1, suma, 0)) AS kainu_suma
                    FROM {$this->sutartys_lentele}
                )
            ) a ORDER BY moksleivio_id, sutarties_id ASC
        ";
        $data = mysql::select($query);

		return $data;
    }
}