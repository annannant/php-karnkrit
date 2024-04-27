<?php

include ('../config/db.php');

$tests = [];

$sql = "DELETE FROM order_test WHERE order_test.lab_order_ln = ".$_GET['ln']." AND order_test.lab_test_test_id = ".$_GET['testId']."";
$result = $conn->query($sql);
if ($conn->query($sql)) {
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($_GET);
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  exit();
}


