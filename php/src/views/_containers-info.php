<?php

// --- START : SELECT BY PID ---
$info = new stdClass();
$info->container_name = "";

$isEdit = false;

if (isset($_GET['container_id'])) {
  $isEdit = true;
  $container_id = $_GET['container_id'];
  $sql = "SELECT * FROM `container` WHERE container_id = '" . $container_id . "';";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $info = $result->fetch_object();
  }

  $conn->close();
}
// --- END : SELECT BY PID ---
?>

<p></p>
<h3>
  <?php echo ($isEdit) ? "Edit" : "Create";  ?> Container
</h3>
<p></p>
<!-- START: FORM CREATE -->
<form class="row g-3" method="post" action="views/_containers-post-update.php">
  <div class="container mx-auto " style="width:50%;">
    <div class="row column-gap-3 row-gap-3">
      <?php if (isset($_GET['container_id'])): ?>
        <div class="col-full">
          <label for="containerID" class="form-label">Container Code</label>
          <input type="input" readonly class="form-control disabled" name="containerID" placeholder="" value="<?php echo $_GET['container_id'] ?>">
        </div>
      <?php endif; ?>
      <div class="col-full">
        <label for="containerName" class="form-label">Container Name</label>
        <input type="input" class="form-control" name="containerName" placeholder=""
          value="<?php echo $info->container_name; ?>">
      </div>
  
    </div>
    <div class="row row-gap-3 mt-2">
      <div class="col d-flex align-items-end mt-2 justify-content-end">
        <button type="submit" class="btn btn-primary ">Submit</button>
      </div>
    </div>
  </div>
</form>
<p></p>
<p></p>

<!-- END: FORM CREATE -->