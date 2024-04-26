<?php

include ('../config/db.php');

$tests = [];

$sql = 'SELECT lab_test.*, section.section_name, specimen.specimen_name FROM lab_test 
INNER JOIN section ON section.section_id = lab_test.section_id 
INNER JOIN specimen ON specimen.specimen_id = lab_test.specimen_id 
ORDER BY test_id;';

$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while ($data = $result->fetch_object()) {
    $tests[] = $data;
  }
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($tests);
