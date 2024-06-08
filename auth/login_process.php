<?php

if (isset($_POST["login_submit"])) {
  include("../globals/global.php");

  $username = mysqli_real_escape_string($connection, $_POST["username"]);
  $password = mysqli_real_escape_string($connection, $_POST["password"]);

  $sql = "select * from $accountsTableName a 
    where a.username='$username' and a.password='$password'";

  $result = mysqli_query($connection, $sql);

  if ($result) {
    if ($row = mysqli_fetch_assoc($result)) {

      session_start();

      $_SESSION["username"] = $row["username"];
      $_SESSION["admin"] = $row["admin"];
      header("Location: ../index.php?login=success");
      exit();

    } else {
      // no accounts found with the specified credentials
      header("Location: ../auth/login_form.php?err=loginfailed");
      exit();
    }
  }
}




?>