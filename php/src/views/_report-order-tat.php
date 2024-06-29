<?php

include ('config/db.php');


$sql = 'SELECT 
    order_test.lab_order_ln, 
    order_test.lab_test_name, 
    order_test.lab_test_result,
    section.section_name,
    (SELECT TIMESTAMPDIFF(HOUR, order_test.requested_date, NOW())) AS hours_since_requested,
    (SELECT MOD(TIMESTAMPDIFF(MINUTE, order_test.requested_date, NOW()), 60)) AS minutes_since_requested,
    order_test.requested_date
FROM 
    order_test JOIN lab_test on order_test.lab_test_test_id = lab_test.test_id
    JOIN section on section.section_id = lab_test.section_id
WHERE 
    order_test.completed_date IS NULL ';

$createDateFrom = "";
$createDateFrom = "";
$createDateTo = "";
if (!empty($_GET['createDateFrom']) && !empty($_GET['createDateTo'])) {
  $createDateFrom = $_GET['createDateFrom'];
  $createDateTo = $_GET['createDateTo'];
  $sql .= strpos($sql, 'WHERE') > 0 ? ' AND' : ' WHERE';
  $sql .= " order_test.requested_date BETWEEN '" . $createDateFrom . " 00:00:00' AND '" . $createDateTo . " 23:59:59'";
} else {
  $sql .= strpos($sql, 'WHERE') > 0 ? ' AND' : ' WHERE';
  $sql .= " order_test.requested_date BETWEEN '" . date("Y-m-d") . " 00:00:00' AND '" . date("Y-m-d") . " 23:59:59'";
}

$sql .= " ORDER BY hours_since_requested DESC,
		    minutes_since_requested DESC,
        order_test.lab_order_ln,
        section.section_name;
";

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

<h1>Report - TAT Orders for Pending Result </h1>

<!-- START: FORM SEARCH -->
<form class="row g-3" method="get" action="report-order-tat.php">
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
        <a href="report-order-tat.php" class="btn btn-light mb-3">Reset</a>
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
  <h3>TAT Orders for Pending Result </h3>
</div>

<p></p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">lab_order_ln</th>
        <th scope="col">lab_test_name</th>
        <th scope="col">lab_test_result</th>
        <th scope="col">section_name</th>
        <th scope="col">hours_since_requested</th>
        <th scope="col">minutes_since_requested</th>
        <th scope="col">Requested Date</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <!-- $list = []; -->
    <?php foreach ($list as $item) { ?>
      <tr>
        <td scope="col"><?php echo $item->lab_order_ln; ?></td>
        <td scope="col"><?php echo $item->lab_test_name; ?></td>
        <td scope="col"><?php echo $item->lab_test_result; ?></td>
        <td scope="col"><?php echo $item->section_name; ?></td>
        <td scope="col"><?php echo $item->hours_since_requested; ?></td>
        <td scope="col"><?php echo $item->minutes_since_requested; ?></td>
        <td scope="col"><?php echo $item->requested_date; ?></td>
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
    $('#reset').click(function () {
      window.location = '/report-order-tat.php'
    })
  });
</script>