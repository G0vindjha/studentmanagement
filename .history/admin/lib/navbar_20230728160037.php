<!-- Header For Admin Which Contain  Login and Logout button -->
<header id="header" class="header fixed-top d-flex align-items-center position-relative">
  <div class="col-2">
    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="/studentmanagement/admin/assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Admin</span>
      </a>
    </div>
  </div>
  <div class="col-4">
    <div class="pagetitle mt-4">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="col">
    <img src="/studentmanagement/admin/assets/img/companyLogo.png" alt="..." width="200px">
  </div>
  <div class="col d-flex justify-content-end">
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>
        <li class="nav-item dropdown pe-3 d-flex gap-2">
          <span class="d-none d-md-block ps-2">Welcome</span>
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2">Admin</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <button type="button" class="dropdown-item d-flex align-items-center" id="adminLogout">Sign Out</button>
            </li>

          </ul>
        </li>

      </ul>
    </nav>
  </div>

</header>