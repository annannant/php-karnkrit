<?php

include ('../config/db.php');

$search = $_GET['pid'];
$visits = [];
$sql = $sql = "SELECT * FROM visit WHERE pid = '".$search."' ORDER BY visit_date DESC;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while ($data = $result->fetch_object()) {
    $visits[] = $data;
  }
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($visits);
