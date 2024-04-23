<?php

include ('config/db.php');

$search = '';
$sql = 'SELECT specimen.*, container.container_name FROM specimen INNER JOIN container ON container.container_id = specimen.container_id;';

if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $sql = "SELECT specimen.*, container.container_name FROM specimen INNER JOIN container ON container.container_id = specimen.container_id WHERE
  specimen_id LIKE '%". $search ."%' OR 
  specimen_name LIKE '%". $search ."%' OR 
  specimen_type LIKE '%". $search ."%' OR 
  container.container_name LIKE '%". $search ."%'
  ORDER BY specimen_id;";
}

$specimens = [];
$result = $conn->query($sql);
if ($conn->error) {
    echo $sql . "<br>";
    echo $conn->error;
}

if ($result->num_rows > 0) {
    while ($data = $result->fetch_object()) {
        $specimens[] = $data;
    }
}

?>

<h1>Specimens</h1>

<!-- START: FORM SEARCH -->
<form class="row g-3" method="get" action="specimens.php">
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
  <h3>Specimen List</h3>
  <a href="/specimens-info.php" class="btn btn-primary " role="button" aria-disabled="true">Create Specimen</a>
</div>

<p></p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Specimen ID</th>
      <th scope="col">Specimen Name</th>
      <th scope="col">Specimen Type</th>
      <th scope="col">Status</th>
      <th scope="col">Create Date</th>
      <th scope="col">Container</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <!-- $specimens = []; -->
  <?php foreach ($specimens as $specimen) { ?>
    <tr>
      <td scope="col"><?php echo $specimen->specimen_id; ?></td>
      <td scope="col"><?php echo $specimen->specimen_name; ?></td>
      <td scope="col"><?php echo $specimen->specimen_type; ?></td>
      <td scope="col"><?php echo $specimen->status == 1 ? 'Active' : 'Inactive' ; ?></td>
      <td scope="col"><?php echo convertDate($specimen->create_date); ?></td>
      <td scope="col"><?php echo $specimen->container_name; ?></td>
      <td scope="col">
        <a href="/specimens-info.php?specimen_id=<?php echo $specimen->specimen_id; ?>" class="btn btn-default btn-sm" role="button" aria-disabled="true">Edit</a>
      </td>
    </tr>
    <?php } ?>

  </tbody>
</table>