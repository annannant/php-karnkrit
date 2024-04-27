<?php
include ('../config/db.php');

// print_r($_POST);

// echo "<br/>";
// foreach($tests as $key=>$value) {
//   echo $value . "<br/>";
//   echo $testName[$key] . "<br/>";
// }

// echo json_encode($_POST);
// exit();

$last_ln = "";
$isEdit = isset($_POST['isEdit']) && $_POST['isEdit'] === 'true';
if (isset($_POST['pid']) && isset($_POST['vn'])) {
  $pid = $_POST['pid'];
  $vn = $_POST['vn'];
  if ($isEdit) {
    $sql = "UPDATE lab_order SET
    pid = '" . $pid . "',
    vn = '" . $vn . "'
    WHERE ln = '" . $_POST['ln'] . "';
    ";
    $last_ln = $_POST['ln'];
    if ($conn->query($sql)) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      exit();
    }
  } else {
    $sql = "INSERT INTO lab_order VALUES (NULL, '" . $pid . "', " . $vn . ", NOW());";
    if ($conn->query($sql)) {
      $last_ln = $conn->insert_id;
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      exit();
    }
  }
}

if (isset($_POST['updateTestId'])) {
  $updateTestIds = $_POST['updateTestId'];
  $updateResult = isset($_POST['updateResult']) ? $_POST['updateResult'] : [];
  $updateCompleted = isset($_POST['updateCompleted']) ? $_POST['updateCompleted'] : [];
  foreach ($updateTestIds as $key => $value) {
    $updateTestIdID = $value;
    $updateResultValue = isset($updateResult[$key]) ? $updateResult[$key] : null;
    $updateCompletedValue = isset($updateCompleted[$key]) && $updateCompleted[$key] === 'checked' ? 'NOW()' : null;

    $up = [];
    if ($updateResultValue !== null) {
      $up[] = "lab_test_result = '" . $updateResultValue . "' ";
    }

    if ($updateCompletedValue !== null) {
      $up[] = "completed_date = '" . $updateCompletedValue . "' ";
    }

    if (empty($up)) {
      continue;
    }

    $sql = "UPDATE order_test SET
      " . implode(", ", $up) . "
      WHERE lab_order_ln = '" . $_POST['ln'] . "' AND lab_test_test_id = '" . $updateTestIdID . "';
    ";

    if ($conn->query($sql)) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      exit();
    }
  }
}

$last_ln = isset($_POST['ln']) ? $_POST['ln'] : $last_ln;
if (isset($_POST['newTest'])) {
  $newTests = $_POST['newTest'];
  $newTestName = $_POST['newTestName'];
  $newResult = $_POST['newResult'];
  foreach ($newTests as $key => $value) {
    $newTestID = $value;
    $newTestNameValue = $newTestName[$key];
    $newResultValue = $newResult[$key];
    $sql = "INSERT INTO order_test VALUES ('" . $last_ln . "', '" . $newTestID . "', '" . $newTestNameValue . "', '" . $newResultValue . "', NOW(), NULL);";
    if ($conn->query($sql)) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
      exit();
    }
  }
}

$conn->close();
?>
<?php if ($isEdit) { ?>
  <script type="text/javascript">
    window.location = "/lab-orders.php";
  </script>
<?php } else { ?>
  <script type="text/javascript">
    // window.location = "/lab-orders-info-test.php?ln=<?php echo $last_ln ?>";
    window.location = "/lab-orders.php";
  </script>
<?php } ?>


<!-- <script type="text/javascript">
  window.location = "<?php echo ($isEdit) ? '/lab-orders.php' : "/lab-orders-info-test.php?ln=" . $_POST['ln'] . "" ?>";
</script> -->