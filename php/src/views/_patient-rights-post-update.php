<?php
include ('../config/db.php');

if (isset($_POST['patientRightDesc'])) {
  $patientRightDesc = $_POST['patientRightDesc'];
  $status = $_POST['status'];
  $isEdit = isset($_POST['patientRightID']) ? true : false;

  $sql = "INSERT INTO patient_rights VALUES (NULL, '" . $patientRightDesc . "', ".$status.");";
  if ($isEdit) {
    $sql = "UPDATE patient_rights SET
      patient_rights_desc = '" . $patientRightDesc . "',
      status = '" . $status . "'
      WHERE patient_rights_ID = '" . $_POST['patientRightID'] . "';
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
  window.location = "/patient-rights.php";
</script>