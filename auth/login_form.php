<?php 
include("../globals/header.php"); 

if (isset($_SESSION["username"])) {
  header("Location: ../index.php");
  exit();
}

?>

<script src="../js/loginForm.js"></script>
<section>
  <form action="../auth/login_process.php" method="POST" class="login-form">
    <h3>Login</h3>
    <div>
      <label for="username" id="usernamelabel">Username</label>
      <input type="text" name="username" id="username">
    </div>
    <div>
      <label for="password" id="passwordlabel">Password</label>
      <input type="password" name="password" id="password">
    </div>
    <input class="login-submit" type="submit" value="Login" id="login_submit" name="login_submit">
    <br><br>
    <div class="login_errmsg-wrapper">
      <?php
      if (isset($_GET["err"])) {
        $err = $_GET["err"];
  
        if ($err == "loginfailed") {
          echo "<li>*Incorrect username or password</li>";
        }
      }
      ?>
    </div>
  </form>
  <!-- <a href="../auth/signup_form.php">Don't have an account? Sign up!</a> -->
</section>


<?php include("../globals/footer.php") ?>