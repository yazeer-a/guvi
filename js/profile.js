function load() {
  $.ajax({
    type: 'POST',
    url: './php/profile.php',
    data: {
      sessionid: localStorage.getItem('session_id')
        ? localStorage.getItem('session_id')
        : 'empty',
    },
    success: function (response) {
      if (!response.includes('no user')) {
        var data = JSON.parse(response);
        $('#name').text(data['name']);
        $('#email').text(data['email']);
        $('#age').text(data['age']);
        $('#dob').text(data['dob']);
        $('#mobile').text(data['mobile']);
      } else {
        location.href = './register.html';
      }
    },
    error: function (xhr, status, error) {
      console.log(xhr, error);
    },
  });
}

function update() {
  var name = $('#name').text();
  var email = $('#email').text();
  var age = $('#age').text();
  var dob = $('#dob').text();
  var mobile = $('#mobile').text();
  $.ajax({
    type: 'POST',
    url: './php/profile.php',
    data: {
      name: name,
      email: email,
      age: age,
      dob: dob,
      mobile: mobile,
    },
    success: function (response) {
      if (response.includes('Update success')) {
        alert('Updated successful');
      } else {
        alert('Update Failed : ' + response);
      }
    },
    error: function (xhr, status, error) {
      alert('Update Failed : ', error);
    },
  });
}

function logout() {
  $.ajax({
    type: 'GET',
    url: './php/profile.php',
  });
  localStorage.clear();
  window.location.href = './index.html';
}
