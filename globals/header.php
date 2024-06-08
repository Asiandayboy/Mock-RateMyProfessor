<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mock Rate My Professor</title>
  <link rel="stylesheet" href="../styles/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../js/index.js"></script>
</head>
<body>
  <header>
  <?php 

  session_start();
  if (isset($_SESSION["username"])) {
    ?>
    <nav>
      <a class="home" href="../index.php">RateMyProfessor</a>
      <div>Hello, <?php echo $_SESSION["username"]?>!</div>
      <?php
      if (isset($_SESSION["admin"]) && $_SESSION["admin"]) {
        echo "<a class='admin_page-link' href='../ratings/admin_page.php'>Admin Page</a>";
      }

      ?>
      <a href="../auth/logout_process.php"><button class="logout-button">Logout</button></a>
    </nav>
    <?php
  } else {
    ?>
    <nav>
      <a class="home" href="../index.php">RateMyProfessor</a>
      <div>
        <a class="login-link" href="../auth/login_form.php">Login</a>
        <a href="../auth/signup_form.php"><button class="signup-button">Sign up</button></a>
      </div>
    </nav>
    <?php
  }
  ?>
  </header>
  <main>
  
