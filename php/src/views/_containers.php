<?php

include ('config/db.php');

$search = '';
$sql = 'SELECT * FROM container ORDER BY container_id DESC;';

if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $sql = "SELECT * FROM container WHERE 
  container_id LIKE '%". $search ."%' OR 
  container_name LIKE '%". $search ."%'
  ORDER BY container_id DESC;";
}

$containers = [];
$result = $conn->query($sql);
if ($conn->error) {
  echo $conn->error;
}

if ($result->num_rows > 0) {
    while ($data = $result->fetch_object()) {
        $containers[] = $data;
    }
}

?>

<h1>Container Type</h1>

<!-- START: FORM SEARCH -->
<form class="row g-3" method="get" action="containers.php">
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
  <h3>Container List</h3>
  <a href="/containers-info.php" class="btn btn-primary " role="button" aria-disabled="true">Create Container</a>
</div>

<p></p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Container Code</th>
      <th scope="col">Container Name</th>
      <th scope="col">Status</th>
      <th scope="col">Create Date</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <!-- $containers = []; -->
  <?php foreach ($containers as $patient) { ?>
    <tr>
      <td scope="col"><?php echo $patient->container_id; ?></td>
      <td scope="col"><?php echo $patient->container_name; ?></td>
      <td scope="col"><?php echo $patient->status == 1 ? 'Active' : 'Inactive' ; ?></td>
      <td scope="col"><?php echo convertDate($patient->create_date, 'Y-m-d H:i:s') ?></td>
      <td scope="col">
        <a href="/containers-info.php?container_id=<?php echo $patient->container_id; ?>" class="btn btn-default btn-sm" role="button" aria-disabled="true">Edit</a>
      </td>
    </tr>
    <?php } ?>

  </tbody>
</table>