<?php

/*
  I made the username and email fields unique, so the sql query will return an error if
  the query contains a value that is already in the db. I need to parse the error to see
  if it returns an error about the username or the email. It's either a unique username error or an 
  unique email error
*/
function parseSqlError($errmsg) {
  $usernameCheck = strpos($errmsg, "username");
  $emailCheck = strpos($errmsg, "accounts");

  if ($usernameCheck)
    return "username";
  else if ($emailCheck)
    return "email";
}


if (isset($_POST['signup_submit'])) {
  include ("../globals/global.php");

  $username = mysqli_real_escape_string($connection, $_POST["username"]);
  $password = mysqli_real_escape_string($connection, $_POST["password"]);
  $passwordConfirm = mysqli_real_escape_string($connection, $_POST["password_confirm"]);
  $email = mysqli_real_escape_string($connection, $_POST["email"]);

  // server form validation
  if (empty($username) || empty($password) || empty($passwordConfirm) || empty($email)) {
    header("Location: signup_form.php?error=emptyfields&username=$username");
    exit();
  } elseif ($password !== $passwordConfirm) {
    header("Location: signup_form.php?error=passwordmismatch&username=$username");
    exit();
  }

  /*
    Every user that signs up will have admin set to false
    Adding an admin user has to be done manually with SQL
  */
  $sql = "insert into $accountsTableName (username, password, email, admin) values 
  ('$username', '$password', '$email', false)";


  try {
    $result = mysqli_query($connection, $sql);
    if ($result) {
      session_start();
      $_SESSION["username"] = $username;
      $_SESSION["admin"] = false;
    
      header("Location: ../index.php?signup=success");
      exit();
    } 
  } catch(Exception $err) {


    $error = parseSqlError(mysqli_error($connection));

    // check if the sql error is because of the email or username not being unique
    if ($error == "username") {
      header("Location: signup_form.php?error=usernametaken&username=$username");
    } elseif ($error == "email") {
      header("Location: signup_form.php?error=emailtaken&email=$email");
    }
    exit();
  }



}


?>