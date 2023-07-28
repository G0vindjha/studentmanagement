<?php
// Admin Login 
session_id("adminLoginSession");
session_start();
require_once 'lib/Conn.php';
//Ajax call for verification
if ($_POST['action'] == 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rememberMe = $_POST['rememberMe'];
    $conn = new Conn();
    $result = $conn->select('admin','username,password');
    foreach ($result as $row) {
        if ($row['username'] == $username && $row['password'] == $password) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['password'] = $row['password'];
            if($rememberMe == 1){
                setcookie('username', $username, time() + (86400 * 30), "/");
                setcookie('password', $password, time() + (86400 * 30), "/");
            }
            echo 'success';
            exit;
        } else {
            echo "failed";
            exit;
        }
    }
}

$title = "Admin Login";
require_once 'lib/header.php';
?>
<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <div class="logo d-flex align-items-center w-auto">
                                <img src="/employeemanagement/admin/assets/img/logo.png" alt="">
                                <span class="d-none d-lg-block">LiveWire</span>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Admin Login</h5>
                                </div>
                                <form class="row g-3 needs-validation" method="post" novalidate>
                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">username : </label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="text" name="username" class="form-control" placeholder="Enter Your Username..." id="username" value="<?php echo $_COOKIE['username']; ?>" required>
                                            <div class="invalid-feedback">Please enter your username.</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <input type="password" name="password" id='password' class="form-control" id="password" placeholder="Enter Your Password..." value="<?php echo $_COOKIE['password']; ?>" required>
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
                                        <button class="btn-validation btn btn-primary w-100" type="button" id="adminLogin">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<script src="/employeemanagement/admin/assets/js/script.js"></script>
<?php
require_once 'lib/footer.php';
?>