<?php
session_id("adminLoginSession");
session_start();
if ($_POST['action'] == 'adminLogout') {
  session_unset();
  session_destroy();
  echo "logout";
  exit;
}
if(!isset($_SESSION['username'])){
header("Location:index.php");
exit;
}
require_once 'lib/Conn.php';
// Fetch value of last 3 employees
$conn = new Conn();
$result = $conn->select('employee', ('emp_Id,name,gender,email,street_address,city_Name,`state_Name`,postcode,`country_Name`,`phone_Number`,birth_Date,`profile_Pic`,`register_Date`,status'), 'LEFT JOIN', array('country' => array("country" => "country_Id"), 'state' => array("state" => "state_Id"), 'city' => array("city" => "city_Id")), null, null,null ,'emp_Id', 'DESC', 3);
$title = "Admin Dashboard";
require_once 'lib/header.php';
require_once 'lib/navbar.php';
require_once 'lib/sidebar.php';
?>
<div class="col-10">
    <div class="container">
        <main class='position-relative my-3'>
            <div class="row d-flex gap-1">
                <div class="col d-flex align-items-center border border-secondary shadow p-3 mb-5 bg-body rounded">
                    <div class="col-6">
                        <div class="illustration-text p-3 m-1">
                            <h4 class="illustration-text">Welcome Back, Admin!</h4>
                            <p class="mb-0">LiveWire Dashboard</p>
                        </div>
                    </div>
                    <div class="col-6 align-self-end text-end">
                        <img src="/employeemanagement/admin/assets/img/customer-support.png" alt="Customer Support" class="img-fluid illustration-img">
                    </div>
                </div>
            </div>
            <div class="row g-2 justify-content-center gap-5 shadow p-3 mb-5 bg-body rounded">
                <span class="display-6 text-center">::: Recent Added Employees :::</span><br>
                <?php
                //Create table for last 3 inserted employees
                foreach ($result as $value) {
                    $birth_Date = date("d-m-Y", strtotime($value['birth_Date']));
                    $register_Date =date("d-m-Y H:i:s",strtotime($value['register_Date']));
                    $imgpath = '/employeemanagement/admin/assets/img/upload/' . $value['emp_Id'] . '/'.$value['profile_Pic'];
                    if($value['gender']=="M"){
                        $gender = 'Male';
                    } 
                    if($value['gender']=="F"){
                        $gender = 'Female';
                    } 
                    echo " <div class='card col-3 shadow p-3 mb-5 bg-body rounded'>
                        <img src='$imgpath' class='card-img-top' alt='...'>
                        <div class='card-body'>
                            <h5 class='card-title'>" . $value['name'] . "</h5>
                            <p class='card-text'><small class='text-muted'>" . $value['email'] . "</small><br><small class='text-muted'>$gender</small></p>
                        </div>
                        <ul class='list-group list-group-flush'>
                            <li class='list-group-item'>Phone Number :  " . $value['phone_Number'] . "</li>
                            <li class='list-group-item'> DOB : $birth_Date </li>
                            <li class='list-group-item'>Register Date: $register_Date</li>
                            <li class='list-group-item'>Address : ".$value['street_address']."<br> City :".$value['city_Name']."<br> State : ".$value['state_Name']."<br> Country : ".$value['country_Name']."<br> Postcode : ".$value['postcode']."</li>
                        </ul>
                    </div>";
                }
                ?>
            </div>
        </main>
    </div>
</div>
<script src="/employeemanagement/admin/assets/js/script.js"></script>
<?php
require_once 'lib/footer.php';
?>