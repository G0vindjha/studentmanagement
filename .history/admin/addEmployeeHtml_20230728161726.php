<?php
session_id("adminLoginSession");
session_start();
if (!isset($_SESSION['username'])) {
  header("Location:index.php");
  exit;
}
require_once 'lib/Conn.php';
require "addEmployee.php";
require_once 'lib/header.php';
require_once 'lib/navbar.php';
require_once 'lib/sidebar.php';
echo $pop;
?>
<div class="col-10 mb-3">
  <!-- //create table of employees -->
  <div class="col-12 mt-3 d-flex justify-content-end pe-5">
    <a name="back" id="back" class="btn btn-primary me-5" href="/employeemanagement/admin/employeeList.php" role="button">BACK</a>
  </div>
  <div class="container mt-3 border border-primary border-3 p-3 rounded">
    <div class="d-flex justify-content-center mb-3"><span class="fs-2 text-primary">Employee Registration</span></div>
    <?php echo $imgfield; ?>
    <form class="row g-3 needs-validation" id="validater" novalidate method="post" enctype="multipart/form-data">
      <div class="row justify-content-center align-items-center g-2">
        <div class="col">
          <label for="name" class="form-label">Full Name : </label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name..." value="<?php echo $updateResult['name'] ?>" required>
          <div id="validname" class="invalid-feedback">Enter Name...</div>
        </div>
        <div class="col">
          <label for="profile_Pic" class="form-label">Upload Profile Photo : </label>
          <?php
          $required = "required";
          if (isset($_GET['emp_Id'])) {
            $required = "";
          }
          ?>
          <input type="file" class="form-control" aria-label="file example" id="profile_Pic" name="profile_Pic" <?php echo $required; ?>>
          <input type="hidden" class="form-control" aria-label="file example" id="profile_Pic_filled" name="profile_Pic_filled" value="<?php echo $updateResult['profile_Pic'] ?>">
          <div class="invalid-feedback">Upload Profile photo...</div>
        </div>
      </div>
      <div class="row justify-content-center align-items-center g-2">
        <div class="col">
          <label for="email" class="form-label">Email : </label>
          <div class="input-group has-validation">
            <span class="input-group-text" id="inputGroupPrepend">@</span>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email..." value="<?php echo $updateResult['email'] ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" aria-describedby="inputGroupPrepend" required>
            <div id="validemail" class="invalid-feedback">
              Enter email...
            </div>
          </div>
        </div>
        <div class="col">
          <label for="password" class="form-label">Password : </label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password..." value="<?php echo $updateResult['password'] ?>" required>
          <div id="validpassword" class="invalid-feedback">Choose password...</div>
        </div>
      </div>
      <div class="row justify-content-center align-items-center g-2">
        <div class="col">
          <label for="dob" class="form-label">Date of birth : </label>
          <input type="date" class="form-control" id="birth_Date" name="birth_Date" value="<?php echo $updateResult['birth_Date'] ?>" required>
          <div class="invalid-feedback">Enter date of birth...</div>
          <div id='validbirth_Date'></div>
          <?php echo $validBirthDate; ?>
        </div>
        <div class="col">
          <label for="phone_Number" class="form-label">Phone Number : </label>
          <input type="text" class="form-control" id="phone_Number" name="phone_Number" placeholder="Enter Phone Number..." value="<?php echo $updateResult['phone_Number'] ?>" required>
          <div class="invalid-feedback">Enter Phone Number...</div>
          <div id='validphone_Number'></div>
          <?php echo $validPhoneNumber; ?>
        </div>
      </div>
      <div class="gender fs-5">
        <label for="gender" class="form-label">Gender : </label>
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input" id="genderM" value="M" name="gender" <?php if ($updateResult['gender'] == "M") {
                                                                                              echo "checked";
                                                                                            } ?> required>
          <label class="form-check-label" for="genderM">Male</label>
        </div>
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input" id="genderF" value="F" name="gender" <?php if ($updateResult['gender'] == "F") {
                                                                                              echo "checked";
                                                                                            } ?> required>
          <label class="form-check-label" for="genderF">Female</label>
        </div>
        <div class="form-check form-check-inline">
          <input type="radio" class="form-check-input" id="genderO" value="O" name="gender" <?php if ($updateResult['gender'] == "O") {
                                                                                              echo "checked";
                                                                                            } ?> required>
          <label class="form-check-label" for="genderO">Others</label>
        </div>
      </div>
      <div class="mb-3">
        <label for="street_Address" class="form-label">Street Address : </label>
        <textarea class="form-control" id="street_Address" placeholder="Enter Address..." name="street_Address" required><?php echo $updateResult['street_address'] ?></textarea>
        <div id="validaddress" class="invalid-feedback">
          Enter Address...
        </div>
      </div>
      <div class="row justify-content-center align-items-center g-2">
        <div class="col">
          <label for="country" class="form-label">Country : </label>
          <select class="form-select" id="country" name="country" required>
            <option value="" selected disabled>-select</option>
            <?php
            // fetch the country value form the database
            $conn = new Conn();
            $result1 = $conn->select('country');
            foreach ($result1 as $key => $value) {
              if (isset($_GET['emp_Id']) && $updateResult['country'] == $value['country_Id']) {
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
            // fetch the state value form the database on update time
            $data = array(
              ":country" => array(
                "value" => $updateResult['country'],
                "type" => 'INT'
              ),
            );
            $conn2 = new Conn();
            $result3 = $conn2->select('state', "*", null, null, 'country_Id = :country', $data);
            foreach ($result3 as $key => $value) {

              if (isset($_GET['emp_Id']) && $updateResult['state'] == $value['state_Id']) {
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
            // fetch the city value form the database in update time
            $data = array(
              ":state" => array(
                "value" => $updateResult['state'],
                "type" => 'INT'
              ),
            );
            $conn1 = new Conn();
            $result2 = $conn1->select('city', "*", null, null, 'state_Id = :state', $data);
            foreach ($result2 as $key => $value) {

              if (isset($_GET['emp_Id']) && $updateResult['city'] == $value['city_Id']) {
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
          <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Enter Postcode..." value="<?php echo $updateResult['postcode'] ?>" required>
          <div class="invalid-feedback">Enter Postcode...</div>
          <div id='validpostcode'></div>
          <?php echo $validPostCode; ?>
        </div>
        <div class="col">
          <div class="form-check form-switch d-flex align-self-center align-items-center justify-content-center mt-4 fs-4">
            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" <?php if (isset($_GET['emp_Id'])) {
                                                                                                      if ($updateResult['status'] == 1) {
                                                                                                        echo 'checked';
                                                                                                      }
                                                                                                    } else {
                                                                                                      echo 'checked';
                                                                                                    } ?>>
            <label class="form-check-label ms-2" for="status">Status</label>
          </div>
        </div>
      </div>
      <div class="d-flex gap-2 col-12">
        <button class="btn-validation btn btn-success p-2 col-5 mx-auto" id='submit' type="submit" name="submit">Submit form</button>
        <button class="btn btn-danger p-2 col-5 mx-auto" type="reset">Reset form</button>
        <?php echo "<br>" . $valid; ?>
      </div>
      <?php echo "<br>" . $validate; ?>
    </form>
  </div>
</div>

<script src="/employeemanagement/admin/assets/js/script.js"></script>
<?php
require_once 'lib/footer.php';
?>