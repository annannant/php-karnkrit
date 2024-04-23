<?php
include ('../config/db.php');

if (isset($_POST['sectionName'])) {
  $sectionName = $_POST['sectionName'];
  $isEdit = isset($_POST['sectionID']) ? true : false;

  $sql = "INSERT INTO section VALUES (NULL, '" . $sectionName . "', SYSDATE());";
  if ($isEdit) {
    $sql = "UPDATE section SET
      section_name = '" . $sectionName . "'
      WHERE section_id = '" . $_POST['sectionID'] . "';
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
  window.location = "/sections.php";
</script>