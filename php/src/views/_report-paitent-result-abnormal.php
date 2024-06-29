<?php

include ('config/db.php');

// START : FOR SELECT REPORT
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
  lab_order.ln IN (
    SELECT 
      ln
    FROM 
      (
        SELECT 
          lab_order.ln, 
          COUNT(*) AS positive_count 
        FROM 
          lab_order 
          JOIN order_test ON lab_order.ln = order_test.lab_order_ln ';

$dateFrom = "";
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

$sql .= strpos($sql, 'WHERE') > 0 ? ' AND' : ' WHERE';
$sql .= " order_test.lab_test_result IN ('Positive', 'POS', 'Pos') 
GROUP BY 
          lab_order.ln
        HAVING 
          positive_count > 0
      ) AS total_abnormal
  ) 
ORDER BY 
  order_test.lab_order_ln;
";
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
// END : FOR SELECT REPORT
// ---------------------------------------------
?>

<h1>Report - Patient Abnormal Result</h1>

<!-- START: FORM SEARCH -->
<form class="row g-3" method="get" action="report-paitent-result-abnormal.php">
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
      window.location = '/report-paitent-result-abnormal.php'
    })
  });
</script>