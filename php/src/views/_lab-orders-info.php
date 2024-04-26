<?php

$pid = "";
$patients = [];
$sql = $sql = "SELECT * FROM patient ORDER BY pid DESC;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while ($data = $result->fetch_object()) {
    $patients[] = $data;
  }
}

$vn = "";
$visits = [];
if ($pid !== "") {
  $sql = $sql = "SELECT * FROM visit WHERE pid = '" . $search . "' ORDER BY visit_date DESC;";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($data = $result->fetch_object()) {
      $visits[] = $data;
    }
  }
}

$isEdit = false;
$ln = "";
if (isset($_GET['ln'])) {
  $ln = $_GET['ln'];
  $isEdit = true;
} else {
  $sql = "SELECT MAX(ln) + 1 as latest_ln FROM lab_order LIMIT 1;";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $data = $result->fetch_object();
    $ln = $data->latest_ln;
  }
}


$info = new stdClass();
$info->pid = "";
$info->vn = "";




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
              aria-label="Default select example">
              <option <?php echo $info->pid === '' ? 'selected' : '' ?>>Please Select</option>
              <?php foreach ($patients as $patient) { ?>
                <option value="<?php echo $patient->pid; ?>" <?php echo $info->pid === $patient->pid ? 'selected' : '' ?>>
                  <?php echo $patient->pid; ?> - <?php echo $patient->first_name; ?>   <?php echo $patient->last_name; ?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-full">
          <label for="vn" class="form-label">Visit Number (VN)</label>
          <div>
            <select id="vn" name="vn" disabled class="js-example-basic-multiple js-states form-control"
              aria-label="Default select example">
              <option <?php echo $info->vn === '' ? 'selected' : '' ?>>Please Select</option>
              <?php foreach ($visits as $visit) { ?>
                <option value="<?php echo $visit->vn; ?>" <?php echo $info->vn === $visit->vn ? 'selected' : '' ?>>
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
                <th scope="col" width="35%">Test ID / Test Name</th>
                <th scope="col">Ref Range</th>
                <th scope="col">Specimen</th>
                <!-- <th scope="col">Result</th>
                <th scope="col" width="11%">Create Date/Time</th>
                <th scope="col" width="11%">Complete Date/Time</th> -->
              </tr>
            </thead>
            <tbody>
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
          var sel = `<select id="test${rowCount}" 
              name="test[${rowCount}]" 
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
          sel += `<input type="hidden" name="testName[${rowCount}]" id="testName${rowCount}" value="">`;
          // console.log('sel:', sel)
          $('#myTable').find('tbody').append(function (params) {
            return `
                <tr>
                  <td id="tdTestId${rowCount}">${sel}</td>
                  <td id="tdRef${rowCount}"></td>
                  <td id="tdSpecimen${rowCount}"></td>
                  // <td id="tdResult${rowCount}"></td>
                  // <td id="tdCreatDate${rowCount}"></td>
                  // <td id="tdCompleteDate${rowCount}"></td>
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
            $('#testName' + rowId).val(data?.element?.dataset?.name);
          });
        }
      });
    });
  });
</script>