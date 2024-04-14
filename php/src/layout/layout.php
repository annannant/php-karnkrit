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
</head>

<body>
  <style>
    <?php include 'assets/styles/main.css'; ?>
  </style>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <?php  $uri = $_SERVER['REQUEST_URI']; ?>
  <main class="d-flex flex-nowrap">
    <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 230px;">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi pe-none me-2" width="40" height="32">
          <use xlink:href="#bootstrap"></use>
        </svg>
        <span class="fs-4">Laboratory</span>
      </a>
      <hr>
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a href="patients.php" class="nav-link
            <?php echo $uri === '/patients.php' ? "active" : "link-body-emphasis"; ?>"
            aria-current="page">
            <!-- <i class="bi bi-pentagon me-2"></i> -->
            Patients
          </a>
        </li>
        <li>
          <a href="visits.php" class="nav-link 
          <?php echo $uri === '/visits.php' ? "active" : "link-body-emphasis"; ?>"
          >
          <!-- <i class="bi bi-pentagon me-2"></i> -->
            Visits
          </a>
        </li>
        <li>
          <a href="lab-orders.php" class="nav-link 
          <?php echo $uri === '/lab-orders.php' ? "active" : "link-body-emphasis"; ?>"
          >
          <!-- <i class="bi bi-pentagon me-2"></i> -->
            Lab Orders
          </a>
        </li>
        <li>
          <a href="tests.php" class="nav-link 
          <?php echo $uri === '/tests.php' ? "active" : "link-body-emphasis"; ?>"
          >
          <!-- <i class="bi bi-pentagon me-2"></i> -->
            Tests
          </a>
        </li>
        <li>
          <a href="specimens.php" class="nav-link 
          <?php echo $uri === '/specimens.php' ? "active" : "link-body-emphasis"; ?>"
          >
          <!-- <i class="bi bi-pentagon me-2"></i> -->
            Specimens
          </a>
        </li>
        <li>
          <a href="containers.php" class="nav-link 
          <?php echo $uri === '/containers.php' ? "active" : "link-body-emphasis"; ?>"
          >
          <!-- <i class="bi bi-pentagon me-2"></i> -->
            Containers
          </a>
        </li>
        <li>
          <a href="sections.php" class="nav-link 
          <?php echo $uri === '/sections.php' ? "active" : "link-body-emphasis"; ?>"
          >
          <!-- <i class="bi bi-pentagon me-2"></i> -->
            Sections
          </a>
        </li>
        <li>
          <a href="users.php" class="nav-link 
          <?php echo $uri === '/users.php' ? "active" : "link-body-emphasis"; ?>"
          >
          <!-- <i class="bi bi-pentagon me-2"></i> -->
            Users
          </a>
        </li>
      </ul>
      <hr>
    </div>
    <div class="content">
      <div class="content-wrapper card ">
        <?php include ($child); ?>
      </div>
    </div>
  </main>
</body>

</html>