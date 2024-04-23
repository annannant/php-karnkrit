<?php

// --- START : SELECT BY PID ---
$info = new stdClass();
$info->patient_rights_desc = "";
$info->status = "";

$isEdit = false;

if (isset($_GET['patient_rights_ID'])) {
  $isEdit = true;
  $patient_rights_ID = $_GET['patient_rights_ID'];
  $sql = "SELECT * FROM `patient_rights` WHERE patient_rights_ID = '" . $patient_rights_ID . "';";

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
  <?php echo ($isEdit) ? "Edit" : "Create";  ?> Patient Right
</h3>
<p></p>
<!-- START: FORM CREATE -->
<form class="row g-3" method="post" action="views/_patient-rights-post-update.php">
  <div class="patient_rights mx-auto " style="width:50%;">
    <div class="row column-gap-3 row-gap-3">
      <?php if (isset($_GET['patient_rights_ID'])): ?>
        <div class="col-full">
          <label for="patient_rightsID" class="form-label">Patient Right ID</label>
          <input type="input" readonly class="form-control disabled" name="patientRightID" placeholder="" value="<?php echo $_GET['patient_rights_ID'] ?>">
        </div>
      <?php endif; ?>
      <div class="col-full">
        <label for="patient_rightsName" class="form-label">Patient Right Desc</label>
        <input type="input" class="form-control" name="patientRightDesc" placeholder=""
          value="<?php echo $info->patient_rights_desc; ?>">
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