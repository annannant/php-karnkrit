<?php

// --- START : SELECT BY PID ---
$info = new stdClass();
$info->specimen_name = "";
$info->specimen_type = "";
$info->status = "";
$info->container_id = "";

$isEdit = false;
if (isset($_GET['specimen_id'])) {
  $isEdit = true;
  $specimen_id = $_GET['specimen_id'];
  $sql = "SELECT * FROM `specimen` WHERE specimen_id = '" . $specimen_id . "';";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $info = $result->fetch_object();
  }
}
// --- END : SELECT BY PID ---

// --- START : SELECT Container ---
$sqlContainer = 'SELECT * FROM container WHERE status = 1 ORDER BY container_id DESC;';
$containers = [];
$resultContainer = $conn->query($sqlContainer);
if ($resultContainer->num_rows > 0) {
  while ($dataContainer = $resultContainer->fetch_object()) {
    $containers[] = $dataContainer;
  }
}
$conn->close();
// --- END : SELECT Container ---

?>

<p></p>
<h3>
  <?php echo ($isEdit) ? "Edit" : "Create"; ?> Specimen
</h3>
<p></p>
<!-- START: FORM CREATE -->
<form class="row g-3" method="post" action="views/_specimens-post-update.php">
  <div class="specimen mx-auto " style="width:50%;">
    <div class="row column-gap-3 row-gap-3">
      <?php if (isset($_GET['specimen_id'])): ?>
        <div class="col-full">
          <label for="specimenID" class="form-label">Specimen Code</label>
          <input type="input" readonly class="form-control disabled" name="specimenID" placeholder=""
            value="<?php echo $_GET['specimen_id'] ?>">
        </div>
      <?php endif; ?>
      <div class="col-full">
        <label for="specimenName" class="form-label">Specimen Name</label>
        <input type="input" class="form-control" name="specimenName" placeholder=""
          value="<?php echo $info->specimen_name; ?>">
      </div>
      <div class="col-full">
        <label for="specimenType" class="form-label">Specimen Type</label>
        <input type="number" class="form-control" name="specimenType" placeholder=""
          value="<?php echo $info->specimen_type; ?>">
      </div>
      <div class="col-full">
        <label for="status" class="form-label">Status</label>
        <div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="status1" value="1" <?php echo $info->status == 1 ? 'checked' : '' ?>>
            <label class="form-check-label" for="status1">Active</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="status" id="status2" value="0" <?php echo $info->status == 0 ? 'checked' : '' ?>>
            <label class="form-check-label" for="status2">Inactive</label>
          </div>
        </div>
      </div>
      <div class="col-full">
        <label for="containerID" class="form-label">Container ID</label>
        <div>
          <select name="containerID" class="form-select" aria-label="Default select example">
            <option <?php echo $info->container_id === '' ? 'selected' : '' ?>></option>
            <?php foreach ($containers as $container) { ?>
              <option value="<?php echo $container->container_id; ?>" <?php echo $info->container_id === $container->container_id ? 'selected' : '' ?>>
                <?php echo $container->container_name; ?>
              </option>
            <?php } ?>
          </select>
        </div>
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