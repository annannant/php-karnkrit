<?php
include ('../config/db.php');

if (isset($_POST['specimenName'])) {
  $specimenName = $_POST['specimenName'];
  $specimenType = $_POST['specimenType'];
  $status = $_POST['status'];
  $containerID = $_POST['containerID'];
  $isEdit = isset($_POST['specimenID']) ? true : false;

  $sql = "INSERT INTO specimen VALUES (NULL, '" . $specimenName . "', '" . $specimenType . "', NOW(), ".$status.", ".$containerID.");";
  if ($isEdit) {
    $sql = "UPDATE specimen SET
      specimen_name = '" . $specimenName . "',
      specimen_type = '" . $specimenType . "',
      status = '" . $status . "',
      container_id = '" . $containerID . "'
      WHERE specimen_id = '" . $_POST['specimenID'] . "';
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
  window.location = "/specimens.php";
</script>