<?php
include ('../config/db.php');
// print_r($_POST);
// exit();
if (isset($_POST['firstName'])) {

  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $dob = $_POST['dobYear'] . '-' . $_POST['dobMonth'] . '-' . $_POST['dobDate'];
  $gender = $_POST['gender'];
  $bloodGroup = $_POST['bloodGroup'];

  $sql = "INSERT INTO patient VALUES (NULL, '" . $firstName . "', '" . $lastName . "', '" . $dob . "', '" . $gender . "', '" . $bloodGroup . "');";
// echo $sql;
  if ($conn->query($sql)) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();

}
?>

<script type="text/javascript">
  window.location="/patients.php";
</script>