<?php

// --- START : SELECT BY PID ---
$info = new stdClass();
$info->user_name = '';
$info->user_pass = '';
$info->job_title = '';
$info->status = '';
$info->section_id = '';

$isEdit = false;

if (isset($_GET['user_id'])) {
  $isEdit = true;
  $user_id = $_GET['user_id'];
  $sql = "SELECT * FROM users WHERE user_id = '" . $user_id . "';";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $data = $result->fetch_object();
    $info->user_name = $data->user_name ;
    $info->user_pass = $data->user_pass ;
    $info->job_title = $data->job_title ;
    $info->status = $data->status;
    $info->section_id = $data->section_id ;
    // print_r($data);
    // exit();
  }
}
// --- END : SELECT BY PID ---


// --- START : SELECT Section ---
$sqlSection = 'SELECT * FROM section ORDER BY section_name ASC;';
$sections = [];
$Sesultspecimen = $conn->query($sqlSection);
if ($Sesultspecimen->num_rows > 0) {
  while ($Sataspecimen = $Sesultspecimen->fetch_object()) {
    $sections[] = $Sataspecimen;
  }
}
// --- END : SELECT Section ---
?>

<p></p>
<h3>
  <?php echo ($isEdit) ? "Edit" : "Create"; ?> User
</h3>
<p></p>
<!-- START: FORM CREATE -->
<form class="row g-3" method="post" action="views/_users-post-update.php">
  <div class="container mx-auto " style="width:50%;">
    <div class="row column-gap-3 row-gap-3">
      <?php if (isset($_GET['user_id'])): ?>
        <div class="col-full">
          <label for="user_id" class="form-label">User ID</label>
          <input type="input" readonly class="form-control disabled" name="user_id" placeholder=""
            value="<?php echo $_GET['user_id'] ?>">
        </div>
      <?php endif; ?>
      <div class="col-full">
        <label for="username" class="form-label">Username</label>
        <input type="input" class="form-control" name="username" placeholder=""
          value="<?php echo $info->user_name; ?>" >
      </div>
      <?php if (!$isEdit) { ?>
      <div class="col-full">
        <label for="createPassword" class="form-label">Password</label>
        <input type="createPassword" class="form-control" name="createPassword" placeholder=""
          value="">
      </div>
      <div class="col-full">
        <label for="confirmCreatePassword" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" name="confirmCreatePassword"
          value="">
      </div>
      <?php } ?>
      <!-- <hr class="mt-3 mb-2"></hr> -->
      <div class="col-full ">
        <label for="jobTitle" class="form-label">Job Title</label>
        <input type="input" class="form-control" name="jobTitle"
          value="<?php echo $info->job_title; ?>">
      </div>
    </div>
    <div class="row row-gap-3 mt-2">
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
      <div class="col d-flex align-items-end mt-2 justify-content-end">
        <button type="submit" class="btn btn-primary ">Submit</button>
      </div>
    </div>
  </div>
</form>
<p></p>
<p></p>

<!-- END: FORM CREATE -->