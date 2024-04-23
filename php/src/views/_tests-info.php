<?php

// --- START : SELECT BY PID ---
$info = new stdClass();
$info->test_name = "";
$info->ref_range = "";
$info->create_date = "";
$info->status = "";
$info->section_id = "";
$info->specimen_id = "";

$isEdit = false;
if (isset($_GET['test_id'])) {
  $isEdit = true;
  $test_id = $_GET['test_id'];
  $sql = "SELECT * FROM `lab_test` WHERE test_id = '" . $test_id . "';";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $info = $result->fetch_object();
  }
}
// --- END : SELECT BY PID ---

// --- START : SELECT Section ---
$sqlSection = 'SELECT * FROM specimen WHERE status = 1 ORDER BY specimen_name ASC;';
$specimens = [];
$resultSection = $conn->query($sqlSection);
if ($resultSection->num_rows > 0) {
  while ($dataSection = $resultSection->fetch_object()) {
    $specimens[] = $dataSection;
  }
}
// --- END : SELECT Section ---

// --- START : SELECT Specimen ---
$Sqlspecimen = 'SELECT * FROM section ORDER BY section_name ASC;';
$sections = [];
$Sesultspecimen = $conn->query($Sqlspecimen);
if ($Sesultspecimen->num_rows > 0) {
  while ($Sataspecimen = $Sesultspecimen->fetch_object()) {
    $sections[] = $Sataspecimen;
  }
}
// --- END : SELECT Specimen ---


$conn->close();

?>

<p></p>
<h3>
  <?php echo ($isEdit) ? "Edit" : "Create"; ?> Test
</h3>
<p></p>
<!-- START: FORM CREATE -->
<form class="row g-3" method="post" action="views/_tests-post-update.php">
  <div class="container mx-auto " style="width:50%;">
    <div class="row column-gap-3 row-gap-3">
      <?php if (isset($_GET['test_id'])): ?>
        <div class="col-full">
          <label for="testID" class="form-label">Test ID</label>
          <input type="input" readonly class="form-control disabled" name="testID" placeholder=""
            value="<?php echo $_GET['test_id'] ?>">
        </div>
      <?php endif; ?>
      <div class="col-full">
        <label for="testName" class="form-label">Test Name</label>
        <input type="input" class="form-control" name="testName" placeholder=""
          value="<?php echo $info->test_name; ?>">
      </div>
      <div class="col-full">
        <label for="refRange" class="form-label">Ref Range</label>
        <input type="input" class="form-control" name="refRange" placeholder=""
          value="<?php echo $info->ref_range; ?>">
      </div>
      <div class="col-full">
        <label for="specimenID" class="form-label">Specimen</label>
        <div>
          <select name="specimenID" class="form-select" aria-label="Default select example">
            <option <?php echo $info->specimen_id === '' ? 'selected' : '' ?>></option>
            <?php foreach ($specimens as $specimen) { ?>
              <option value="<?php echo $specimen->specimen_id; ?>" <?php echo $info->specimen_id === $specimen->specimen_id ? 'selected' : '' ?>>
                <?php echo $specimen->specimen_name; ?>
              </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-full">
        <label for="sectionID" class="form-label">Section</label>
        <div>
          <select name="sectionID" class="form-select" aria-label="Default select example">
            <option <?php echo $info->section_id === '' ? 'selected' : '' ?>></option>
            <?php foreach ($sections as $section) { ?>
              <option value="<?php echo $section->section_id; ?>" <?php echo $info->section_id === $section->section_id ? 'selected' : '' ?>>
                <?php echo $section->section_name; ?>
              </option>
            <?php } ?>
          </select>
        </div>
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