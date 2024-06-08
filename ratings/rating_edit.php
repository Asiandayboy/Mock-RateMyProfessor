<?php

/*

  database operations to edit a selected rating

*/


session_start();

if (!isset($_SESSION["username"])) {
  header("Location: ../index.php");
  exit();
}


if (isset($_POST["rating_edit_submit"])) {
  include("../globals/global.php");


  $ratingId = intval($_POST["rating_id"]);
  // $username = mysqli_real_escape_string($connection, $_SESSION["username"]);

  $professorName = mysqli_real_escape_string($connection, $_POST["professor_name"]);
  $professorSchool = mysqli_real_escape_string($connection, $_POST["professor_school"]);
  $ratingValue = intval($_POST["rating_value"]);
  $ratingDate = date("Y-m-d H:i:s");


  $sql = "update $tableName set professor_name='$professorName', professor_school='$professorSchool',
  rating_value='$ratingValue', rating_date='$ratingDate' where id=$ratingId";


  $result = mysqli_query($connection, $sql);


  if ($result) {
    header("Location: ../index.php?edit=success");
    exit();
  } else {
    header("Location: ../index.php?edit=fail");
    exit();
  }
}




?>