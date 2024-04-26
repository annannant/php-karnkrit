<?php

include ('config/db.php');

// START : SEARCH - LAB ORDERS
$search = '';
$sql = 'SELECT * FROM order_test
  INNER JOIN lab_order ON order_test.lab_order_ln = lab_order.ln
  INNER JOIN patient ON lab_order.pid = patient.pid  
  INNER JOIN lab_test ON order_test.lab_test_test_id = lab_test.test_id
  INNER JOIN section ON lab_test.section_id = section.section_id
  WHERE lab_order.ln IS NOT NULL';

if (!empty($_GET['search'])) {
  $search = $_GET['search'];
  $sql .= " AND (lab_order.ln LIKE '%" . $search . "%'
  OR patient.pid LIKE '%" . $search . "%'
  OR patient.first_name LIKE '%" . $search . "%'
  OR patient.last_name LIKE '%" . $search . "%'
  OR lab_order.vn LIKE '%" . $search . "%'
  OR section.section_name LIKE '%" . $search . "%')";
}

$sectionID = "";
if (!empty($_GET['sectionID'])) {
  $sectionID = $_GET['sectionID'];
  $sql .= " AND section.section_id = " . $sectionID;
}

$createDate = "";
if (!empty($_GET['createDate'])) {
  $createDate = $_GET['createDate'];
  $sql .= " AND order_test.requested_date between '" . $createDate . "' and NOW()";
}

$sql .= ' ORDER BY ln DESC;';
// echo $sql;

$orderLests = [];
$result = $conn->query($sql);
if ($conn->error) {
  echo $conn->error;
}

if ($result->num_rows > 0) {
  while ($data = $result->fetch_object()) {
    $orderLests[] = $data;
  }
}
// END : SEARCH - LAB ORDERS

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


?>

<h1>Lab Orders</h1>

<!-- START: FORM SEARCH -->
<form class="row g-3" method="get" action="lab-orders.php">
  <div class="col-full">
    <div class="row column-gap-3 row-gap-3">
      <div class="col-full">
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i>
          </span>
          <input type="text" class="form-control" name="search" placeholder="Search By LN, HN, VN or Section Name"
            aria-label="Search" aria-describedby="basic-addon1" style="width:720px;" value="<?php echo $search ?>">
        </div>
      </div>
    </div>
    <div class="row column-gap-3 row-gap-3">
      <div class="col">
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
      <div class="col">
        <label for="createDate" class="form-label">Create Date</label>
        <input type="input" readonly class="form-control " name="createDate" id="createDate" placeholder="" value="<?php echo $createDate; ?>">
      </div>
      <div class="row ">
        <div class="col-full d-flex justify-content-end w-full column-gap-3 row-gap-3">
          <a href="lab-orders.php" class="btn btn-light mb-3">Reset</a>
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
  <h3>Lab Order List</h3>
  <a href="/lab-orders-info.php" class="btn btn-primary " role="button" aria-disabled="true">Create Lab Order</a>
</div>

<p></p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Lab Number</th>
      <th scope="col">HN / Name</th>
      <th scope="col">Section</th>
      <th scope="col">Create Date/Time</th>
      <th scope="col">Complete Date/Time</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    <!-- $patients = []; -->
    <?php foreach ($orderLests as $orderLest) { ?>
      <tr>
        <td scope="col"><?php echo $orderLest->ln; ?></td>
        <td scope="col"><?php echo $orderLest->pid; ?> - <?php echo $orderLest->first_name; ?> <?php echo $orderLest->last_name; ?></td>
        <td scope="col"><?php echo $orderLest->section_name; ?></td>
        <td scope="col"><?php echo $orderLest->requested_date; ?></td>
        <td scope="col"><?php echo $orderLest->completed_date; ?></td>
        <td scope="col">
          <a href="/patients-info.php?pid=<?php echo $orderLest->pid; ?>" class="btn btn-default btn-sm" role="button"
            aria-disabled="true">Edit</a>
        </td>
      </tr>
    <?php } ?>

  </tbody>
</table>

<script type="text/javascript">
  $(document).ready(function () {
    $('#createDate').datepicker({
      dateFormat: "yy-mm-dd",
      todayHighlight: true,
      autoclose: true,
    });
    // $('#sectionID').change(function(){
    //   var sectionID = $(this).val();
    //   console.log('sectionID:', sectionID)
    //   window.location = '/lab-orders.php?sectionID=' + sectionID + '&search=<?php echo $search ?>';
    // })
    $('#reset').click(function(){
      window.location = '/lab-orders.php'
    })
  });
</script>