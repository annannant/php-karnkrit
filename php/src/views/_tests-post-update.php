<?php
include ('../config/db.php');

if (isset($_POST['testName'])) {
  $testName = $_POST['testName'];
  $refRange = $_POST['refRange'];
  $status = $_POST['status'];
  $sectionID = $_POST['sectionID'];
  $specimenID = $_POST['specimenID'];
  $isEdit = isset($_POST['testID']) ? true : false;

  $sql = "INSERT INTO lab_test VALUES (NULL, '" . $testName . "', '" . $refRange . "', NOW(), ".$status.", ".$sectionID.", ".$specimenID.");";
  if ($isEdit) {
    $sql = "UPDATE lab_test SET
      test_name = '" . $testName . "',
      ref_range = '" . $refRange . "',
      status = '" . $status . "',
      section_id = '" . $sectionID . "',
      specimen_id = '" . $specimenID . "'
      WHERE test_id = '" . $_POST['testID'] . "';
      ";
  }

  // echo $sql;
  // print_r($_POST);

  if ($conn->query($sql)) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exec();
  }

  $conn->close();

}
?>

<script type="text/javascript">
  window.location = "/tests.php";
</script>