<?php

$pid = "";
$patients = [];
$sql = $sql = "SELECT * FROM patient ORDER BY pid ASC;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while ($data = $result->fetch_object()) {
    $patients[] = $data;
  }
}


$isEdit = false;
$ln = "";
$vn = "";
$info = new stdClass();
$orderTests = [];
$hasCompleted = false;
if (isset($_GET['ln'])) { // is edit
  $ln = $_GET['ln'];
  $isEdit = true;
  $sql = "SELECT * FROM lab_order WHERE ln = '" . $ln . "';";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $data = $result->fetch_object();
    $ln = $data->ln;
    $vn = $data->vn;
    $pid = $data->pid;
  }

  $sqlTest = "SELECT * FROM order_test 
  INNER JOIN lab_test ON order_test.lab_test_test_id = lab_test.test_id
  INNER JOIN specimen ON specimen.specimen_id = lab_test.specimen_id 
  WHERE lab_order_ln = '" . $ln . "' 
  ORDER BY order_test.requested_date ASC
  ;";
  $resultTest = $conn->query($sqlTest);
  if ($resultTest->num_rows > 0) {
    while ($data = $resultTest->fetch_object()) {
      $orderTests[] = $data;
    }
  }


  // find complated data
  foreach ($orderTests as $element) {
    if ($element->completed_date !== null) {
      $hasCompleted = true;
      break;
    }
  }
  // echo json_encode($orderTests);
} else {
  $sql = "SELECT MAX(ln) + 1 as latest_ln FROM lab_order LIMIT 1;";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $data = $result->fetch_object();
    $ln = $data->latest_ln;
  }
  if ($ln === null) {
    $ln = 6700001; // default ln
  }
}

$visits = [];
if ($pid !== "") {
  $sql = $sql = "SELECT * FROM visit WHERE pid = '" . $pid . "' ORDER BY visit_date DESC;";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($data = $result->fetch_object()) {
      $visits[] = $data;
    }
  }
}



$tests = [];
$sql = 'SELECT lab_test.*, section.section_name, specimen.specimen_name FROM lab_test 
INNER JOIN section ON section.section_id = lab_test.section_id 
INNER JOIN specimen ON specimen.specimen_id = lab_test.specimen_id 
ORDER BY test_id;';
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while ($data = $result->fetch_object()) {
    $tests[] = $data;
  }
}


?>

<p></p>
<h3>
  <?php echo ($isEdit) ? "Edit" : "Create"; ?> Lab Order
</h3>
<p></p>
<!-- START: FORM CREATE -->
<div class=" ">
  <form class="row" method="post" action="views/_lab-orders-post-update.php">
    <hr class="">
    </hr>
    <h5 style="color:grey;font-weight: normal;padding-left: 24px;">Lab Order Info</h5>
    <div class="container mx-auto" style="width:50%;">
      <div class="row column-gap-3 row-gap-3">
        <div class="col-full">
          <label for="ln" class="form-label">Lab Number</label>
          <input type="input" readonly class="form-control disabled" name="ln" placeholder="" value="<?php echo $ln ?>">
          <?php if ($isEdit) { ?>
            <input type="hidden" name="isEdit" value="true">
          <?php } ?>
        </div>
        <div class="col-full">
          <label for="pid" class="form-label">Patient ID (PID)</label>
          <div>
            <select id="pid" name="pid" class="js-example-basic-multiple js-states form-control"
              aria-label="Default select example" <?php echo $hasCompleted ? 'disabled' : '' ?>>
              <option <?php echo $pid === '' ? 'selected' : '' ?>>Please Select</option>
              <?php foreach ($patients as $patient) { ?>
                <option value="<?php echo $patient->pid; ?>" <?php echo $pid === $patient->pid ? 'selected' : '' ?>>
                  <?php echo $patient->pid; ?> - <?php echo $patient->first_name; ?>   <?php echo $patient->last_name; ?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-full">
          <label for="vn" class="form-label">Visit Number (VN)</label>
          <div>
            <select id="vn" name="vn" <?php echo $hasCompleted || !$isEdit ? "disabled" : '' ?>
             class="js-example-basic-multiple js-states form-control"
              aria-label="Default select example">
              <option <?php echo $vn === '' ? 'selected' : '' ?>>Please Select</option>
              <?php foreach ($visits as $visit) { ?>
                <option value="<?php echo $visit->vn; ?>" <?php echo $vn === $visit->vn ? 'selected' : '' ?>>
                  <?php echo $visit->vn; ?> - <?php echo $visit->visit_date; ?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
    </div>
    <hr class="mt-5">
    </hr>
    <h5 style="color:grey;font-weight: normal;padding-left: 24px;">Order Tests</h5>
    <div class="container mx-auto" style="width:100%;">
      <div class="row column-gap-3 row-gap-3">
        <div class="col-full">
          <table class="table table-striped" id="myTable">
            <thead>
              <tr>
                <th scope="col" width="20%">Test ID / Test Name</th>
                <th scope="col" width="10%">Ref Range</th>
                <th scope="col" width="11%">Specimen</th>
                <th scope="col" width="">Result</th>
                <th scope="col" width="12%">Created Date/Time</th>
                <th scope="col" width="12%">Completed Date/Time</th>
                <th scope="col" width="12%"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($orderTests as $key => $orderTest) { ?>
                <tr>
                  <td>
                    <select disabled id="updateTest<?php echo $key + 1; ?>" name="updateTest[<?php echo $key + 1; ?>]"
                      class="select-test-id js-example-basic-multiple js-states form-control"
                      aria-label="Default select example">
                      <option value="">Please Select</option>
                      <?php foreach ($tests as $test) { ?>
                        <option value="<?php echo $test->test_id; ?>" <?php echo $orderTest->lab_test_test_id === $test->test_id ? 'selected' : '' ?>>
                          <?php echo $test->test_id; ?> - <?php echo $test->test_name; ?>
                        </option>
                      <?php } ?>
                    </select>
                    <input type="hidden" name="updateTestId[<?php echo $key + 1; ?>]"
                      id="updateTestId<?php echo $key + 1; ?>" value="<?php echo $orderTest->lab_test_test_id ?>">
                  </td>
                  <td><?php echo $orderTest->ref_range ?></td>
                  <td><?php echo $orderTest->specimen_name ?></td>
                  <td>
                    <input type="text" class="form-control" 
                      <?php echo !empty($orderTest->completed_date) ? 'disabled' : '' ?>
                      name="updateResult[<?php echo $key + 1; ?>]" id="updateResult<?php echo $key + 1; ?>"
                      value="<?php echo $orderTest->lab_test_result ?>">
                  </td>
                  <td><?php echo empty($orderTest->requested_date) ? '-' : $orderTest->requested_date; ?></td>
                  <td>
                    <?php if (empty($orderTest->completed_date)) { ?>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="checked"
                          name="updateCompleted[<?php echo $key + 1 ?>]" id="updateCompleted<?php echo $key + 1 ?>">
                        <label class="form-check-label" for="updateCompleted<?php echo $key + 1 ?>">
                          Complete
                        </label>
                      </div>
                    <?php } else {
                      echo $orderTest->completed_date;
                    } ?>
                  </td>
                  <td id="deleteRecord<?php echo $key + 1; ?>">
                    <?php if ($orderTest->completed_date === null) { ?>
                      <button type="button" class="btn btn-danger btn-sm"
                        onclick="deleteRecord(<?php echo $key + 1; ?>, <?php echo $orderTest->lab_test_test_id ?>, <?php echo $orderTest->lab_order_ln ?>, )">Delete</button>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="col-full">
        </div>
      </div>
      <div class="row column-gap-3 row-gap-3">

        <div class="col d-flex align-items-end mt-2 justify-content-center">
          <button type="button" class="btn btn-light" id="addTest">+ Add Test</button>
        </div>
      </div>

    </div>
    <hr class="mt-5">
    </hr>
    <div class="container mx-auto" style="width:100%;">
      <div class="row column-gap-3 row-gap-3">
        <div class="col d-flex align-items-end mt-2 justify-content-end">
          <button type="submit" class="btn btn-primary ">Submit</button>
        </div>
      </div>
    </div>
  </form>
</div>
<p></p>
<p></p>

<!-- END: FORM CREATE -->
<script type="text/javascript">
  $(document).ready(function () {
    $('.js-example-basic-multiple').select2();
    $('.completeDate').datepicker({
      dateFormat: "yy-mm-dd",
      todayHighlight: true,
      autoclose: true,
    });
    $('#vn').select2();
    $('#pid').change(function () {
      $.ajax({
        url: "views/_ajax-option-vn.php?pid=" + $(this).val(),
        type: "GET",
        dataType: "json",
        success: function (data) {
          $('#vn').empty();
          $('#vn').prop('disabled', false);
          let optionHTML = `<option value="">Please Select</option>`;
          $('#vn').append(optionHTML);
          data.forEach(element => {
            let optionHTML = `
            <option value="${element.vn}"> 
                ${element.vn} - ${element.visit_date}
            </option>`;
            $('#vn').append(optionHTML);
          });
        }
      });
    });

    $('#addTest').click(function () {
      $.ajax({
        url: "views/_ajax-option-test.php",
        type: "GET",
        dataType: "json",
        success: function (data) {
          var rowCount = $('#myTable > tbody > tr').length + 1;
          var sel = `<select id="newTest${rowCount}" 
              name="newTest[${rowCount}]" 
              class="select-test-id js-example-basic-multiple js-states form-control"
              aria-label="Default select example">
              <option value="">Please Select</option>
              `
          data.forEach(element => {
            let optionHTML = `
            <option
              value="${element.test_id}"
              data-row-id="${rowCount}"
              data-select-id="testId${rowCount}"
              data-name="${element.test_name}"
              data-ref="${element.ref_range}"
              data-specimen="${element.specimen_name}">
                ${element.test_id} - ${element.test_name}
            </option>`;
            sel += optionHTML;
          });
          sel += "</select>";
          sel += `<input type="hidden" name="newTestName[${rowCount}]" id="newTestName${rowCount}" value="">`;
          var inp = '<input type="text" class="form-control" name="newResult[' + rowCount + ']" id="newResult' + rowCount + '">';
          // var completeDate = '<input type="text" class="form-control" name="completeDate[' + rowCount + ']" id="completeDate' + rowCount + '" readonly>';
          $('#myTable').find('tbody').append(function (params) {
            return `
                <tr>
                  <td id="tdTestId${rowCount}">${sel}</td>
                  <td id="tdRef${rowCount}"></td>
                  <td id="tdSpecimen${rowCount}"></td>
                  <td id="tdResult${rowCount}">${inp}</td>
                  <td id="tdCreatedDate${rowCount}">-</td>
                  <td id="tdCompletedDate${rowCount}">-</td>
                  <td id="delete${rowCount}">
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteRow(${rowCount})">Delete</button>
                  </td>
                </tr>
            `
          });
          $('.select-test-id').select2({
            datasource: data,
          });
          $('.select-test-id').on('select2:select', function (e) {
            var data = e.params.data;
            console.log('data:', data)
            console.log(data?.element?.dataset);
            let { rowId } = data?.element?.dataset;
            $('#tdRef' + rowId).text(data?.element?.dataset?.ref);
            $('#tdSpecimen' + rowId).text(data?.element?.dataset?.specimen);
            $('#newTestName' + rowId).val(data?.element?.dataset?.name);
          });
        }
      });
    });
  });

  function deleteRow(rowId) {
    var row = document.getElementById("delete" + rowId);
    row.parentNode.remove();
  }

  function deleteRecord(rowId, testId, ln) {
    // console.log('testId, ln:', testId, ln)
    var row = document.getElementById("deleteRecord" + rowId);
    row.parentNode.remove();
    $.ajax({
      url: "views/_ajax-delete-order-test.php",
      type: "GET",
      data: {
        ln: ln,
        testId: testId
      },
      dataType: "json",
      success: function (data) {
        console.log('data:', data)
      }
    });
  }

</script>