<?php

// --- START : SELECT BY PID ---
$info = new stdClass();
$info->priority = "";
$info->visit_date = "";
$info->create_date = "";
$info->patient_rights_ID = "";

$isEdit = false;
if (isset($_GET['vn'])) {
  $isEdit = true;
  $vn = $_GET['vn'];
  $sql = "SELECT * FROM `visit` WHERE vn = '" . $vn . "';";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $info = $result->fetch_object();
    $pid = $info->pid;
  }
}
// --- END : SELECT BY PID ---

// START: FORM GET INFO
if (isset($_GET['pid'])) {
  $pid = $_GET['pid'];
}
$sql = "SELECT * FROM `patient` WHERE pid = '" . $pid . "';";
$patient = new stdClass();
$patient->pid = "";
$patient->first_name = "";
$patient->last_name = "";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  $patient = $result->fetch_object();
}
// END: FORM GET INFO




// --- START : SELECT Section ---
$sqlPatientRight = 'SELECT * FROM patient_rights WHERE status = 1 ORDER BY patient_rights_desc ASC;';
$patientRights = [];
$resultPatientRight = $conn->query($sqlPatientRight);
if ($resultPatientRight->num_rows > 0) {
  while ($dataPatientRight = $resultPatientRight->fetch_object()) {
    $patientRights[] = $dataPatientRight;
  }
}
// --- END : SELECT Section ---


$conn->close();

?>

<p></p>
<h3>
  <?php echo ($isEdit) ? "Edit" : "Create"; ?> Visit
</h3>
<p></p>
<!-- START: FORM CREATE -->
<form class="row g-3" method="post" action="views/_visits-post-update.php">
  <div class="container mx-auto " style="width:50%;">
    <div class="row column-gap-3 row-gap-3">
      <?php if (isset($_GET['vn'])): ?>
        <div class="col-full">
          <label for="vn" class="form-label">VN</label>
          <input type="input" readonly class="form-control disabled" name="vn" placeholder=""
            value="<?php echo $_GET['vn'] ?>">
        </div>
      <?php endif; ?>
      <div class="col-full">
        <label class="form-label">PID</label>
        <input type="input" disabled class="form-control disabled" placeholder="" value="<?php echo $pid ?> - <?php echo $patient->first_name; ?> <?php echo $patient->last_name; ?>">
        <input type="hidden" name="pid" value="<?php echo $pid ?>">
      </div>
      <!-- <div class="col-full">
        <label for="firstName" class="form-label">First Name</label>
        <input type="input" disabled class="form-control" name="firstName" placeholder=""
          value="<?php echo $patient->first_name; ?>">
      </div>
      <div class="col-full">
        <label for="lastName" class="form-label">Last Name</label>
        <input type="input" disabled class="form-control" name="lastName" placeholder=""
          value="<?php echo $patient->last_name; ?>">
      </div> -->
      <div class="col-full">
        <label for="priority" class="form-label">Priority</label>
        <input type="input" class="form-control" name="priority" placeholder="" value="<?php echo $info->priority; ?>">
      </div>
      <div class="col-full">
        <label for="patientRightID" class="form-label">Patient Rights</label>
        <div>
          <select name="patientRightID" class="form-select" aria-label="Default select example">
            <option <?php echo $info->patient_rights_ID === '' ? 'selected' : '' ?>></option>
            <?php foreach ($patientRights as $patientRight) { ?>
              <option value="<?php echo $patientRight->patient_rights_ID; ?>" <?php echo $info->patient_rights_ID === $patientRight->patient_rights_ID ? 'selected' : '' ?>>
                <?php echo $patientRight->patient_rights_desc; ?>
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