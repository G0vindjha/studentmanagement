<?php
session_id("userLoginSession");
session_start();
if (!isset($_SESSION['userEmail'])) {
    header('Location:index.php');
    exit;
}
require_once 'admin/lib/Conn.php';
//Fetch all the States form database
if ($_POST['action'] == 'statedata') {
    $conn = new Conn();
    $result = $conn->select('state', '*', null, null, "`country_Id` = " . $_POST['value'] . "");
    echo json_encode($result);
    exit;
}
//Fetch all the City form database
if ($_POST['action'] == 'citydata') {
    $conn = new Conn();
    $result = $conn->select('city', '*', null, null, "`state_Id` = " . $_POST['value'] . "");
    echo json_encode($result);
    exit;
}
//Update Employee data form database
if (isset($_POST['submit']) && isset($_SESSION['emp_Id'])) {
    $data = array(
        ":emp_Id" => array(
            "value" => $_SESSION['emp_Id'],
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
    } else {
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
                        "emp_Id" => $_SESSION['emp_Id']
                    );
                    $conn = new Conn();
                    $result = $conn->update('employee', $dataArr, 'emp_Id = :emp_Id', $data);
                    if ($result == true) {
                        $uploadDirectory = __DIR__ . '/admin/assets/img/upload/' . $_SESSION['emp_Id'] . '/';
                        if (file_exists($uploadDirectory)) {
                            $previousImagePath = $uploadDirectory . $pp;
                            unlink($previousImagePath);
                        }
                        $imagePath = $uploadDirectory . $profile_Pic;
                        move_uploaded_file($_FILES['profile_Pic']['tmp_name'], $imagePath);
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
                            window.location.href = 'userDetail.php';
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
                "emp_Id" => $_SESSION['emp_Id']
            );
            $conn = new Conn();
            $result = $conn->update('employee', $dataArr, 'emp_Id = :emp_Id', $data);
            if ($result == true) {
                $pop = "<script>
                Swal.fire(
                    'Details Changed Successfully!!',
                    '',
                    'success'
                  )
                  var delay = 2000;
                  setTimeout(function () {
                    window.location.href = 'userDetail.php';
                  }, delay);
                  </script>";
            }
        }
    }
}
//Fetch Employee data form database
$data = array(
    ":emp_Id" => array(
        "value" => $_SESSION['emp_Id'],
        "type" => 'INT'
    ),
);
$conn = new Conn();
$result = $conn->select('employee', ('emp_Id,name,password,gender,email,street_address,city,city_Name,state,country,`state_Name`,postcode,`country_Name`,`phone_Number`,birth_Date,`profile_Pic`,`register_Date`,status'), 'LEFT JOIN', array('country' => array("country" => "country_Id"), 'state' => array("state" => "state_Id"), 'city' => array("city" => "city_Id")), 'emp_id = :emp_Id', $data, null, 'emp_Id', 'ASC');
$title = 'Home Page';
require_once './navbar.php';
require_once './sidebar.php';

$leftProfile = "<div class='card'>
                <div class='card-body profile-card pt-4 d-flex flex-column align-items-center'>
                    <img src='/employeemanagement/admin/assets/img/upload/" . $result[0]['emp_Id'] . "/" . $result[0]['profile_Pic'] . "' alt='Profile' class='rounded-circle w-50'>
                    <h2 class='mt-3'>" . $result[0]['name'] . "</h2>
                </div>
            </div>
";
echo $pop;
?>
<div class='col-9 mt-5 py-5 mx-auto' style="margin-bottom: 25vh;">
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <?php echo $leftProfile; ?>
            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Personal Details</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $result[0]['name']; ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Gender</div>
                                    <div class="col-lg-9 col-md-8"><?php if ($result[0]['gender'] == 'M') {
                                                                        echo 'Male';
                                                                    } else {
                                                                        echo 'Female';
                                                                    } ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Date Of Birth</div>
                                    <div class="col-lg-9 col-md-8"><?php echo date('d-m-Y', strtotime($result[0]['birth_Date'])); ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">E-mail</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $result[0]['email'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Contact</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $result[0]['phone_Number'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $result[0]['street_address'] ?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">City</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $result[0]['city_Name'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">State</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $result[0]['state_Name'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Country</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $result[0]['country_Name'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Post Code</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $result[0]['postcode'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Register Date</div>
                                    <div class="col-lg-9 col-md-8"><?php echo $result[0]['register_Date'] ?></div>
                                </div>

                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <form class="row g-3 needs-validation" novalidate method="post" enctype="multipart/form-data">
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col">
                                            <label for="name" class="form-label">Full Name : </label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name..." value="<?php echo $result[0]['name'] ?>" required>
                                            <div class="invalid-feedback">Enter Name...</div>
                                        </div>
                                        <div class="col">
                                            <label for="profile_Pic" class="form-label">Upload Profile Photo : </label>
                                            <input type="file" class="form-control" aria-label="file example" id="profile_Pic" name="profile_Pic" value="<?php echo $result[0]['profile_Pic'] ?>" <?php if (!isset($_SESSION['emp_Id'])) {
                                                                                                                                                                                                        echo 'required';
                                                                                                                                                                                                    } ?>>
                                            <input type="hidden" class="form-control" aria-label="file example" id="profile_Pic_filled" name="profile_Pic_filled" value="<?php echo $result[0]['profile_Pic'] ?>">
                                            <div class="invalid-feedback">Upload Profile photo...</div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col">
                                            <label for="email" class="form-label">Email : </label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email..." value="<?php echo $result[0]['email'] ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" aria-describedby="inputGroupPrepend" required>
                                                <div class="invalid-feedback">
                                                    Enter email...
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="password" class="form-label">Password : </label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password..." value="<?php echo $result[0]['password'] ?>" required>
                                            <div class="invalid-feedback">Choose password...</div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col">
                                            <label for="validationCustom01" class="form-label">Date of birth : </label>
                                            <input type="date" class="form-control" id="birth_Date" name="birth_Date" value="<?php echo $result[0]['birth_Date'] ?>" required>
                                            <div class="invalid-feedback">Enter date of birth...</div>
                                            <div id='validbirth_Date'></div>
                                            <?php echo $validBirthDate; ?>
                                        </div>
                                        <div class="col">
                                            <label for="birth_Date" class="form-label">Phone Number : </label>
                                            <input type="text" class="form-control" id="phone_Number" name="phone_Number" placeholder="Enter Phone Number..." value="<?php echo $result[0]['phone_Number'] ?>" required>
                                            <div class="invalid-feedback">Enter Phone Number...</div>
                                            <div id='validphone_Number'></div>
                                            <?php echo $validPhoneNumber; ?>
                                        </div>
                                    </div>
                                    <div class="gender fs-5">
                                        <label for="gender" class="form-label">Gender : </label>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="genderM" value="M" name="gender" <?php if ($result[0]['gender'] == "M") {
                                                                                                                                    echo "checked";
                                                                                                                                } ?> required>
                                            <label class="form-check-label" for="genderM">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="genderF" value="F" name="gender" <?php if ($result[0]['gender'] == "F") {
                                                                                                                                    echo "checked";
                                                                                                                                } ?> required>
                                            <label class="form-check-label" for="genderF">Female</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" id="genderO" value="O" name="gender" <?php if ($result[0]['gender'] == "O") {
                                                                                                                                    echo "checked";
                                                                                                                                } ?> required>
                                            <label class="form-check-label" for="genderO">Others</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="street_Address" class="form-label">Street Address : </label>
                                        <textarea class="form-control" id="street_Address" placeholder="Enter Address..." name="street_Address" required><?php echo $result[0]['street_address'] ?></textarea>
                                        <div class="invalid-feedback">
                                            Enter Address...
                                        </div>
                                    </div>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col">
                                            <label for="country" class="form-label">Country : </label>
                                            <select class="form-select" id="country" name="country" required>
                                                <?php
                                                $conn = new Conn();
                                                $result1 = $conn->select('country');
                                                foreach ($result1 as $key => $value) {
                                                    if (isset($_SESSION['emp_Id']) && $result[0]['country'] == $value['country_Id']) {
                                                        echo "<option value='" . $value['country_Id'] . "' selected>" . $value['country_Name'] . "</option>";
                                                    } else {
                                                        echo "<option value='" . $value['country_Id'] . "'>" . $value['country_Name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid Country.
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="state" class="form-label">State : </label>
                                            <select class="form-select" id="state" name="state" required>
                                                <?php
                                                $data = array(
                                                    ":country" => array(
                                                        "value" => $result[0]['country'],
                                                        "type" => 'INT'
                                                    ),
                                                );
                                                $conn2 = new Conn();
                                                $result3 = $conn2->select('state', "*", null, null, 'country_Id = :country', $data);
                                                foreach ($result3 as $key => $value) {
                                                    
                                                    if (isset($_SESSION['emp_Id']) && $result[0]['state'] == $value['state_Id']) {
                                                        echo "<option value='" . $value['state_Id'] . "' selected>" . $value['state_Name'] . "</option>";
                                                    } else {
                                                        echo "<option value='" . $value['state_Id'] . "'>" . $value['state_Name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid state.
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="city" class="form-label">City : </label>
                                            <select class="form-select" id="city" name="city" required>
                                                <?php
                                                $data = array(
                                                    ":state" => array(
                                                        "value" => $result[0]['state'],
                                                        "type" => 'INT'
                                                    ),
                                                );
                                                $conn1 = new Conn();
                                                $result2 = $conn1->select('city', "*", null, null, 'state_Id = :state', $data);
                                                foreach ($result2 as $key => $value) {
                                                    
                                                    if (isset($_SESSION['emp_Id']) && $result[0]['city'] == $value['city_Id']) {
                                                        echo "<option value='" . $value['city_Id'] . "' selected>" . $value['city_Name'] . "</option>";
                                                    } else {
                                                        echo "<option value='" . $value['city_Id'] . "'>" . $value['city_Name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please select a valid City.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center align-items-center g-2">
                                        <div class="col">
                                            <label for="postcode" class="form-label">Postcode : </label>
                                            <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Enter Postcode..." value="<?php echo $result[0]['postcode'] ?>" required>
                                            <div class="invalid-feedback">Enter Postcode...</div>
                                            <div id='validpostcode'></div>
                                            <?php echo $validPostCode; ?>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 col-12">
                                        <button class="btn btn-success p-2 col-5 mx-auto" id='submit' type="submit" name="submit">Update Details</button>
                                        <button class="btn btn-danger p-2 col-5 mx-auto" type="reset">Reset form</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="/employeemanagement/admin/assets/js/script.js"></script>
<?php
echo $script;
require_once './admin/lib/footer.php';
?>