const ERROR_MSGS = {
  username: "*Username must not be blank",
  password: "*Password must not be blank"
};



function onSubmit(event) {
  const usernameLabel = $("#usernamelabel");
  usernameLabel.empty();
  usernameLabel.append("Username");

  const passwordLabel = $("#passwordlabel");
  passwordLabel.empty();
  passwordLabel.append("Password");

  const username = $("#username").val();
  const password = $("#password").val();

  let errCount = 0

  if (username == "") {
    usernameLabel.append(`<span class="error-msg" style="font-style: italic;"> ${ERROR_MSGS.username}</span>`);
    errCount++;
  }

  if (password == "") {
    passwordLabel.append(`<span class="error-msg" style="font-style: italic;"> ${ERROR_MSGS.password}</span>`);
    errCount++;
  }


  return errCount == 0;
}


// client validation for login form

$(document).ready(() => {
  $("#login_submit").click(onSubmit);
})