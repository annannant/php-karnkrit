<?php

// --- START : SELECT BY PID ---
$info = new stdClass();
$info->first_name = "";
$info->last_name = "";
$info->bloodgroup = "";
$info->gender = "";
$dobYear = "";
$dobMonth = "";
$dobDate = "";

$isEdit = false;

if (isset($_GET['pid'])) {
  $isEdit = true;
  $pid = $_GET['pid'];
  $sql = "SELECT * FROM `patient` WHERE pid = '" . $pid . "';";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $info = $result->fetch_object();
  }

  $dbb = explode('-', $info->dob);
  $dobYear = $dbb[0];
  $dobMonth = $dbb[1];
  $dobDate = $dbb[2];
  print_r($info);
  $conn->close();
}
// --- END : SELECT BY PID ---
?>

<p></p>
<h3>
  <?php echo ($isEdit) ? "Edit" : "Create";  ?> Patient
</h3>
<p></p>
<!-- START: FORM CREATE -->
<form class="row g-3" method="post" action="views/_patients-post-update.php">
  <div class="container mx-auto " style="width:50%;">
    <div class="row column-gap-3 row-gap-3">
      <?php if (isset($_GET['pid'])): ?>
        <div class="col-full">
          <label for="pid" class="form-label">PID</label>
          <input type="input" readonly class="form-control disabled" name="pid" placeholder="" value="<?php echo $_GET['pid'] ?>">
        </div>
      <?php endif; ?>
      <div class="col-full">
        <label for="firstName" class="form-label">First Name</label>
        <input type="input" class="form-control" name="firstName" placeholder=""
          value="<?php echo $info->first_name; ?>">
      </div>
      <div class="col-full">
        <label for="lastName" class="form-label">Last Name</label>
        <input type="input" class="form-control" name="lastName" placeholder="" value="<?php echo $info->last_name; ?>">
      </div>
      <div class="col-full">
        <label for="" class="form-label">DOB</label>
        <div class="d-flex gap-0 column-gap-3">
          <input type="number" class="form-control" name="dobDate" placeholder="DD" value="<?php echo $dobDate ?>">
          <input type="number" class="form-control" name="dobMonth" placeholder="MM" value="<?php echo $dobMonth ?>">
          <input type="number" class="form-control" name="dobYear" placeholder="YYYY" value="<?php echo $dobYear ?>">
        </div>
      </div>
    </div>
    <div class="row row-gap-3 mt-2">
      <div class="col-full">
        <label for="firstName" class="form-label">Gender</label>
        <div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="gender1" value="M" <?php echo $info->gender === 'M' ? 'checked' : '' ?>>
            <label class="form-check-label" for="gender1">Male</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="gender2" value="F" <?php echo $info->gender === 'F' ? 'checked' : '' ?>>
            <label class="form-check-label" for="gender2">Female</label>
          </div>
        </div>
      </div>
      <div class="col-full">
        <label for="bloodGRoup" class="form-label">Blood Group</label>
        <div>
          <select name="bloodGroup" class="form-select" aria-label="Default select example">
            <option <?php echo $info->bloodgroup === '' ? 'selected' : '' ?>></option>
            <option value="A" <?php echo $info->bloodgroup === 'A' ? 'selected' : '' ?>>A</option>
            <option value="B" <?php echo $info->bloodgroup === 'B' ? 'selected' : '' ?>>B</option>
            <option value="O" <?php echo $info->bloodgroup === 'O' ? 'selected' : '' ?>>O</option>
            <option value="AB" <?php echo $info->bloodgroup === 'AB' ? 'selected' : '' ?>>AB</option>
          </select>
        </div>
      </div>
      <div class="col d-flex align-items-end mt-2 justify-content-end">
        <button type="submit" class="btn btn-primary ">Submit</button>
      </div>
    </div>
  </div>
</form>
<p></p>
<p></p>

<!-- END: FORM CREATE -->