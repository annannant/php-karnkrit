<style>
  <?php include 'assets/styles/signin.css'; ?>
</style>
<div class="d-flex align-items-center py-4 bg-body-tertiary h-100">
  <main class="form-signin w-100 m-auto">
    <form action="/patients.php">
      <h1 class="h3 mb-3 fw-normal">Sign in</h1>
      <div class="form-floating">
        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>
      <button class="btn btn-primary w-100 py-2 mt-4" type="submit" >Sign in</button>
    </form>
  </main>
</div>