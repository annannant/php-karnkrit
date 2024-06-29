<?php

include ('config/db.php');


// START : FOR SELECT REPORT
$sql = 'SELECT order_test.lab_order_ln, order_test.requested_date, section.section_name, specimen.specimen_name , count(order_test.lab_order_ln) as "total_order"
FROM 
  order_test 
  JOIN lab_test on order_test.lab_test_test_id = lab_test.test_id
  JOIN specimen on lab_test.specimen_id = specimen.specimen_id
  JOIN section on lab_test.section_id = section.section_id  ';

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

$sectionID = "";
if (!empty($_GET['sectionID'])) {
  $sectionID = $_GET['sectionID'];
  $sql .= strpos($sql, 'WHERE') > 0 ? ' AND' : ' WHERE';
  $sql .= " section.section_id = " . $sectionID;
}

$specimenID = "";
if (!empty($_GET['specimenID'])) {
  $specimenID = $_GET['specimenID'];
  $sql .= strpos($sql, 'WHERE') > 0 ? ' AND' : ' WHERE';
  $sql .= " specimen.specimen_id = " . $specimenID;
}

$sql .= "
GROUP by 
order_test.lab_order_ln,
order_test.requested_date,
  section.section_name,
  specimen.specimen_name  
ORDER BY `order_test`.`lab_order_ln` ASC;";

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


// START : SELECT SECTION
$sqlSection = 'SELECT * FROM section ORDER BY section_id DESC;';
$sections = [];
$result = $conn->query($sqlSection);
if ($conn->error) {
  echo $conn->error;
}
if ($result->num_rows > 0) {
  while ($data = $result->fetch_object()) {
    $sections[] = $data;
  }
}
// END : SELECT SECTION
// ---------------------------------------------


// START : SELECT SPECIMEN
$sqlSpecimen = 'SELECT * FROM specimen ORDER BY specimen_id DESC;';
$specimens = [];
$result = $conn->query($sqlSpecimen);
if ($conn->error) {
  echo $conn->error;
}
if ($result->num_rows > 0) {
  while ($data = $result->fetch_object()) {
    $specimens[] = $data;
  }
}
// END : SELECT specimen
// ---------------------------------------------

?>

<h1>Report - Orders by Section</h1>

<!-- START: FORM SEARCH -->
<form class="row g-3" method="get" action="report-order-by-section.php">
  <div class="col-full">
    <div class="row">
      <div class="col-3">
        <label for="sectionID" class="form-label">Section</label>
        <div>
          <select id="sectionID" name="sectionID" class="form-select" aria-label="Default select example">
            <option value="" selected>All</option>
            <?php foreach ($sections as $section) { ?>
              <option value="<?php echo $section->section_id; ?>" <?php echo $section->section_id === $sectionID ? 'selected' : '' ?>>
                <?php echo $section->section_name; ?>
              </option>
            <?php } ?>
          </select>
        </div>
      </div>
      <div class="col-3">
        <label for="specimenID" class="form-label">Specimen</label>
        <div>
          <select id="specimenID" name="specimenID" class="form-select" aria-label="Default select example">
            <option value="" selected>All</option>
            <?php foreach ($specimens as $specimen) { ?>
              <option value="<?php echo $specimen->specimen_id; ?>" <?php echo $specimen->specimen_id === $specimenID ? 'selected' : '' ?>>
                <?php echo $specimen->specimen_name; ?>
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
        <a href="report-order-by-section.php" class="btn btn-light mb-3">Reset</a>
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
  <h3>Orders by Section</h3>
  <!-- <a href="/report-order-by-section.php" class="btn btn-primary " role="button" aria-disabled="true">Create Patient</a> -->
</div>

<p></p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">LN</th>
      <th scope="col">Section Name</th>
      <th scope="col">Specimen Name</th>
      <th scope="col">Total</th>
      <th scope="col">Requested Date</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <!-- $list = []; -->
    <?php foreach ($list as $item) { ?>
      <tr>
        <td scope="col"><?php echo $item->lab_order_ln; ?></td>
        <td scope="col"><?php echo $item->section_name; ?></td>
        <td scope="col"><?php echo $item->specimen_name; ?></td>
        <td scope="col"><?php echo $item->total_order; ?></td>
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
      window.location = '/report-order-by-section.php'
    })
  });
</script>