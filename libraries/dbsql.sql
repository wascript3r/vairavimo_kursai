SELECT
  *
FROM
  (
    (
      SELECT
        s.id AS sutarties_id,
        s.fk_MOKSLEIVIS_id AS moksleivio_id,
        m.vardas,
        m.pavarde,
        DATE(s.sudarymo_data) AS sudarymo_data,
        IFNULL(
          s.pasirasymo_data, "nepasirašyta"
        ) AS pasirasymo_data,
        sutarciu_kiekis,
        kainu_suma
      FROM
        SUTARTYS s
        INNER JOIN MOKSLEIVIAI m ON m.id = s.fk_MOKSLEIVIS_id
        INNER JOIN (
          SELECT
            fk_MOKSLEIVIS_id,
            COUNT(id) AS sutarciu_kiekis,
            SUM(
              IF(
                pasirasymo_data IS NOT NULL
                AND busena != 1,
                suma,
                0
              )
            ) AS kainu_suma
          FROM
            SUTARTYS
          GROUP BY
            fk_MOKSLEIVIS_id
        ) sg ON sg.fk_MOKSLEIVIS_id = s.fk_MOKSLEIVIS_id
    )
    UNION ALL
      (
        SELECT
          NULL,
          NULL,
          NULL,
          NULL,
          NULL,
          NULL,
          COUNT(id) AS bendras_sutarciu_kiekis,
          SUM(
            IF(
              pasirasymo_data IS NOT NULL
              AND busena != 1,
              suma,
              0
            )
          ) AS bendra_kainu_suma
        FROM
          SUTARTYS
      )
  ) a
ORDER BY
  moksleivio_id ASC
