<?php

include ('config/db.php');


$sql = 'SELECT 
  order_test.lab_test_name as "test_name", 
  patient_rights.patient_rights_desc as "patient_rights", 
  count(order_test.lab_test_name) as "total_used" 
FROM 
  order_test 
  JOIN lab_order on order_test.lab_order_ln = lab_order.ln 
  JOIN visit on lab_order.vn = visit.vn 
  JOIN patient_rights on visit.patient_rights_ID = patient_rights.patient_rights_ID ';

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

$patientRightID = "";
if (!empty($_GET['patientRightID'])) {
  $patientRightID = $_GET['patientRightID'];
  $sql .= strpos($sql, 'WHERE') > 0 ? ' AND' : ' WHERE';
  $sql .= " patient_rights.patient_rights_ID = " . $patientRightID;
}

$sql .= " GROUP by 
  order_test.lab_test_name, 
  patient_rights.patient_rights_desc
  ORDER BY patient_rights.patient_rights_desc;";

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


// START : SELECT PATIENT RIGHT
$sqlPatientRight = 'SELECT * FROM `patient_rights` ORDER BY `patient_rights`.`patient_rights_desc` DESC';
$patientRights = [];
$result = $conn->query($sqlPatientRight);
if ($conn->error) {
  echo $conn->error;
}
if ($result->num_rows > 0) {
  while ($data = $result->fetch_object()) {
    $patientRights[] = $data;
  }
}
// END : SELECT PATIENT RIGHT

?>

<h1>Report - Test Consumption By Patient Rights</h1>

<!-- START: FORM SEARCH -->
<form class="row g-3" method="get" action="report-test-consumption-by-patient-rights.php">
  <div class="col-full">
    <div class="row">
      <div class="col-3">
        <label for="patientRightID" class="form-label">Patient Rights</label>
        <div>
          <select id="patientRightID" name="patientRightID" class="form-select" aria-label="Default select example">
            <option value="" selected>All</option>
            <?php foreach ($patientRights as $patientRight) { ?>
              <option value="<?php echo $patientRight->patient_rights_ID; ?>" <?php echo $patientRight->patient_rights_ID === $patientRightID ? 'selected' : '' ?>>
                <?php echo $patientRight->patient_rights_desc; ?>
              </option>
            <?php } ?>
          </select>
        </div>
      </div>
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
        <a href="report-test-consumption-by-patient-rights.php" class="btn btn-light mb-3">Reset</a>
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
  <!-- <a href="/report-test-consumption-by-patient-rights.php" class="btn btn-primary " role="button" aria-disabled="true">Create Patient</a> -->
</div>

<p></p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Test Name</th>
      <th scope="col">Patient Rights</th>
      <th scope="col">Total</th>
      <!-- <th scope="col">Container Name</th>
      <th scope="col">Test Count</th> -->
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <!-- $list = []; -->
    <?php foreach ($list as $item) { ?>
      <tr>
        <td scope="col"><?php echo $item->test_name; ?></td>
        <td scope="col"><?php echo $item->patient_rights; ?></td>
        <td scope="col"><?php echo $item->total_used; ?></td>
        <!-- <td scope="col"><?php echo $item->container_name; ?></td>
        <td scope="col"><?php echo $item->test_count; ?></td> -->
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
      window.location = '/report-test-consumption-by-patient-rights.php'
    })
  });
</script>