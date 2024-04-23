<?php
include ('../config/db.php');

if (isset($_POST['pid'])) {
  $pid = $_POST['pid'];
  $priority = $_POST['priority'];
  $patientRightID = $_POST['patientRightID'];
  $isEdit = isset($_POST['vn']) ? true : false;
  $sql = "INSERT INTO visit VALUES (NULL, '" . $pid . "', '" . $priority . "', NOW(), ".$patientRightID.");";
  if ($isEdit) {
    $sql = "UPDATE visit SET
      pid = '" . $pid . "',
      priority = '" . $priority . "',
      patient_rights_ID = '" . $patientRightID . "'
      WHERE vn = '" . $_POST['vn'] . "';
      ";
  }

//   echo $sql;
//   print_r($_POST);
// exit();
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
  window.location = "/visits.php?pid=<?php echo $_POST['pid']; ?>";
</script>