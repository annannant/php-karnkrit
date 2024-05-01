<?php
include ('../config/db.php');

$isEdit = isset($_POST['isEdit']) && $_POST['isEdit'] === 'true';
$isCreate = !$isEdit;

$pid = "";
$vn = "";
$ln = "";

// START : FOR CREATE LAB ORDER
if ($isCreate === true) {
  $ln = 0;
  $pid = $_POST['pid'];
  $vn = $_POST['vn'];
  // ------> START : CREATE LAB ORDER
  $sql = "INSERT INTO lab_order VALUES (NULL, '" . $pid . "', " . $vn . ", NOW());";
  if ($conn->query($sql)) {
    $ln = $conn->insert_id;
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit();
  }
  // ------> END : CREATE LAB ORDER
}
// END : FOR CREATE LAB ORDER
// ---------------------------------------------

// START : FOR EDIT LAB ORDER
if ($isEdit === true) {
  $ln = $_POST['ln'];
  if (isset($_POST['pid']) && isset($_POST['vn'])) {
    $pid = $_POST['pid'];
    $vn = $_POST['vn'];
    $sql = "UPDATE lab_order SET
    pid = '" . $pid . "',
    vn = '" . $vn . "'
    WHERE ln = '" . $_POST['ln'] . "';
    ";
    if ($conn->query($sql)) {
      echo "Record updated successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      exit();
    }
  }
}
// END : FOR CREATE LAB ORDER
// ---------------------------------------------



// START : FOR UPDATE ORDER TESTS
if ($isEdit === true && isset($_POST['updateTestId'])) {
  $testIDs = $_POST['updateTestId'];
  $results = isset($_POST['updateResult']) ? $_POST['updateResult'] : [];
  $comps = isset($_POST['updateCompleted']) ? $_POST['updateCompleted'] : [];
  foreach ($testIDs as $key => $value) {
    $testID = $value;
    $result = isset($results[$key]) ? $results[$key] : null;
    $completed = isset($comps[$key]) && $comps[$key] === 'checked' ? 'NOW()' : null;
    $update = [];
    if ($result !== null) {
      $update[] = "lab_test_result = '" . $result . "' ";
    }

    if ($completed !== null) {
      $update[] = "completed_date = NOW() ";
    }

    if (empty($update)) {
      continue;
    }

    $sql = "UPDATE order_test SET
      " . implode(", ", $update) . "
      WHERE lab_order_ln = '" . $_POST['ln'] . "' AND lab_test_test_id = '" . $testID . "';
    ";

    if ($conn->query($sql)) {
      echo "New order test updated successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      exit();
    }
  }
}
// END : FOR UPDATE ORDER TESTS
// ---------------------------------------------
if (isset($_POST['newTest'])) {
  $testIDs = $_POST['newTest'];
  $testNames = $_POST['newTestName'];
  $results = $_POST['newResult'];
  foreach ($testIDs as $key => $value) {
    $newTestID = $value;
    $testName = $testNames[$key];
    $result = $results[$key];
    $sql = "INSERT INTO order_test VALUES ('" . $ln . "', '" . $newTestID . "', '" . $testName . "', '" . $result . "', NOW(), NULL);";
    if ($conn->query($sql)) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      exit();
    }
  }
}
// START : FOR CREATE ORDER TESTS
// END : FOR CREATE ORDER TESTS
// ---------------------------------------------




$conn->close();
?>
<?php if ($isEdit) { ?>
  <script type="text/javascript">
    window.location = "/lab-orders.php";
  </script>
<?php } else { ?>
  <script type="text/javascript">
    window.location = "/lab-orders.php";
  </script>
<?php } ?>


<!-- <script type="text/javascript">
  window.location = "<?php echo ($isEdit) ? '/lab-orders.php' : "/lab-orders-info-test.php?ln=" . $_POST['ln'] . "" ?>";
</script> -->