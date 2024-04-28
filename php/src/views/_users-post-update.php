<?php
include ('../config/db.php');

$isEdit = isset($_POST['user_id']) ? true : false;

if (!$isEdit && $_POST['password'] !== $_POST['confirmPassword']) {
    echo "Passwords do not match";
    exit();
}


// print_r($_POST);
// echo json_encode($_POST);
// exit();

if (isset($_POST['username'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $jobTitle = $_POST['jobTitle'];
  $sectionID = $_POST['sectionID'];
  $status = $_POST['status'];

  $sql = "INSERT INTO users VALUES (NULL, '" . $username . "', '" . $password . "', '" . $jobTitle . "', '" . $status . "', NOW(), NULL, '" . $sectionID . "');";
  if ($isEdit) {
    $sql = "UPDATE users SET
      username = '" . $username . "',
      jobTitle = '" . $jobTitle . "',
      sectionID = '" . $sectionID . "'
      status = '" . $status . "',
      WHERE user_id = '" . $_POST['user_id'] . "';
      ";
  }
  if ($conn->query($sql)) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit();
  }
  $conn->close();
}
?>

<script type="text/javascript">
  window.location = "/users.php";
</script>