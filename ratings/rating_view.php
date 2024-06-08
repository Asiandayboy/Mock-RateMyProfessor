<?php

/*

  Allows a user to only view more info about a specific rating, nothing else

*/

include("../globals/header.php");


// if (!isset($_SESSION["username"])) {
//   header("Location: ../index.php");
//   exit();
// }

if (isset($_POST["view_rating"]) && $_POST["view_rating"]) {
  ?>

  <div class="rating_view-wrapper">
    <div class="rating_view">
      <div class="rating">
        <div>Rating: <?php echo $_GET["rating_value"] ?></div>
      </div>
      <div>
        <div>Username: <?php echo $_GET["username"] ?></div>
        <div>Professor: <?php echo $_GET["professor_name"] ?></div>
        <div>School: <?php echo $_GET["professor_school"] ?></div>
        <div>Date: <?php echo $_GET["rating_date"] ?></div>
      </div>
    </div>
    <br>
    <!-- Back button to return to previous page the way they left it -->
    <form action="../ratings/rating_list.php?search_input=<?php echo $_GET["professor_name"] ?>"
      method="GET"
    >
      <input type="hidden" name="search_input" value="<?php echo $_GET["professor_name"] ?>">
      <input type="submit" name="back_to_ratings_list" value="Back to Ratings List">
    </form>
  </div>


  <?php
} else {
  header("Location: ../index.php");
  exit();
}

?>


<?php include("../globals/footer.php") ?>
