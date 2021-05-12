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
        FROM SUTARTYS s
        INNER JOIN MOKSLEIVIAI m ON m.id = s.fk_MOKSLEIVIS_id
        INNER JOIN (
            SELECT
                fk_MOKSLEIVIS_id,
                COUNT(id) AS sutarciu_kiekis,
                SUM(IF(pasirasymo_data IS NOT NULL AND busena != 1, suma, 0)) AS kainu_suma
            FROM SUTARTYS
            GROUP BY fk_MOKSLEIVIS_id
        ) sg ON sg.fk_MOKSLEIVIS_id = s.fk_MOKSLEIVIS_id
        INNER JOIN sutarties_tipai st ON st.id_sutarties_tipai = s.tipas
        INNER JOIN sutarties_busenos sb ON sb.id_sutarties_busenos = s.busena
        LEFT JOIN (
            SELECT
                fk_MOKSLEIVIS_id,
                i.vardas AS instruktoriaus_vardas,
                i.pavarde AS instruktoriaus_pavarde
            FROM UZSIEMIMAI u
            INNER JOIN (
                SELECT MAX(id) AS max_id
                FROM UZSIEMIMAI
                GROUP BY fk_MOKSLEIVIS_id
            ) uu ON uu.max_id = u.id
            INNER JOIN INSTRUKTORIAI i ON i.id = u.fk_INSTRUKTORIUS_id
        ) ug ON ug.fk_MOKSLEIVIS_id = s.fk_MOKSLEIVIS_id
        LEFT JOIN (
            SELECT
                fk_MOKSLEIVIS_id,
                ROUND(AVG(ivertinimas), 1) AS ivertinimu_vidurkis
            FROM ATSILIEPIMAI
            GROUP BY fk_MOKSLEIVIS_id
        ) ag ON ag.fk_MOKSLEIVIS_id = s.fk_MOKSLEIVIS_id
    )
    UNION ALL
    (
        SELECT
            NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL,
            (SELECT ROUND(AVG(ivertinimas), 1) FROM ATSILIEPIMAI) AS ivertinimu_vidurkis,
            COUNT(id) AS sutarciu_kiekis,
            SUM(IF(pasirasymo_data IS NOT NULL AND busena != 1, suma, 0)) AS kainu_suma
        FROM SUTARTYS
    )
) a ORDER BY moksleivio_id, sutarties_id ASC