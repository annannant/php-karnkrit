<?php
include ('../config/db.php');

$isEdit = isset($_POST['user_id']) ? true : false;
echo $isEdit;

if (!$isEdit && $_POST['createPassword'] !== $_POST['confirmCreatePassword']) {
    echo "Passwords do not match";
    exit();
}

if (isset($_POST['username'])) {
  $username = $_POST['username'];
  $password = $_POST['createPassword'];
  $jobTitle = $_POST['jobTitle'];
  $sectionID = $_POST['sectionID'];
  $status = $_POST['status'];

  $sql = "INSERT INTO users VALUES (NULL, '" . $username . "', '" . $password . "', '" . $jobTitle . "', '" . $status . "', NOW(), NULL, '" . $sectionID . "');";
  if ($isEdit) {
    $sql = "UPDATE users SET
      user_name = '" . $username . "',
      job_title = '" . $jobTitle . "',
      section_id = '" . $sectionID . "',
      status = " . $status . "
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