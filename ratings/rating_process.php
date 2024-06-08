<?php

/*

Processes rating form, adds information to database

*/
session_start();
if (!isset($_SESSION["username"])) {
  header("Location: ../index.php");
  exit();
}

if (isset($_POST["rating_form_submit"])) {

  include("../globals/global.php");

  $professorName = mysqli_real_escape_string($connection, $_POST["professor_name"]);
  $professorSchool = mysqli_real_escape_string($connection, $_POST["professor_school"]);
  $ratingValue = intval($_POST["rating_value"]);
  $ratingDate = date("Y-m-d H:i:s");
  $username = mysqli_real_escape_string($connection, $_SESSION["username"]);

  $errorMsg = "";

  if ($professorName == "") {
    $errorMsg .= "Professor name is required<br>";
  } 
  if ($professorSchool == "") {
    $errorMsg .= "School name is required<br>";
  } 

  if ($errorMsg != "") {
    header("Location: rating_form.php?error=$errorMsg");
    exit();
  }

  // I was using prepared statements here. 
  $sql = "insert into $tableName (professor_name, professor_school, username, rating_date, rating_value) values
    (?,?,?,?,?)";
  $stmt = mysqli_prepare($connection, $sql);
  mysqli_stmt_bind_param($stmt, "ssssd", $professorName, $professorSchool, $username, $ratingDate, $ratingValue);


  if (mysqli_stmt_execute($stmt)) {
    header("Location: ../index.php?create=success");
    mysqli_stmt_close($stmt);
    exit();
  } else {
    $err = mysqli_stmt_error($stmt);
    header("Location: rating_form.php?create=fail&error=sql&message=$err");
    mysqli_stmt_close($stmt);
    exit();
  }


} else {
  header("Location: ../index.php");
  exit();
}


?>




