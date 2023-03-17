function load() {
  $.ajax({
    type: 'GET',
    url: './php/register.php',
    success: function (response) {
      if (response.includes('session is on')) {
        window.location.href = './profile.html';
      }
    },
  });
}

$(document).ready(function () {
  $('form').submit(function (e) {
    e.preventDefault();
    var email = $('#email').val();
    var password = $('#password').val();
    $.ajax({
      type: 'POST',
      url: './php/login.php',
      data: {
        email: email,
        password: password,
      },
      success: function (response) {
        if (response.includes('wrong password')) {
          alert('Incorrect password');
        } else if (response.includes('No user')) {
          alert('User not found');
        } else {
          alert('Login Successfull. Click ok to go Profile page');
          localStorage.setItem('session_id', response);
          window.location.href = './profile.html';
        }
      },
      error: function (xhr, status, error) {
        alert('Registration Failed : ', error);
      },
    });
  });
});
