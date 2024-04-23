<?php

// START: FORM GET INFO
$pid = $_GET['pid'];
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


$search = '';
$sql = "SELECT visit.*, patient_rights.patient_rights_desc FROM visit 
INNER JOIN patient_rights ON visit.patient_rights_ID = patient_rights.patient_rights_ID
WHERE visit.pid = '".$pid."' ORDER BY visit.vn DESC;";

$visits = [];
$result = $conn->query($sql);
if ($conn->error) {
  echo $conn->error;
}

if ($result->num_rows > 0) {
  while ($data = $result->fetch_object()) {
    $visits[] = $data;
  }
}

?>

<h1>Visits</h1>
<p></p>

<!-- START: FORM PATIENT -->
<p></p>
<form class="row g-3" method="get" action="sections.php">
  <div class="container mx-auto">
    <div class="row column-gap-3 row-gap-3">
      <div class="col">
        <label for="pid" class="form-label">PID</label>
        <input type="input" disabled class="form-control disabled" name="pid" placeholder=""
          value="<?php echo $patient->pid; ?>">
      </div>
      <div class="col">
        <label for="firstName" class="form-label">First Name</label>
        <input type="input" disabled class="form-control" name="firstName" placeholder=""
          value="<?php echo $patient->first_name; ?>">
      </div>
      <div class="col">
        <label for="lastName" class="form-label">Last Name</label>
        <input type="input" disabled class="form-control" name="lastName" placeholder="" value="<?php echo $patient->last_name; ?>">
      </div>
    </div>
  </div>
</form>
<!-- END: FORM PATIENT -->
<hr />

<p></p>

<p></p>
<div class="w-full d-flex justify-content-between">
  <h3>Visit List</h3>
  <a href="/visits-info.php?pid=<?php echo $pid ?>" class="btn btn-primary " role="button" aria-disabled="true">Create Visit</a>
</div>

<p></p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">VN</th>
      <th scope="col">PID</th>
      <th scope="col">Priority</th>
      <th scope="col">Patient Rights</th>
      <th scope="col">Visit Date</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <!-- $sections = []; -->
    <?php foreach ($visits as $visit) { ?>
      <tr>
        <td scope="col"><?php echo $visit->vn; ?></td>
        <td scope="col"><?php echo $visit->pid; ?></td>
        <td scope="col"><?php echo $visit->priority; ?></td>
        <td scope="col"><?php echo $visit->patient_rights_desc; ?></td>
        <td scope="col"><?php echo convertDate($visit->visit_date, 'Y-m-d H:i:s'); ?></td>

        <td scope="col">
          <a href="/visits-info.php?vn=<?php echo $visit->vn; ?>" class="btn btn-default btn-sm"
            role="button" aria-disabled="true">Edit</a>
        </td>
      </tr>
    <?php } ?>

  </tbody>
</table>