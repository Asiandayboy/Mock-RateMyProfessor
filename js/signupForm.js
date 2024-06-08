const ERROR_MSGS = {
  username: "*Username must not be blank",
  email: "*Email must not be blank",
  passwordLength: "*Password must be at least 8 characters long",
  passwordConfirm: "*Confirm password must not be blank"
};



function onSubmit(event) {
  const usernameLabel = $("#usernamelabel");
  usernameLabel.empty();
  usernameLabel.append("Username");

  const emailLabel = $("#emaillabel");
  emailLabel.empty();
  emailLabel.append("Email");

  const passwordLabel = $("#passwordlabel");
  passwordLabel.empty();
  passwordLabel.append("Password");

  const passwordConfirmLabel = $("#passwordconfirmlabel");
  passwordConfirmLabel.empty();
  passwordConfirmLabel.append("Confirm password");

  const username = $("#username").val();
  const password = $("#password").val();
  const passwordConfirm = $("#password_confirm").val();
  const email = $("#email").val();

  let errCount = 0

  if (username == "") {
    usernameLabel.append(`<span class="error-msg" style="font-style: italic;"> ${ERROR_MSGS.username}</span>`);
    errCount++;
  }

  if (email == "") {
    emailLabel.append(`<span class="error-msg"  style="font-style: italic;"> ${ERROR_MSGS.email}</span>`);
    errCount++;
  }

  if (password.length < 8) {
    passwordLabel.append(`<span class="error-msg"  style="font-style: italic;"> ${ERROR_MSGS.passwordLength}</span>`);
    errCount++;
  }

  if (passwordConfirm == "") {
    passwordConfirmLabel.append(`<span class="error-msg"  style="font-style: italic;"> ${ERROR_MSGS.passwordConfirm}</span>`);
    errCount++;
  }


  return errCount == 0;
}


// client validation for signup form

$(document).ready(() => {
  $("#signup_submit").click(onSubmit);
})