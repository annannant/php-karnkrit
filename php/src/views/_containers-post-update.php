<?php
include ('../config/db.php');

if (isset($_POST['containerName'])) {
  $containerName = $_POST['containerName'];
  $status = $_POST['status'];
  $isEdit = isset($_POST['containerID']) ? true : false;

  $sql = "INSERT INTO container VALUES (NULL, '" . $containerName . "', NOW(), ".$status.");";
  if ($isEdit) {
    $sql = "UPDATE container SET
      container_name = '" . $containerName . "',
      status = '" . $status . "'
      WHERE container_id = '" . $_POST['containerID'] . "';
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
  window.location = "/containers.php";
</script>