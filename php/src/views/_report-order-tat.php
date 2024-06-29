<?php

include ('config/db.php');

// START : FOR SELECT REPORT
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

$dateFrom = "";
$dateTo = "";
if (!empty($_GET['dateFrom']) && !empty($_GET['dateTo'])) {
  $dateFrom = $_GET['dateFrom'];
  $dateTo = $_GET['dateTo'];
  $sql .= strpos($sql, 'WHERE') > 0 ? ' AND' : ' WHERE';
  $sql .= " order_test.requested_date BETWEEN '" . $dateFrom . " 00:00:00' AND '" . $dateTo . " 23:59:59'";
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

<h1>Report - TAT Incomplete Orders </h1>

<!-- START: FORM SEARCH -->
<form class="row g-3" method="get" action="report-order-tat.php">
  <div class="col-full">
    <div class="row">
      <div class="col-2">
        <label for="dateFrom" class="form-label">Requested Date From</label>
        <input type="input" readonly class="form-control " name="dateFrom" id="dateFrom" placeholder=""
          value="<?php echo $dateFrom; ?>">
      </div>
      <div class="col-2">
        <label for="dateTo" class="form-label">Requested Date To</label>
        <input type="input" readonly class="form-control " name="dateTo" id="dateTo" placeholder=""
          value="<?php echo $dateTo; ?>">
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
  <h3>TAT Incomplete Orders </h3>
</div>

<p></p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">LN</th>
      <th scope="col">Test Name</th>
      <th scope="col">Test Result</th>
      <th scope="col">Section Name</th>
      <th scope="col">Hours Since Requested</th>
      <th scope="col">Minutes Since Requested</th>
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
    $('#dateFrom').datepicker({
      dateFormat: "yy-mm-dd",
      todayHighlight: true,
      autoclose: true,
    });
    $('#dateTo').datepicker({
      dateFormat: "yy-mm-dd",
      todayHighlight: true,
      autoclose: true,
    });
    $('#reset').click(function () {
      window.location = '/report-order-tat.php'
    })
  });
</script>