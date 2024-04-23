<?php

include ('config/db.php');


$search = '';
$sql = 'SELECT * FROM patient_rights ORDER BY patient_rights_ID DESC;';

if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $sql = "SELECT * FROM patient_rights WHERE 
  patient_rights_ID LIKE '%". $search ."%' OR 
  patient_rights_desc LIKE '%". $search ."%' 
  ORDER BY patient_rights_ID DESC;";
}

$patient_rights = [];
$result = $conn->query($sql);
if ($conn->error) {
  echo $conn->error;
}

if ($result->num_rows > 0) {
    while ($data = $result->fetch_object()) {
        $patient_rights[] = $data;
    }
}

?>

<h1>Patient Rights</h1>

<!-- START: FORM SEARCH -->
<form class="row g-3" method="get" action="patient-rights.php">
  <div class="col-auto">
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i>
      </span>
      <input type="text" class="form-control" name="search" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1"
        style="width:720px;"
        value="<?php echo $search ?>">
    </div>
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3">Search</button>
  </div>
</form>
<!-- END: FORM SEARCH -->
<hr />

<p></p>

<p></p>
<div class="w-full d-flex justify-content-between">
  <h3>Patient Right List</h3>
  <a href="/patient-rights-info.php" class="btn btn-primary " role="button" aria-disabled="true">Create Patient Right</a>
</div>

<p></p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Patient Rights ID</th>
      <th scope="col">Patient Rights Desc</th>
      <th scope="col">Status</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <!-- $patient_rights = []; -->
  <?php foreach ($patient_rights as $patient_right) { ?>
    <tr>
      <td scope="col"><?php echo $patient_right->patient_rights_ID; ?></td>
      <td scope="col"><?php echo $patient_right->patient_rights_desc; ?></td>
      <td scope="col"><?php echo $patient_right->status == 1 ? 'Active' : 'Inactive' ; ?></td>
      <td scope="col"></td>
      <td scope="col">
        <a href="/patient-rights-info.php?patient_rights_ID=<?php echo $patient_right->patient_rights_ID; ?>" class="btn btn-default btn-sm" role="button" aria-disabled="true">Edit</a>
      </td>
    </tr>
    <?php } ?>

  </tbody>
</table>