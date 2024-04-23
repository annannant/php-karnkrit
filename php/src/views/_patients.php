<?php

include ('config/db.php');


$search = '';
$sql = 'SELECT * FROM patient ORDER BY pid DESC;';

if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $sql = "SELECT * FROM patient WHERE 
  first_name LIKE '%". $search ."%' OR 
  last_name LIKE '%". $search ."%' OR
  pid LIKE '%". $search ."%'
  ORDER BY pid DESC;";
}

$patients = [];
$result = $conn->query($sql);
if ($conn->error) {
  echo $conn->error;
}

if ($result->num_rows > 0) {
    while ($data = $result->fetch_object()) {
        $patients[] = $data;
    }
}

?>

<h1>Patient</h1>

<!-- START: FORM SEARCH -->
<form class="row g-3" method="get" action="patients.php">
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
  <h3>Patient List</h3>
  <a href="/patients-info.php" class="btn btn-primary " role="button" aria-disabled="true">Create Patient</a>
</div>

<p></p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">PID</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">DOB</th>
      <th scope="col">Age</th>
      <th scope="col">Gender</th>
      <th scope="col">Blood Group</th>
      <th scope="col">Visits</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <!-- $patients = []; -->
  <?php foreach ($patients as $patient) { ?>
    <tr>
      <td scope="col"><?php echo $patient->pid; ?></td>
      <td scope="col"><?php echo $patient->first_name; ?></td>
      <td scope="col"><?php echo $patient->last_name; ?></td>
      <td scope="col"><?php echo $patient->dob; ?></td>
      <td scope="col">
      <?php
        $dob = new DateTime($patient->dob);
        $today   = new DateTime('today');
        $year = $dob->diff($today)->y;
        $month = $dob->diff($today)->m;
        $day = $dob->diff($today)->d;
        echo $year;
      ?>
      </td>
      <td scope="col"><?php echo $patient->gender; ?></td>
      <td scope="col"><?php echo $patient->bloodgroup; ?></td>
      <td scope="col">
        <a href="/visits.php?pid=<?php echo $patient->pid; ?>" class="btn btn-default btn-sm" role="button" aria-disabled="true">Visit</a>
      </td>
      <td scope="col">
        <a href="/patients-info.php?pid=<?php echo $patient->pid; ?>" class="btn btn-default btn-sm" role="button" aria-disabled="true">Edit</a>
      </td>
    </tr>
    <?php } ?>

  </tbody>
</table>