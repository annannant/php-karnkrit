SELECT ot.lab_test_test_id,
       ot.lab_test_name,
       s.specimen_name,
       ct.container_name,
       COUNT(ot.lab_test_test_id) AS test_count
FROM `order_test` AS ot
JOIN lab_test AS t ON t.test_id = ot.lab_test_test_id
JOIN specimen AS s ON t.specimen_id = s.specimen_id
JOIN container AS ct ON s.container_id = ct.container_id
WHERE ot.requested_date BETWEEN '2024-06-01 00:00:00' AND '2024-06-26 23:59:59'
GROUP BY ot.lab_test_test_id,
         ot.lab_test_name,
         s.specimen_name,
         ct.container_name;