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
<h3>Create Patient</h3>
<p></p>
<!-- START: FORM CREATE -->
<form class="row g-3" method="post" action="views/_patients-create.php">
  <div class="container">
    <div class="row">
      <div class="col">
        <label for="firstName" class="form-label">First Name</label>
        <input type="input" class="form-control" name="firstName" placeholder="">
      </div>
      <div class="col">
        <label for="lastName" class="form-label">Last Name</label>
        <input type="input" class="form-control" name="lastName" placeholder="">
      </div>
      <div class="col">
        <label for="" class="form-label">DOB</label>
        <div class="d-flex gap-0 column-gap-3">
          <input type="number" class="form-control" name="dobDate" placeholder="DD">
          <input type="number" class="form-control" name="dobMonth" placeholder="MM">
          <input type="number" class="form-control" name="dobYear" placeholder="YYYY">
        </div>
      </div>
    </div>
    <div class="row mt-2">
      <div class="col">
        <label for="firstName" class="form-label">Gender</label>
        <div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="gender1" value="M">
            <label class="form-check-label" for="gender1">Male</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="gender2" value="F">
            <label class="form-check-label" for="gender2">Female</label>
          </div>
        </div>
      </div>
      <div class="col">
        <label for="bloodGRoup" class="form-label">Blood Group</label>
        <div>
          <select name="bloodGroup" class="form-select" aria-label="Default select example">
            <option selected></option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="O">O</option>
            <option value="AB">AB</option>
          </select>
        </div>
      </div>
      <div class="col d-flex align-items-end">
        <button type="submit" class="btn btn-primary ">Submit</button>
      </div>
    </div>
  </div>
</form>
<!-- END: FORM CREATE -->

<p></p>

<hr />

<p></p>
<h3>Patient List</h3>

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
      <td scope="col"></td>
    </tr>
    <?php } ?>

  </tbody>
</table>