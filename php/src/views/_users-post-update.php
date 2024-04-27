<?php
include ('../config/db.php');

if (isset($_POST['firstName'])) {
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $dob = $_POST['dobYear'] . '-' . $_POST['dobMonth'] . '-' . $_POST['dobDate'];
  $gender = $_POST['gender'];
  $bloodGroup = $_POST['bloodGroup'];

  $isEdit = isset($_POST['pid']) ? true : false;

  $sql = "INSERT INTO patient VALUES (NULL, '" . $firstName . "', '" . $lastName . "', '" . $dob . "', '" . $gender . "', '" . $bloodGroup . "');";
  if ($isEdit) {
    $sql = "UPDATE patient SET
      first_name = '" . $firstName . "',
      last_name = '" . $lastName . "',
      dob = '" . $dob . "',
      gender = '" . $gender . "',
      bloodGroup = '" . $bloodGroup . "'
      WHERE pid = '" . $_POST['pid'] . "';
      ";
  }

  // echo $sql;
  // exit();
  // print_r($_POST);

  if ($conn->query($sql)) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();

}
?>

<script type="text/javascript">
  window.location = "/patients.php";
</script>