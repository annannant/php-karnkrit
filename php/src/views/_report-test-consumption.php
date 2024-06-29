<?php

include ('config/db.php');


$search = '';
$sql = 'SELECT ot.lab_test_test_id,
       ot.lab_test_name,
       s.specimen_name,
       ct.container_name,
       COUNT(ot.lab_test_test_id) AS test_count
FROM `order_test` AS ot
JOIN lab_test AS t ON t.test_id = ot.lab_test_test_id
JOIN specimen AS s ON t.specimen_id = s.specimen_id
JOIN container AS ct ON s.container_id = ct.container_id';

$createDateFrom = "";
$createDateFrom = "";
$createDateTo = "";
if (!empty($_GET['createDateFrom']) && !empty($_GET['createDateTo'])) {
  $createDateFrom = $_GET['createDateFrom'];
  $createDateTo = $_GET['createDateTo'];
  $sql .= strpos($sql, 'WHERE') > 0 ? ' AND' : ' WHERE';
  $sql .= " ot.requested_date BETWEEN '".$createDateFrom." 00:00:00' AND '".$createDateTo." 23:59:59'";
} else {
  $sql .= strpos($sql, 'WHERE') > 0 ? ' AND' : ' WHERE';
  $sql .= " ot.requested_date BETWEEN '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59'";
}
$sql .= "GROUP BY ot.lab_test_test_id,
         ot.lab_test_name,
         s.specimen_name,
         ct.container_name
         ORDER BY ot.lab_test_test_id;";
// echo $sql;
$list = [];
$result = $conn->query($sql);
if ($conn->error) {
  echo $conn->error;
}

if ($result->num_rows > 0) {
  while ($data = $result->fetch_object()) {
    $list[] = $data;
  }
}

?>

<h1>Report - Test Consumption</h1>

<!-- START: FORM SEARCH -->
<form class="row g-3" method="get" action="report-test-consumption.php">
  <div class="col-full">
    <div class="row">
      <div class="col-2">
        <label for="createDateFrom" class="form-label">Created Date From</label>
        <input type="input" readonly class="form-control " name="createDateFrom" id="createDateFrom" placeholder=""
          value="<?php echo $createDateFrom; ?>">
      </div>
      <div class="col-2">
        <label for="createDateTo" class="form-label">Created Date To</label>
        <input type="input" readonly class="form-control " name="createDateTo" id="createDateTo" placeholder=""
          value="<?php echo $createDateTo; ?>">
      </div>
    </div>
    <div class="row ">
      <div class="col-full d-flex justify-content-end w-full column-gap-3 row-gap-3">
        <a href="report-test-consumption.php" class="btn btn-light mb-3">Reset</a>
        <button type="submit" class="btn btn-primary mb-3">Search</button>
      </div>
    </div>
  </div>
</form>
<!-- END: FORM SEARCH -->
<hr />

<p></p>

<p></p>
<div class="w-full d-flex justify-content-between">
  <h3>Test Consumption</h3>
  <!-- <a href="/report-test-consumption.php" class="btn btn-primary " role="button" aria-disabled="true">Create Patient</a> -->
</div>

<p></p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Test ID</th>
      <th scope="col">Test Name</th>
      <th scope="col">Specimen Name</th>
      <th scope="col">Container Name</th>
      <th scope="col">Total</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <!-- $list = []; -->
    <?php foreach ($list as $item) { ?>
      <tr>
        <td scope="col"><?php echo $item->lab_test_test_id; ?></td>
        <td scope="col"><?php echo $item->lab_test_name; ?></td>
        <td scope="col"><?php echo $item->specimen_name; ?></td>
        <td scope="col"><?php echo $item->container_name; ?></td>
        <td scope="col"><?php echo $item->test_count; ?></td>
        <td scope="col"></td>
      </tr>
    <?php } ?>
  </tbody>
</table>


<script type="text/javascript">
  $(document).ready(function () {
    $('#createDateFrom').datepicker({
      dateFormat: "yy-mm-dd",
      todayHighlight: true,
      autoclose: true,
    });
    $('#createDateTo').datepicker({
      dateFormat: "yy-mm-dd",
      todayHighlight: true,
      autoclose: true,
    });
    $('#reset').click(function(){
      window.location = '/report-test-consumption.php'
    })
  });
</script>