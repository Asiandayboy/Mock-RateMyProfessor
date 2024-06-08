<?php



/* CHANGE mysqli_connect INFO TO MATCH YOURS
  You will need to edit the database login info to match yours.

  I DID NOT USE MAMP (I couldn't get my sqli working), so I had to use the PHP server extension 
  on VSCode with MySQL workbench and my own info. Everything works on my end, so I hope you don't
  encounter any issues trying to get it running


  This file will create the ratings and accounts table and add in 4 mock ratings
  The users for the mock ratings are not real users that are saved in the database

  You will need to add an admin user manually

*/

// hostname, username, password, databaseName, portNumber
$connection = mysqli_connect("localhost", "JWU_admin", "password", "ratemyprofessor", "3306");
$tableName = "ratings";
$accountsTableName = "accounts";


function insertMockRatings($connection, $tableName) {
  $currDate = date("Y-m-d H:i:s");

  $sql = "insert into $tableName (professor_name, professor_school, username, rating_date, rating_value) values
  ('Dr. John Smith', 'Grass University', 'user123', '$currDate', 4),
  ('Bob Shaker', 'Waters University', 'user246',  '$currDate', 2),
  ('Jules Sir Motherboard', 'Computer University', 'user369',  '$currDate', 5),
  ('Flameo Hotman', 'Fire University', 'user4812',  '$currDate', 5)";

  mysqli_query($connection, $sql);
}


function initRatingsTable($connection, $tableName) {
  $sqlCheck = "show tables like '$tableName'";
  $result = mysqli_query($connection, $sqlCheck);

  if (mysqli_num_rows($result) == 0) {
    $sql = "create table $tableName (
      id int auto_increment primary key,
      professor_name varchar(200),
      professor_school varchar(255),
      username varchar(255),
      rating_date datetime,
      rating_value tinyint
    )";

    mysqli_query($connection, $sql);
    insertMockRatings($connection, $tableName);

  } else {
    // echo "Debug msg: global.php-ratings table already exists<br>";
  }
}

function initAccountsTable($connection, $accountsTableName) {
  $sqlCheck = "show tables like '$accountsTableName'";
  $result = mysqli_query($connection, $sqlCheck);

  if (mysqli_num_rows($result) == 0) {
    $sql = "create table $accountsTableName (
      id int auto_increment primary key,
      username varchar(255) unique,
      password varchar(255),
      email varchar(255) unique,
      admin bool
    )";
  
    mysqli_query($connection, $sql);
  } else {
    // echo "Debug msg: global.php-accounts table already exists<br>";
  }
}



initRatingsTable($connection, $tableName);
initAccountsTable($connection, $accountsTableName);






?>