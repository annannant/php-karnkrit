<?php

include ('config/db.php');


$search = '';
$sql = 'SELECT * FROM users 
INNER JOIN section ON users.section_id = section.section_id
ORDER BY user_id DESC;';

if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $sql = "SELECT * FROM users 
  INNER JOIN section ON users.section_id = section.section_id
  WHERE first_name LIKE '%". $search ."%' OR 
  last_name LIKE '%". $search ."%' OR
  user_id LIKE '%". $search ."%'
  ORDER BY user_id DESC;";
}

$users = [];
$result = $conn->query($sql);
if ($conn->error) {
  echo $conn->error;
}

if ($result->num_rows > 0) {
    while ($data = $result->fetch_object()) {
        $users[] = $data;
    }
}

?>

<h1>Users</h1>

<!-- START: FORM SEARCH -->
<form class="row g-3" method="get" action="users.php">
  <div class="col-auto">
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i>
      </span>
      <input type="text" class="form-control" name="search" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1"
        style="width:720px;"
        value="<?php echo $search ?>">
    </div>
  </div>
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3">Search</button>
  </div>
</form>
<!-- END: FORM SEARCH -->
<hr />

<p></p>

<p></p>
<div class="w-full d-flex justify-content-between">
  <h3>Patient List</h3>
  <a href="/users-info.php" class="btn btn-primary " role="button" aria-disabled="true">Create User</a>
</div>

<p></p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">User ID</th>
      <th scope="col">User Name</th>
      <th scope="col">Job Title</th>
      <th scope="col">Status</th>
      <th scope="col">Created Date</th>
      <th scope="col">Last Login</th>
      <th scope="col">Section</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  <!-- $users = []; -->
  <?php foreach ($users as $user) { ?>
    <tr>
      <td scope="col"><?php echo $user->user_id; ?></td>
      <td scope="col"><?php echo $user->user_name; ?></td>
      <td scope="col"><?php echo $user->job_title; ?></td>
      <td scope="col"><?php echo $user->status == 1 ? 'Active' : 'Inactive' ; ?></td>
      <td scope="col"><?php echo $user->create_date; ?></td>
      <td scope="col"><?php echo $user->last_login_date; ?></td>
      <td scope="col"><?php echo $user->section_id; ?> - <?php echo $user->section_name; ?></td>
      <td scope="col">
        <a href="/users-info.php?user_id=<?php echo $user->user_id; ?>" class="btn btn-default btn-sm" role="button" aria-disabled="true">Edit</a>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>