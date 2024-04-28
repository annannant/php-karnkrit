<?php
session_start();
include ('config/db.php');

$sql = "UPDATE users SET last_login_date = NOW()
WHERE user_id = '" . $_SESSION['user'] . "';";
if ($conn->query($sql)) {
  echo "Update record successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
  exit();
}
session_destroy();
?>

<script type="text/javascript">
  window.location = "/login.php";
</script>