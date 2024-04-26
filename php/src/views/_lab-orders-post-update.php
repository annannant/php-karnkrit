<?php
include ('../config/db.php');


// print_r($_POST);

// echo "<br/>";
// foreach($tests as $key=>$value) {
//   echo $value . "<br/>";
//   echo $testName[$key] . "<br/>";
// }
// exit();

$last_ln = "";


if (isset($_POST['pid'])) {
  $pid = $_POST['pid'];
  $vn = $_POST['vn'];
  $isEdit = isset($_POST['isEdit']) === 'true';
  $sql = "INSERT INTO lab_order VALUES (NULL, '" . $pid . "', " . $vn . ", NOW());";
  if ($isEdit) {
    $sql = "UPDATE lab_order SET
      pid = '" . $pid . "',
      vn = '" . $vn . "'
      WHERE ln = '" . $_POST['ln'] . "';
      ";
  }
  if ($conn->query($sql)) {
    $last_ln = $conn->insert_id;
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit();
  }


  if (isset($_POST['test'])) {
    $tests = $_POST['test'];
    $testName = $_POST['testName'];
    foreach($tests as $key=>$value) {
      $testID = $value;
      $testNameValue = $testName[$key];
      $sql = "INSERT INTO order_test VALUES ('" . $last_ln . "', '" . $testID . "', '" . $testNameValue . "', NULL, NOW(), NULL);";
      if ($conn->query($sql)) {
        echo "New record created successfully";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
  }
  // exit();
  $conn->close();
}

// print_r($_POST);
// exit();
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