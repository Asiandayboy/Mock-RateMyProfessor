<?php 
include("../globals/header.php"); 

if (isset($_SESSION["username"])) {
  header("Location: ../index.php");
  exit();
}
?>

<script src="../js/signupForm.js"></script>
<section class="signup_form-wrapper">
  <form action="../auth/signup_process.php" method="POST" class="signup-form">
    <h3>Sign up</h3>
    <div>
      <label for="username" id="usernamelabel">Username</label>
      <input type="text" name="username" id="username">
    </div>
    <div>
      <label for="email" id="emaillabel">Email</label>
      <input type="text" name="email" id="email">
    </div>
    <div>
      <label for="password" id="passwordlabel">Password</label>
      <input type="password" name="password" id="password">
    </div>
    <div>
      <label for="password" id="passwordconfirmlabel">Confirm password</label>
      <input type="password" name="password_confirm" id="password_confirm">
    </div>
    <input class="signup-submit" type="submit" value="Sign up" id="signup_submit" name="signup_submit">
    <br><br>
    <div class="signup_errmsg-wrapper">
      <?php
      if (isset($_GET["error"])) {
        $err = $_GET["error"];
  
        if ($err == "usernametaken") {
          $username = $_GET["username"];
          echo "<li class='signuperror'>*Username '$username' is already taken</li>";
        } elseif ($err == "emptyfields") {
          echo "<li class='signuperror'>*Empty fields</li>";
        } elseif ($err == "passwordmismatch") {
          echo "<li class='signuperror'>*Passwords do not match</li>";
        } elseif ($err == "emailtaken") {
          $email = $_GET["email"];
          echo "<li class='signuperror'>*Email '$email' is already taken</li>";
        }
      } elseif (isset($_GET["create"]) && $_GET["create"] == true) {
        echo "<li class='success-msg'>*Sign up first to rate a professor</li>";
      }
      ?>
    </div>
  </form>
  <!-- <a href="../index.php">Back to Login</a> -->
</section>

<?php include("../globals/footer.php"); ?>