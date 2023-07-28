<?php
session_id("adminLoginSession");
session_start();
// Admin Logout
if ($_POST['action'] == 'adminLogout') {
    session_unset();
    session_destroy();
    echo "logout";
    exit;
}
if (!isset($_SESSION['username'])) {
    header("Location:index.php");
    exit;
}

require_once 'lib/Conn.php';
//Delete employee
if ($_POST['action'] == 'deletedata') {
    $emp_Id = $_POST['value'];
    $conn = new Conn();
    $data = array(
        ":emp_Id" => array(
            "value" => $emp_Id,
            "type" => 'INT'
        ),
    );
    $conn->delete('employee', "emp_Id = :emp_Id", $data);
    exit;
}
//Update stattus of employee
if ($_POST['action'] == 'updateStatus') {
    $dataArr = array(
        'status' => $_POST['statusValue'],
        'emp_Id' => $_POST['emp_Id']
    );
    $conn = new Conn();
    $result = $conn->update('employee', $dataArr, 'emp_Id = :emp_Id');
    echo $result;
    exit;
}
//Search Data from the table
if ($_POST['action'] == 'searchData') {
    $search = $_POST['value'];
    $conn = new Conn();
    $result = $conn->select('employee', ('emp_Id,name,gender,email,street_address,city_Name,`state_Name`,postcode,`country_Name`,`phone_Number`,birth_Date,`profile_Pic`,`register_Date`,status'), 'LEFT JOIN', array('country' => array("country" => "country_Id"), 'state' => array("state" => "state_Id"), 'city' => array("city" => "city_Id")), null, null, null, 'emp_Id', 'ASC');
    $srno = 0;
    $new = array_filter($result, function ($value) use ($search, &$srno) {
        $output = '';
        if (strpos(strtolower($value['name']), strtolower($search)) !== FALSE || strpos(strtolower($value['email']), strtolower($search)) !== FALSE || strpos(strtolower($value['country_Name']), strtolower($search)) !== FALSE || strpos(strtolower($value['state_Name']), strtolower($search)) !== FALSE || strpos(strtolower($value['city_Name']), strtolower($search)) !== FALSE || strpos(strtolower($value['phone_Number']), strtolower($search)) !== FALSE) {
            $srno++;
            $birth_Date = date("d-m-Y", strtotime($value['birth_Date']));
            $register_Date = date("d-m-Y H:i:s", strtotime($value['register_Date']));
            $imgpath = '/employeemanagement/admin/assets/img/upload/' . $value['emp_Id'] . '/' . $value['profile_Pic'];
            if ($value['gender'] == "M") {
                $gender = 'Male';
            }
            if ($value['gender'] == "F") {
                $gender = 'Female';
            }
            if ($value['status'] == '1') {
                $status = '<div class="form-check form-switch">
            <input class="form-check-input sts" type="checkbox" data-empid="' . $value['emp_Id'] . '" role="switch" id="sts' . $value['emp_Id'] . '" checked>
          </div>';
            } else {
                $status = '<div class="form-check form-switch">
            <input class="form-check-input sts" type="checkbox" data-empid="' . $value['emp_Id'] . '" role="switch" id="sts' . $value['emp_Id'] . '">
          </div>';
            }
            $action = "<div class='row d-flex flex-nowrap'>
        <div class='col'><a href='/employeemanagement/admin/addEmployeeHtml.php?emp_Id="  . $value['emp_Id'] . "' type='button' id='udp"  . $value['emp_Id'] . "' class='udp btn btn-success upd'>UPDATE</a></div>
        <div class='col'><button type='button' id='del" . $value['emp_Id'] . "' class='del btn btn-danger del'>DELETE</button></div>";

            $output .= "<tr>
                        <td class='text-center'>$srno.</td>
                        <td class='text-center'><img src='$imgpath' class='card-img-top w-25' alt='...'></td>
                        <td>Name: " . $value['name'] . "<br> Gender : " . $gender . "<br> Email : " . $value['email'] . "<br>Contact : " . $value['phone_Number'] . "<br> DOB : " . $birth_Date . "</td>
                        <td>" . $value['street_address'] . "<br> City : " . $value['city_Name'] . "<br> State : " . $value['state_Name'] . "<br> Country : " . $value['country_Name'] . "<br> Postcode : " . $value['postcode'] . "</td>
                        <td>$register_Date</td>
                        <td>$status</td>
                        <td>$action</td>
                    </tr>";
        }
        echo $output;
    });

    exit;
}
//Employees table
$conn = new Conn();
$result = $conn->select('employee', ('emp_Id,name,gender,email,street_address,city_Name,`state_Name`,postcode,`country_Name`,`phone_Number`,birth_Date,`profile_Pic`,`register_Date`,status'), 'LEFT JOIN', array('country' => array("country" => "country_Id"), 'state' => array("state" => "state_Id"), 'city' => array("city" => "city_Id")), null, null, null, 'emp_Id', 'ASC');
$title = "Employee List";
require_once 'lib/header.php';
require_once 'lib/navbar.php';
require_once 'lib/sidebar.php';


if (count($result) == 0) {
    $output =  "<span class='display-6 text-danger'>Record Not Found!!</span>";
} else {
    $output = '';
    $srno = 1;
    foreach ($result as $value) {
        $birth_Date = date("d-m-Y", strtotime($value['birth_Date']));
        $register_Date = date("d-m-Y H:i:s", strtotime($value['register_Date']));
        $imgpath = '/employeemanagement/admin/assets/img/upload/' . $value['emp_Id'] . '/' . $value['profile_Pic'];
        if ($value['gender'] == "M") {
            $gender = 'Male';
        }
        if ($value['gender'] == "F") {
            $gender = 'Female';
        }
        if ($value['status'] == '1') {
            $status = '<div class="form-check form-switch">
            <input class="form-check-input sts" type="checkbox" data-empid="' . $value['emp_Id'] . '" role="switch" id="sts' . $value['emp_Id'] . '" checked>
          </div>';
        } else {
            $status = '<div class="form-check form-switch">
            <input class="form-check-input sts" type="checkbox" data-empid="' . $value['emp_Id'] . '" role="switch" id="sts' . $value['emp_Id'] . '">
          </div>';
        }
        $action = "<div class='row d-flex flex-nowrap'>
        <div class='col'><a href='/employeemanagement/admin/addEmployeeHtml.php?emp_Id="  . $value['emp_Id'] . "' type='button' id='udp"  . $value['emp_Id'] . "' class='udp btn btn-success upd'>UPDATE</a></div>
        <div class='col'><button type='button' id='del" . $value['emp_Id'] . "' class='del btn btn-danger del'>DELETE</button></div>";

        $output .= "<tr>
                        <td class='text-center'>$srno.</td>
                        <td class='text-center'><img src='$imgpath' class='card-img-top w-25' alt='...'></td>
                        <td>Name: " . $value['name'] . "<br> Gender : " . $gender . "<br> Email : " . $value['email'] . "<br>Contact : " . $value['phone_Number'] . "<br> DOB : " . $birth_Date . "</td>
                        <td>" . $value['street_address'] . "<br> City : " . $value['city_Name'] . "<br> State : " . $value['state_Name'] . "<br> Country : " . $value['country_Name'] . "<br> Postcode : " . $value['postcode'] . "</td>
                        <td>$register_Date</td>
                        <td>$status</td>
                        <td>$action</td>
                    </tr>";
        $srno++;
    }
}
?>
<div class="col-10">
    <div class="container-fluid">
        <main class='position-relative my-3'>
            <div class="row d-flex justify-content-between mb-3">
                <form class="d-flex col-4" role="search">
                    <input class="form-control me-2" type="search" id="searchValue" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" id="search" type="button">Search</button>
                </form>
                <div class="col-4 d-flex justify-content-end">
                    <a class="btn btn-outline-success" href="/employeemanagement/admin/addEmployeeHtml.php" role="button">Add Employee</a>
                </div>
                <table class="table table-striped table-bordered mt-3">
                    <thead>
                        <tr class="text-center">
                            <th>SR NO.</th>
                            <th>PROFILE PHOTO</th>
                            <th>EMPLOYEE DETAILS</th>
                            <th>ADDRESS DETAILS</th>
                            <th>REGISTER DATE</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php echo $output; ?>
                    </tbody>
                </table>
        </main>
    </div>
</div>
<script src="/employeemanagement/admin/assets/js/script.js"></script>
<?php
require_once 'lib/footer.php';
?>