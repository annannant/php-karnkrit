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




-- ==========

SELECT section.section_name, specimen.specimen_name ,count(order_test.lab_order_ln) as "total_order"
FROM 
  order_test 
  JOIN lab_test on order_test.lab_test_test_id = lab_test.test_id
  JOIN specimen on lab_test.specimen_id = specimen.specimen_id
  JOIN section on lab_test.section_id = section.section_id  
WHERE 
  order_test.requested_date BETWEEN '2024-06-24 00:00:00' 
  AND '2024-06-27 23:59:59' 
GROUP by 
  section.section_name,
  specimen.specimen_name
ORDER BY 
  section.section_name,
  total_order DESC;
==

==

SELECT 
  lab_order.ln, 
  patient.pid, 
  patient.first_name, 
  patient.last_name, 
  lab_test.test_name, 
  order_test.lab_test_result, 
  order_test.requested_date, 
  order_test.completed_date 
FROM 
  patient 
  JOIN lab_order ON patient.pid = lab_order.pid 
  JOIN order_test ON lab_order.ln = order_test.lab_order_ln 
  JOIN lab_test ON order_test.lab_test_test_id = lab_test.test_id 
WHERE 
  patient.pid IN (
    SELECT 
      pid 
    FROM 
      (
        SELECT 
          lab_order.pid, 
          COUNT(*) AS positive_count 
        FROM 
          lab_order 
          JOIN order_test ON lab_order.ln = order_test.lab_order_ln 
        WHERE 
          order_test.requested_date BETWEEN '2024-06-29 00:00:00' 
          AND '2024-06-29 23:59:59' 
          AND order_test.lab_test_result IN ('Positive', 'POS', 'Pos') 
        GROUP BY 
          lab_order.pid 
        HAVING 
          positive_count > 0
      ) AS total_count
  ) 
ORDER BY 
  patient.last_name, 
  patient.first_name, 
  lab_test.test_name;

===

-- Example: Find order which have no result
SELECT 
    order_test.lab_order_ln, 
    order_test.lab_test_name, 
    order_test.lab_test_result,
    section.section_name,
    (SELECT TIMESTAMPDIFF(HOUR, order_test.requested_date, NOW())) AS hours_since_requested,
    (SELECT MOD(TIMESTAMPDIFF(MINUTE, order_test.requested_date, NOW()), 60)) AS minutes_since_requested,
    order_test.requested_date,
    order_test.completed_date
FROM 
    order_test JOIN lab_test on order_test.lab_test_test_id = lab_test.test_id
    JOIN section on section.section_id = lab_test.section_id
WHERE 
    order_test.completed_date IS NULL
ORDER BY hours_since_requested DESC,
		    minutes_since_requested DESC,
        order_test.lab_order_ln,
        section.section_name;

====
