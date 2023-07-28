<?php
session_id("userLoginSession");
session_start();
//Script for hiding login button
if (isset($_SESSION['userEmail'])) {
  $script =  "<script>
  $('#nav').show();
  $('#loginnav').hide();
  </script>";
} else {
  $script = "<script>
  $('#nav').hide();
  $('#loginnav').show();
  </script>";
}
require_once 'admin/lib/Conn.php';
//User login 
if ($_POST['action'] == 'userLogin') {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $rememberMe = $_POST['rememberMe'];
  $conn = new Conn();
  $result = $conn->select('employee', 'emp_Id,name,email,password');
  foreach ($result as $row) {

    if ($row['email'] == $email && $row['password'] == $password) {
      $_SESSION['emp_Id'] = $row['emp_Id'];
      $_SESSION['userName'] = $row['name'];
      $_SESSION['userEmail'] = $row['email'];
      $_SESSION['userPass'] = $row['password'];
      if ($rememberMe == 1) {
        setcookie('userEmail', $email, time() + (86400 * 30), "/");
        setcookie('userPass', $password, time() + (86400 * 30), "/");
      }
      echo 'success';
      exit;
    }
  }
  echo "failed";
  exit;
}
// User Logout
if ($_POST['action'] == 'userLogout') {
  session_unset();
  session_destroy();
  echo "logout";
  exit;
}
$title = "LiveWire";
require_once 'admin/lib/header.php';
?>
<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="col">
    <img src="/admin/assets/img/companyLogo.png" alt="..." width="200px">
  </div>
  <div class="col d-flex justify-content-end">

    <div class="d-flex justify-content-end me-5">
      <button type="button" class="btn btn-outline-primary px-4" id="loginnav" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</button>
    </div>
    <nav id="nav" class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>

        <li class="nav-item dropdown pe-3 d-flex gap-2">
          <span class="d-none d-md-block ps-2">Welcome</span>
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['userName']; ?></span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li>
              <a class="dropdown-item d-flex align-items-center" href="./userDetail.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <button type="button" class="dropdown-item d-flex align-items-center" id="userLogout">Sign Out</button>
            </li>

          </ul>
        </li>

      </ul>
    </nav>
  </div>
</header>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex justify-content-center py-4">
          <div class="logo d-flex align-items-center w-auto">
            <img src="/admin/assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">LiveWire</span>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <section class="section register d-flex flex-column align-items-center justify-content-center py-4">
          <div class="container">
            <div class="row justify-content-center">
              <div class="d-flex flex-column align-items-center justify-content-center">
                <div class="card mb-3">
                  <div class="card-body">
                    <div class="pt-4 pb-2">
                      <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                    </div>
                    <form class="row g-3 needs-validation" novalidate method="post">
                      <div class="col-12">
                        <label for="yourUsername" class="form-label">Email : </label>
                        <div class="input-group has-validation">
                          <span class="input-group-text" id="inputGroupPrepend">@</span>
                          <input type="email" name="email" class="form-control" placeholder="Enter Your Email..." pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="email" value="<?php echo $_COOKIE['userEmail']; ?>" required>
                          <div class="invalid-feedback">Please enter your username.</div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label for="yourPassword" class="form-label">Password</label>
                        <input type="password" name="password" id='password' class="form-control" id="password" placeholder="Enter Your Password..." value="<?php echo $_COOKIE['userPass']; ?>" required>
                        <div class="invalid-feedback">Please enter your password!</div>
                      </div>

                      <div class="col-12">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                          <label class="form-check-label" for="rememberMe">Remember me</label>
                        </div>
                      </div>
                      <div class="col-12" id="alert"></div>
                      <div class="col-12">
                        <button class="btn-validation btn btn-primary w-100" type="button" id="userLogin">Login</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </section>
      </div>
    </div>
  </div>
</div>
</div>