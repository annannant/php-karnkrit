<?php

// --- START : SELECT BY PID ---
$info = new stdClass();
$info->section_name = "";
$info->status = "";

$isEdit = false;

if (isset($_GET['section_id'])) {
  $isEdit = true;
  $section_id = $_GET['section_id'];
  $sql = "SELECT * FROM `section` WHERE section_id = '" . $section_id . "';";

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
  <?php echo ($isEdit) ? "Edit" : "Create";  ?> Section
</h3>
<p></p>
<!-- START: FORM CREATE -->
<form class="row g-3" method="post" action="views/_sections-post-update.php">
  <div class="section mx-auto " style="width:50%;">
    <div class="row column-gap-3 row-gap-3">
      <?php if (isset($_GET['section_id'])): ?>
        <div class="col-full">
          <label for="sectionID" class="form-label">Section ID</label>
          <input type="input" readonly class="form-control disabled" name="sectionID" placeholder="" value="<?php echo $_GET['section_id'] ?>">
        </div>
      <?php endif; ?>
      <div class="col-full">
        <label for="sectionName" class="form-label">Section Name</label>
        <input type="input" class="form-control" name="sectionName" placeholder=""
          value="<?php echo $info->section_name; ?>">
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