<?php 
include ('./config/db.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
  $sql = 'SELECT *  FROM users WHERE user_name = "' . $_POST['username'] . '" AND user_pass = "' . $_POST['password'] . '";';
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $data = $result->fetch_object();
    $_SESSION['user'] = $data->user_id;
    ?>
    <script type="text/javascript">
      window.location = "/patients.php";
    </script>
  <?php } else {
    $_POST = array();
    ?>
    <script type="text/javascript">
      alert('Username or password is incorrect');
    </script>
  <?php }
}

?>
<style>
  <?php include 'assets/styles/signin.css'; ?>
</style>
<div class="d-flex align-items-center py-4 bg-body-tertiary h-100">
  <main class="form-signin w-100 m-auto">
    <form method="post" action="/login.php">
      <h1 class="h3 mb-3 fw-normal">Sign in</h1>
      <div class="form-floating">
        <input type="text" class="form-control" name="username" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Username</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>
      <button class="btn btn-primary w-100 py-2 mt-4" type="submit">Sign in</button>
    </form>
  </main>
</div>