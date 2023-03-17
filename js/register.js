function load() {
  $.ajax({
    type: 'GET',
    url: './php/register.php',
    success: function (response) {},
  });
}

$(document).ready(function () {
  $('form').submit(function (e) {
    e.preventDefault();
    var name = $('#name').val();
    var email = $('#email').val();
    var age = $('#age').val();
    var dob = $('#dob').val();
    var mobile = $('#mobile').val();
    var password = $('#password').val();
   
    // console.log(name + "   "+ email+"  "+ age+'  '+dob+"   "+mobile+"   "+password+"   "+confirmPassword);
    $.ajax({
      type: 'POST',
      url: './php/register.php',
      data: {
        name: name,
        email: email,
        age: age,
        dob: dob,
        mobile: mobile,
        password: password,
      },
      success: function (response) {
        if (response.includes('inserted success')) {
          alert('Registration successful you can now login');
          window.location.href = './login.html';
        } else {
          alert('Registration Failed : ', response);
        }
      },
      error: function (xhr, status, error) {
        alert('Registration Failed : ', error);
      },
    });
  });
});
