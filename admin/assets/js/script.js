//Bootstrap Validation
(function () {
  'use strict'

  var forms = document.querySelectorAll('.needs-validation')

  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)
    })
})()
$(document).ready(function () {
  //validation Added
  $("#submit").click((e) => {
    var valid = true;
    if ($.isNumeric($("#phone_Number").val()) == false) {
      e.preventDefault();
      $("#validphone_Number").html("<small class='text-danger'>Please Enter valid Phone Number!!!!</small>");
      valid = false;
    }
    if ($.isNumeric($("#postcode").val()) == false) {
      e.preventDefault();
      $("#validpostcode").html("<small class='text-danger'>Please Enter valid Postcode!!!!</small>");
      valid = false;
    }
    var dob = $("#birth_Date").val().split('-')
    var now = new Date();
    if (dob[2] > now.getDate() && dob[1] >= (now.getMonth() + 1) && dob[0] >= now.getFullYear()) {
      e.preventDefault();
      $("#validbirth_Date").html("<small class='text-danger'>Please Enter Valid Date Of Birth!!!!</small>");
      valid = false;
    }
    return valid;
  })

  //get State
  $("#country").on('click', function () {
    $.ajax({
      type: "post",
      data: {
        'action': 'statedata',
        'value': $('#country :selected').val()
      },
      success: function (response) {
        $data = jQuery.parseJSON(response);
        $("#state").html('<option selected value="0">-Select-</option>');
        $("#city").html('<option selected value="0">-Select-</option>');
        for (var i of $data) {
          $("#state").append("<option value='" + i.state_Id + "'>" + i.state_Name + "</option>");
        }
      }
    });
  });
  //get city
  $("#state").on('click', function () {
    $.ajax({
      type: "post",
      data: {
        'action': 'citydata',
        'value': $('#state :selected').val()
      },
      success: function (response) {
        $data = jQuery.parseJSON(response);
        $("#city").html('<option selected value="">-Select-</option>');
        for (var i of $data) {
          $("#city").append("<option value='" + i.city_Id + "'>" + i.city_Name + "</option>");
        }
      }
    });
  });
  //delete User
  $(document).on('click', ".del", function () {
    Swal.fire({
      title: 'Do you want to delete this employee\'s data?',
      showDenyButton: true,
      confirmButtonText: 'Yes',
      denyButtonText: `No`,
    }).then((result) => {
      var delay = 2000;
      if (result.isConfirmed) {
        Swal.fire('Saved!', '', 'success')
        $.ajax({
          type: "post",
          data: {
            "action": "deletedata",
            "value": this.id.slice(3)
          },
          success: function (response) {
            setTimeout(function () {
              window.location.href = 'employeeList.php';
            }, delay);

          }
        });
      } else if (result.isDenied) {
        Swal.fire('Employee data is not deletd!!', '', 'info')
      }
    })
  });
  //Status Update
  $(document).on('click', '.sts', function () {
    console.log($(this).data('empid'))
    if ($(this).is(":checked")) {
      var status = 1;
    } else {
      var status = 0;
    }
    $.ajax({
      type: "post",
      data: {
        'action': 'updateStatus',
        'statusValue': status,
        'emp_Id': $(this).data('empid')
      },
      success: function (response) {
        if (response == 1) {
          Swal.fire(
            'Status Changed Successfully!!',
            '',
            'success'
          )
        }
      }
    });
  });
  //search user
  $("#searchValue").keyup(function () {
    var searchValue = $("#searchValue").val();
    if (searchValue != "") {
      $.ajax({
        type: "post",
        data: {
          'action': 'searchData',
          'value': searchValue
        },
        success: function (response) {
          $('#tbody').html(response);
        }
      });
    }
  });

  // Admin Login Ajax
  $("#adminLogin").click(() => {
    var username = $("#username").val();
    var password = $("#password").val();
    if ($('#rememberMe').is(":checked")) {
      var rememberMe = 1;
    } else {
      var rememberMe = 0;
    }
    console.log(rememberMe);
    $.ajax({
      type: "post",
      data: {
        "action": 'login',
        'username': username,
        'password': password,
        'rememberMe': rememberMe
      },
      success: function (response) {
        if (response == 'success') {
          window.location.href = 'dashboard.php';
        }
        else {
          $('#alert').html('<span class="text-danger">Invalid Username or Password</span>');
        }
      }
    });
  });

  // Admin Logout Ajax
  $("#adminLogout").click(() => {
    $.ajax({
      type: "post",
      data: {
        "action": 'adminLogout'
      },
      success: function (response) {
        if (response == 'logout') {
          window.location.href = 'index.php';
        }
      }
    });
  });

  //User Login Ajax
  $("#userLogin").click(() => {
    if ($('#rememberMe').is(":checked")) {
      var rememberMe = 1;
    } else {
      var rememberMe = 0;
    }
    $.ajax({
      type: "post",
      data: {
        "action": 'userLogin',
        "email": $("#email").val(),
        "password": $("#password").val(),
        "rememberMe": rememberMe
      },
      success: function (response) {
        if (response == 'success') {
          window.location.href = 'index.php';
        }
        else {
          console.log(response)
          $('#alert').html('<span class="text-danger">Invalid Username or Password</span>');
        }
      }
    });
  });
  //User Logout Ajax
  $("#userLogout").click(() => {
    $.ajax({
      type: "post",
      data: {
        "action": 'userLogout'
      },
      success: function (response) {
        console.log(response);
        if (response == 'logout') {
          window.location.href = 'index.php';
        }
      }
    });
  });
});





