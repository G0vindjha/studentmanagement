<?php
//Fetch all the states of selected Country
if ($_POST['action'] == 'statedata') {
    $conn = new Conn();
    $result = $conn->select('state', '*', null, null, "`country_Id` = " . $_POST['value'] . "");
    echo json_encode($result);
    exit;
}
//Fetch all the Cities of selected States
if ($_POST['action'] == 'citydata') {
    $conn = new Conn();
    $result = $conn->select('city', '*', null, null, "`state_Id` = " . $_POST['value'] . "");
    echo json_encode($result);
    exit;
}
//Fetch all the data of Employess and send all the data to table
if (isset($_GET['emp_Id'])) {
    $title = "Update Employee";
    $conn = new Conn();
    $data = array(
        ":emp_Id" => array(
            "value" => $_GET['emp_Id'],
            "type" => 'INT'
        ),
    );
    $Result = $conn->select('employee', ('emp_Id,name,password,gender,email,street_address,city_Name,`state_Name`,postcode,country,state,city,`country_Name`,`phone_Number`,birth_Date,`profile_Pic`,`register_Date`,status'), 'LEFT JOIN', array('country' => array("country" => "country_Id"), 'state' => array("state" => "state_Id"), 'city' => array("city" => "city_Id")), "emp_Id = :emp_Id", $data,);
    $updateResult = $Result[0];
    $imgpath = '/employeemanagement/admin/assets/img/upload/' . $_GET['emp_Id'] . '/' . $updateResult['profile_Pic'];
    $imgfield = "<div class=' d-flex justify-content-center mb-3'><img src='$imgpath' class='card-img-top rounded-circle w-25' alt='...'></div>";
} else {
    $title = "Add Employee";
}
// Update the employee data
if (isset($_POST['submit']) && isset($_GET['emp_Id'])) {
    $data = array(
        ":emp_Id" => array(
            "value" => $_GET['emp_Id'],
            "type" => 'INT'
        ),
    );
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $birth_Date = $_POST['birth_Date'];
    $phone_Number = $_POST['phone_Number'];
    $gender = $_POST['gender'];
    $street_Address = $_POST['street_Address'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];
    $pp = $_POST['profile_Pic_filled'];
    if (array_key_exists("status", $_POST)) {
        $status = 1;
    } else {
        $status = 0;
    }
    $date = date('Y/m/d H:i:s');
    if ($name == null || $email == null || $password == null || $birth_Date == null || $phone_Number == null || $gender == null || $street_Address == null || $country == null || $state == null || $city == null || $postcode == null || is_numeric($phone_Number) == false || is_numeric($postcode) == false || strtotime($birth_Date) > strtotime(date("Y-m-d"))) {
        if (is_numeric($phone_Number) == false) {
            $validPhoneNumber =  "<div><small class='text-danger'>Check Phone Number Correctly!!</small></div>";
        }
        if (is_numeric($postcode) == false) {
            $validPostCode =  "<div><small class='text-danger'>Check Post code Correctly!!</small></div>";
        }
        if (strtotime($birth_Date) > strtotime(date("Y-m-d"))) {
            $validBirthDate =  "<div><small class='text-danger'>Check Birth Date Correctly!!</small></div>";
        }
    } else {
        // Update the employee data if img is uploaded
        if ($_FILES['profile_Pic']['size']) {
            $fileName = $_FILES['profile_Pic']['name'];
            $fileSize = $_FILES['profile_Pic']['size'];
            $tempName = $_FILES['profile_Pic']['tmp_name'];
            $fileType = $_FILES['profile_Pic']['type'];
            $fileExtension = end(explode('/', $fileType));
            $newFileName = time() . $fileName;
            $upload = "upload/$newFileName";
            if ($fileExtension == "jpeg" || $fileExtension == "png") {
                if ($fileSize >= 0 && $fileSize <= 1000000) {
                    $profile_Pic = $newFileName;
                    $dataArr = array(
                        "name" => $name,
                        "profile_Pic" => $profile_Pic,
                        "email" => $email,
                        "password" => $password,
                        "birth_Date" => $birth_Date,
                        "phone_Number" => $phone_Number,
                        "gender" => $gender,
                        "street_Address" => $street_Address,
                        "country" => $country,
                        "state" => $state,
                        "city" => $city,
                        "postcode" => $postcode,
                        "register_Date" => $date,
                        "status" => $status,
                        "emp_Id" => $_GET['emp_Id']
                    );
                    $conn = new Conn();
                    $result = $conn->update('employee', $dataArr, 'emp_Id = :emp_Id', $data);
                    if ($result == true) {
                        $uploadDirectory = __DIR__ . '/assets/img/upload/' . $_GET['emp_Id'] . '/';
                        if (file_exists($uploadDirectory)) {
                            $previousImagePath = $uploadDirectory.$pp;
                            unlink($previousImagePath);
                        }
                        $imagePath = $uploadDirectory . $profile_Pic;
                        move_uploaded_file($_FILES['profile_Pic']['tmp_name'], $imagePath);
                        $pop = "<script>
                        Swal.fire(
                            'Details Changed Successfully!!',
                            '',
                            'success'
                          )
                          var delay = 2000;
                          setTimeout(function () {
                            window.location.href = 'employeeList.php';
                          }, delay);
                          </script>";
                    } else {
                        echo " File Not uploaded!!";
                    }
                } else {
                    echo "File size is large please upload file upto 1 MB";
                    exit;
                }
            } else {
                echo  "jpeg Andpng allowed only";
                exit;
            }
        } else {
        // Update the employee data if img is not uploaded
            $dataArr = array(
                "name" => $name,
                "email" => $email,
                "password" => $password,
                "birth_Date" => $birth_Date,
                "phone_Number" => $phone_Number,
                "gender" => $gender,
                "street_Address" => $street_Address,
                "country" => $country,
                "state" => $state,
                "city" => $city,
                "postcode" => $postcode,
                "register_Date" => $date,
                "status" => $status,
                "emp_Id" => $_GET['emp_Id']
            );
            $conn = new Conn();
            $result = $conn->update('employee', $dataArr, 'emp_Id = :emp_Id');
            $pop = "<script>
                        Swal.fire(
                            'Details Changed Successfully!!',
                            '',
                            'success'
                          )
                          var delay = 2000;
                          setTimeout(function () {
                            window.location.href = 'employeeList.php';
                          }, delay);
                          </script>";
        }
    }
}
// Insert the new employee
if (isset($_POST['submit']) && !isset($_GET['emp_Id'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $birth_Date = $_POST['birth_Date'];
    $phone_Number = $_POST['phone_Number'];
    $gender = $_POST['gender'];
    $street_Address = $_POST['street_Address'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];

    if (array_key_exists("status", $_POST)) {
        $status = 1;
    } else {
        $status = 0;
    }
    $date = date('Y/m/d H:i:s');;
    if ($name == null || $email == null || $password == null || $birth_Date == null || $phone_Number == null || $gender == null || $street_Address == null || $country == null || $state == null || $city == null || $postcode == null || is_numeric($phone_Number) == false || is_numeric($postcode) == false || strtotime($birth_Date) > strtotime(date("Y-m-d"))) {
        if (is_numeric($phone_Number) == false) {
            $validPhoneNumber =  "<div><small class='text-danger'>Check Phone Number Correctly!!</small></div>";
        }
        if (is_numeric($postcode) == false) {
            $validPostCode =  "<div><small class='text-danger'>Check Post code Correctly!!</small></div>";
        }
        if (strtotime($birth_Date) > strtotime(date("Y-m-d"))) {
            $validBirthDate =  "<div><small class='text-danger'>Check Birth Date Correctly!!</small></div>";
        }
        $validate = "<div><small class='text-danger'>Check Birth Date Correctly!!</small></div>";
    } else {
        if (isset($_FILES['profile_Pic'])) {
            $fileName = $_FILES['profile_Pic']['name'];
            $fileSize = $_FILES['profile_Pic']['size'];
            $tempName = $_FILES['profile_Pic']['tmp_name'];
            $fileType = $_FILES['profile_Pic']['type'];
            $fileExtension = end(explode('/', $fileType));
            $newFileName = time() . $fileName;
            $profile_Pic = $newFileName;
            $upload = "upload/$newFileName";
            if ($fileExtension == "jpeg" || $fileExtension == "png") {
                if ($fileSize >= 0 && $fileSize <= 1000000) {
                    $dataArr = array(
                        "name" => $name,
                        "profile_Pic" => $profile_Pic,
                        "email" => $email,
                        "password" => $password,
                        "birth_Date" => $birth_Date,
                        "phone_Number" => $phone_Number,
                        "gender" => $gender,
                        "street_Address" => $street_Address,
                        "country" => $country,
                        "state" => $state,
                        "city" => $city,
                        "postcode" => $postcode,
                        "register_Date" => $date,
                        "status" => $status
                    );
                    $conn = new Conn();
                    $result = $conn->insert('employee', $dataArr);
                    if ($result == 'error') {
                        echo " File Not uploaded!!";
                    } else {
                        $uploadDirectory = __DIR__ . '/assets/img/upload/' . $result . '/';
                        echo $uploadDirectory . "<br>";
                        if (!file_exists($uploadDirectory)) {
                            mkdir($uploadDirectory, 0777, true);
                        }
                        $imagePath = $uploadDirectory . $profile_Pic;
                        echo $imagePath;
                        move_uploaded_file($_FILES['profile_Pic']['tmp_name'], $imagePath);
                        $pop = "<script>
                        Swal.fire(
                            'Employee Added Successfully!!',
                            '',
                            'success'
                          )
                          var delay = 2000;
                          setTimeout(function () {
                            window.location.href = 'employeeList.php';
                          }, delay);
                          </script>";
                    }
                } else {
                    echo "File size is large please upload file upto 1 MB";
                    exit;
                }
            } else {
                echo  "jpeg Andpng allowed only";
                exit;
            }
        }
    }
}
