<?php
include ('./config/db.php');
include ('./config/datetime.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    <?php echo $title; ?>
  </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body>
  <style>
    <?php include 'assets/styles/main.css'; ?>
  </style>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <?php $uri = $_SERVER['REQUEST_URI']; ?>
  <?php
  function getActiveUrl()
  {
    $uri = $_SERVER['REQUEST_URI'];
    switch (true) {
      case strpos($uri, 'report-test-consumption-by-patient-rights') > 0:
        return 'report-test-consumption-by-patient-rights';
      case strpos($uri, 'report-test-consumption') > 0:
        return 'report-test-consumption';
      case strpos($uri, 'patients') > 0:
        return 'patients';
      case strpos($uri, 'patient-rights') > 0:
        return 'patient-rights';
      case strpos($uri, 'visits') > 0:
        return 'visits';
      case strpos($uri, 'lab-orders') > 0:
        return 'lab-orders';
      case strpos($uri, 'tests') > 0:
        return 'tests';
      case strpos($uri, 'specimens') > 0:
        return 'specimens';
      case strpos($uri, 'containers') > 0:
        return 'containers';
      case strpos($uri, 'sections') > 0:
        return 'sections';
      case strpos($uri, 'users') > 0:
        return 'users';
      case strpos($uri, 'report-order-by-section') > 0:
          return 'report-order-by-section';
      case strpos($uri, 'report-paitent-result-abnormal') > 0:
              return 'report-paitent-result-abnormal';
      default:
        return '';
    }
  }

  // echo getActiveUrl();
  ?>
  <main class="d-flex flex-nowrap">
    <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 230px;">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi pe-none me-2" width="40" height="32">
          <use xlink:href="#bootstrap"></use>
        </svg>
        <span class="fs-4">Laboratory</span>
      </a>
      <hr>
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a href="patients.php" class="nav-link
            <?php echo getActiveUrl() === 'patients' ? "active" : "link-body-emphasis"; ?>" aria-current="page">
            <!-- <i class="bi bi-pentagon me-2"></i> -->
            Patients
          </a>
        </li>
        <li class="nav-item">
          <a href="patient-rights.php" class="nav-link
            <?php echo getActiveUrl() === 'patient-rights' ? "active" : "link-body-emphasis"; ?>" aria-current="page">
            <!-- <i class="bi bi-pentagon me-2"></i> -->
            Patient Rights
          </a>
        </li>
        <!-- <li>
          <a href="visits.php" class="nav-link 
          <?php echo getActiveUrl() === 'visits' ? "active" : "link-body-emphasis"; ?>"
          >
            Visits
          </a>
        </li> -->
        <li>
          <a href="lab-orders.php" class="nav-link 
          <?php echo getActiveUrl() === 'lab-orders' ? "active" : "link-body-emphasis"; ?>">
            <!-- <i class="bi bi-pentagon me-2"></i> -->
            Lab Orders
          </a>
        </li>
        <li>
          <a href="tests.php" class="nav-link 
          <?php echo getActiveUrl() === 'tests' ? "active" : "link-body-emphasis"; ?>">
            <!-- <i class="bi bi-pentagon me-2"></i> -->
            Tests
          </a>
        </li>
        <li>
          <a href="specimens.php" class="nav-link 
          <?php echo getActiveUrl() === 'specimens' ? "active" : "link-body-emphasis"; ?>">
            <!-- <i class="bi bi-pentagon me-2"></i> -->
            Specimens
          </a>
        </li>
        <li>
          <a href="containers.php" class="nav-link 
          <?php echo getActiveUrl() === 'containers' ? "active" : "link-body-emphasis"; ?>">
            <!-- <i class="bi bi-pentagon me-2"></i> -->
            Containers
          </a>
        </li>
        <li>
          <a href="sections.php" class="nav-link 
          <?php echo getActiveUrl() === 'sections' ? "active" : "link-body-emphasis"; ?>">
            <!-- <i class="bi bi-pentagon me-2"></i> -->
            Sections
          </a>
        </li>
        <li>
          <a href="users.php" class="nav-link 
          <?php echo getActiveUrl() === 'users' ? "active" : "link-body-emphasis"; ?>">
            <!-- <i class="bi bi-pentagon me-2"></i> -->
            Users
          </a>
        </li>
      </ul>
      <hr>
      <div style="margin-bottom:10px">Report</div>
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a href="report-test-consumption.php" class="nav-link
            <?php echo getActiveUrl() === 'report-test-consumption' ? "active" : "link-body-emphasis"; ?>"
            aria-current="page">
            <!-- <i class="bi bi-pentagon me-2"></i> -->
            Test Consumption
          </a>
        </li>
        <li class="nav-item">
          <a href="report-test-consumption-by-patient-rights.php"
            class="nav-link
            <?php echo getActiveUrl() === 'report-test-consumption-by-patient-rights' ? "active" : "link-body-emphasis"; ?>" aria-current="page">
            Test Consumption by Patient Rights
          </a>
        </li>
        <li class="nav-item">
          <a href="report-order-by-section.php"
            class="nav-link
            <?php echo getActiveUrl() === 'report-order-by-section' ? "active" : "link-body-emphasis"; ?>" aria-current="page">
            Orders by Section
          </a>
        </li>
        <li class="nav-item">
          <a href="report-paitent-result-abnormal.php"
            class="nav-link
            <?php echo getActiveUrl() === 'report-paitent-result-abnormal' ? "active" : "link-body-emphasis"; ?>" aria-current="page">
            Patient Abnormal Result
          </a>
        </li>
      </ul>
      <hr>

      <div>
        <a href="logout.php" class="nav-link link-body-emphasis">
          Log out
        </a>
      </div>
    </div>
    <div class="content">
      <div class="content-wrapper card ">
        <?php include ($child); ?>
      </div>
    </div>
  </main>
</body>

</html>