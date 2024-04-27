<?php

include ('config/db.php');

$search = '';
$sql = 'SELECT lab_test.*, section.section_name, specimen.specimen_name FROM lab_test 
INNER JOIN section ON section.section_id = lab_test.section_id 
INNER JOIN specimen ON specimen.specimen_id = lab_test.specimen_id 
ORDER BY test_id DESC;';

if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $sql = "SELECT lab_test.*, section.section_name, specimen.specimen_name FROM lab_test 
  INNER JOIN section ON section.section_id = lab_test.section_id 
  INNER JOIN specimen ON specimen.specimen_id = lab_test.specimen_id 
  WHERE
  test_id LIKE '%". $search ."%' OR 
  test_name LIKE '%". $search ."%' OR 
  ref_range LIKE '%". $search ."%' OR 
  section.section_name LIKE '%". $search ."%' OR
  specimen.specimen_name LIKE '%". $search ."%'
  ORDER BY test_id DESC;";
}

$lab_tests = [];
$result = $conn->query($sql);
if ($conn->error) {
    echo $sql . "<br>";
    echo $conn->error;
}

if ($result->num_rows > 0) {
    while ($data = $result->fetch_object()) {
        $lab_tests[] = $data;
    }
}

?>

<h1>Tests</h1>

<!-- START: FORM SEARCH -->
<form class="row g-3" method="get" action="tests.php">
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
  <h3>Test List</h3>
  <a href="/tests-info.php" class="btn btn-primary " role="button" aria-disabled="true">Create Test</a>
</div>

<p></p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Test ID</th>
      <th scope="col">Test Name</th>
      <th scope="col">Ref Range</th>
      <th scope="col">Specimen</th>
      <th scope="col">Section</th>
      <th scope="col">Status</th>
      <th scope="col">Create Date</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <!-- $lab_tests = []; -->
  <?php foreach ($lab_tests as $lab_test) { ?>
    <tr>
      <td scope="col"><?php echo $lab_test->test_id; ?></td>
      <td scope="col"><?php echo $lab_test->test_name; ?></td>
      <td scope="col"><?php echo $lab_test->ref_range; ?></td>
      <td scope="col"><?php echo $lab_test->specimen_name; ?></td>
      <td scope="col"><?php echo $lab_test->section_name; ?></td>
      <td scope="col"><?php echo $lab_test->status == 1 ? 'Active' : 'Inactive' ; ?></td>
      <td scope="col"><?php echo convertDate($lab_test->create_date); ?></td>
      <td scope="col">
        <a href="/tests-info.php?test_id=<?php echo $lab_test->test_id; ?>" class="btn btn-default btn-sm" role="button" aria-disabled="true">Edit</a>
      </td>
    </tr>
    <?php } ?>

  </tbody>
</table>