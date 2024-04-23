<?php


$search = '';
$sql = 'SELECT * FROM section ORDER BY section_id DESC;';

if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $sql = "SELECT * FROM section WHERE 
  section_id LIKE '%". $search ."%' OR 
  section_name LIKE '%". $search ."%'
  ORDER BY section_id DESC;";
}

$sections = [];
$result = $conn->query($sql);
if ($conn->error) {
  echo $conn->error;
}

if ($result->num_rows > 0) {
    while ($data = $result->fetch_object()) {
        $sections[] = $data;
    }
}

?>

<h1>Sections</h1>

<!-- START: FORM SEARCH -->
<form class="row g-3" method="get" action="sections.php">
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
  <h3>Section List</h3>
  <a href="/sections-info.php" class="btn btn-primary " role="button" aria-disabled="true">Create Section</a>
</div>

<p></p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Section ID</th>
      <th scope="col">Section Name</th>
      <th scope="col">Create Date</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <!-- $sections = []; -->
  <?php foreach ($sections as $patient) { ?>
    <tr>
      <td scope="col"><?php echo $patient->section_id; ?></td>
      <td scope="col"><?php echo $patient->section_name; ?></td>
      <td scope="col"><?php echo convertDate($patient->create_date, 'Y-m-d H:i:s'); ?></td>
      <td scope="col">
        <a href="/sections-info.php?section_id=<?php echo $patient->section_id; ?>" class="btn btn-default btn-sm" role="button" aria-disabled="true">Edit</a>
      </td>
    </tr>
    <?php } ?>

  </tbody>
</table>