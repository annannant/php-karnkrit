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

SELECT 
  order_test.lab_test_name as "Test name", 
  patient_rights.patient_rights_desc as "Patient rights", 
  count(order_test.lab_test_name) as "Total used" 
from 
  order_test 
  join lab_order on order_test.lab_order_ln = lab_order.ln 
  join visit on lab_order.vn = visit.vn 
  join patient_rights on visit.patient_rights_ID = patient_rights.patient_rights_ID 
where 
  order_test.requested_date BETWEEN '2024-06-01 00:00:00' 
  AND '2024-06-27 23:59:59' 
GROUP by 
  order_test.lab_test_name, 
  patient_rights.patient_rights_desc;
