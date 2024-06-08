<?php

/*

  database operations to a delete rating

*/

session_start();

if (!isset($_SESSION["username"])) {
  header("Location: ../index.php");
  exit();
}



if (isset($_POST["delete_rating_submit"])) {
  include("../globals/global.php");

  $ratingId = intval($_POST["rating_id"]);
  // $username = mysqli_real_escape_string($connection, $_SESSION["username"]);

  $sql = "delete from $tableName where id=$ratingId";

  $result = mysqli_query($connection, $sql);

  if ($result) {
    header("Location: ../index.php?delete=success");
    exit();
  } else {
    header("Location: ../index.php?delete=fail");
    exit();
  }
  
} else {
  header("Location: ../index.php");
  exit();
}



?>