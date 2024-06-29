<?php

include ('config/db.php');


$sql = 'SELECT 
  lab_order.ln, 
  patient.pid, 
  patient.first_name, 
  patient.last_name, 
  lab_test.test_name, 
  order_test.lab_test_result, 
  order_test.requested_date, 
  order_test.completed_date 
FROM 
  patient 
  JOIN lab_order ON patient.pid = lab_order.pid 
  JOIN order_test ON lab_order.ln = order_test.lab_order_ln 
  JOIN lab_test ON order_test.lab_test_test_id = lab_test.test_id 
WHERE 
  patient.pid IN (
    SELECT 
      pid 
    FROM 
      (
        SELECT 
          lab_order.pid, 
          COUNT(*) AS positive_count 
        FROM 
          lab_order 
          JOIN order_test ON lab_order.ln = order_test.lab_order_ln ';

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

$sql .= strpos($sql, 'WHERE') > 0 ? ' AND' : ' WHERE';
$sql .= " order_test.lab_test_result IN ('Positive', 'POS', 'Pos') 
GROUP BY 
          lab_order.pid 
        HAVING 
          positive_count > 0
      ) AS total_abnormal
  ) 
ORDER BY 
  patient.last_name, 
  patient.first_name, 
  lab_test.test_name;
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

<h1>Report - Patient Abnormal Result</h1>

<!-- START: FORM SEARCH -->
<form class="row g-3" method="get" action="report-paitent-result-abnormal.php">
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
        <a href="report-paitent-result-abnormal.php" class="btn btn-light mb-3">Reset</a>
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
  <h3>Patient Abnormal Result</h3>
</div>

<p></p>
<table class="table table-striped">
  <thead>
    <tr>
    <th scope="col">LN</th>
        <th scope="col">PID</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Test Name</th>
        <th scope="col">Lab Test Result</th>
        <th scope="col">Requested Date</th>
        <th scope="col">Completed Date</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <!-- $list = []; -->
    <?php foreach ($list as $item) { ?>
      <tr>
        <td scope="col"><?php echo $item->ln; ?></td>
        <td scope="col"><?php echo $item->pid; ?></td>
        <td scope="col"><?php echo $item->first_name; ?></td>
        <td scope="col"><?php echo $item->last_name; ?></td>
        <td scope="col"><?php echo $item->test_name; ?></td>
        <td scope="col"><?php echo $item->lab_test_result; ?></td>
        <td scope="col"><?php echo $item->requested_date; ?></td>
        <td scope="col"><?php echo $item->completed_date; ?></td>
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
      window.location = '/report-paitent-result-abnormal.php'
    })
  });
</script>