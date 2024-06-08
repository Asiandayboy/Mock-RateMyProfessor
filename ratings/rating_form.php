<?php

/*

Form for rating professors

- Professor Name
- Professor School
- Username of the person rating
- Rating date (datetime)
- Rating value (int, 1-5)



this file renders the rating form for a new rating and a currently edited one


*/

include("../globals/header.php");

if (!isset($_SESSION["username"])) {
  header("Location: ../auth/signup_form.php?create=true");
  exit();
}

if (isset($_GET["edit"]) && $_GET["edit"]) {
  include("../globals/global.php");
  
  $professorName = mysqli_real_escape_string($connection, $_GET["professor_name"]);
  $professorSchool = mysqli_real_escape_string($connection, $_GET["professor_school"]);
  $ratingValue = intval($_GET["rating_value"]);
  $ratingId = intval($_POST["rating_id"]);
  
  // this is the rating form for when the user is editing a rating
  ?>

  <section class="rating_form-wrapper">
    <form 
      action="rating_edit.php"
      method="POST"
      class="rating_form"
    >
      <div class="rating_form_field">
        <label for="professor_name">Professor Name</label>
        <input type="text" name="professor_name" id="professor_name" value="<?php echo $professorName ?>">
      </div>
      <div class="rating_form_field">
        <label for="professor_school">School</label>
        <input type="text" name="professor_school" id="professor_school" value="<?php echo $professorSchool ?>">
      </div>
      <div>
        <label for="rating_value">Rating Value (1 = bad; 5 = good)</label>
        <select name="rating_value" id="rating_value">
          <option value="1" <?php if ($ratingValue === 1) echo 'selected'; ?>>1</option>
          <option value="2" <?php if ($ratingValue === 2) echo 'selected'; ?>>2</option>
          <option value="3" <?php if ($ratingValue === 3) echo 'selected'; ?>>3</option>
          <option value="4" <?php if ($ratingValue === 4) echo 'selected'; ?>>4</option>
          <option value="5" <?php if ($ratingValue === 5) echo 'selected'; ?>>5</option>
        </select>
      </div>
      <input type="hidden" name="rating_id" value="<?php echo $ratingId ?>">
      <input type="submit" value="Save Edit" name="rating_edit_submit" id="rating_edit_submit">
    </form>
    <br>

    <!-- Back button to return to previous page the way they left it -->
    <?php
    if (isset($_GET["previous"])) {
      if ($_GET["previous"] == "admin") {
        ?>
        <a href="../ratings/admin_page.php"><button>Back to Admin Page</button></a>
        <?php
      } else {
        ?>
        <form action="../ratings/rating_list.php?search_input=<?php echo $_GET["search_input"] ?>"
          method="GET"
        >
          <input type="hidden" name="search_input" value="<?php echo $_GET["search_input"] ?>">
          <input type="submit" name="back_to_ratings_list" value="Back to Ratings List">
        </form>
        <?php
      }
    }


    ?>

    <div class="rating_form-errmsgs">
    </div>
  </section>



  <?php

} else {
  // This is the rating form for when a user is creating a new rating
  ?>

  <section class="rating_form-wrapper">
    <form 
      action="rating_process.php"
      method="POST"
      class="rating_form"
    >
      <div class="rating_form_field">
        <label for="professor_name">Professor Name</label>
        <input type="text" name="professor_name" id="professor_name">
      </div>
      <div class="rating_form_field">
        <label for="professor_school">School</label>
        <input type="text" name="professor_school" id="professor_school">
      </div>
      <div class="rating_form_select">
        <label for="rating_value">Rating Value (1 = bad; 5 = good)</label>
        <select name="rating_value" id="rating_value">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </div>
      <input class="rating_form_submit-button" type="submit" value="Submit" name="rating_form_submit" id="rating_form_submit">
    </form>
    <br>
    
    <!-- Back button to return to previous page the way they left it -->
    <form action="../ratings/rating_list.php?search_input=<?php echo $_GET["search_input"] ?>"
      method="GET"
    >
      <input type="hidden" name="search_input" value="<?php echo $_GET["search_input"] ?>">
      <input type="submit" name="back_to_ratings_list" value="Back to Ratings List">
    </form>

    <div class="rating_form-errmsgs">
    </div>
  </section>


  <?php
}
?>



<?php include("../globals/footer.php") ?>