<?php

/*

  list of ratings 

  This file has the ugliest looking code out of every file, but it's responsible for rendering
  search results and displaying ratings to the user. 

  I really don't know how else to make the code less ugly

  If you are an admin, you will see an Edit and Delete button on every rating that you see

  If you are a user, you will see an Edit and Delete button on every rating that you created

*/



if (isset($_GET["search_submit"]) || isset($_GET["back_to_ratings_list"])) {
  include("../globals/header.php");
  include("../globals/global.php");

  $searchInput = mysqli_real_escape_string($connection, $_GET["search_input"]);

  $sql = "select * from $tableName where professor_name = '$searchInput'";

  if ($searchInput == "all") {
    $sql ="select * from $tableName where professor_name like '%'";
  }

  $result = mysqli_query($connection, $sql);
  $numRows = mysqli_num_rows($result);

  if ($result && $numRows > 0) {
    echo "<section class='ratings_list-wrapper'>";
    echo "<div class='results-notice'>*$numRows search results for '$searchInput'</div><br>";
    echo "<div class='ratings_list'>";
    while ($row = mysqli_fetch_assoc($result)) {
      $professorName = $row["professor_name"];
      $professorSchool = $row["professor_school"];
      $ratingValue = $row["rating_value"];
      $username = $row["username"];
      $ratingDate = $row["rating_date"];
      

      // render html for each individual rating 
      ?>

      <div class="ratings_list-item">
        <div class="ratings_list-rating">
          <div class="ratings_list-rating_header">RATING</div>
          <div class="ratings_list-rating_value"><?php echo $row['rating_value'] ?></div>
        </div>
        <div class="ratings_list-content">
          <div>Professor: <?php echo $row['professor_name'] ?></div>
          <div>School: <?php echo $row['professor_school'] ?></div>
          <div class="rating_action-buttons">
            <form action="../ratings/rating_view.php?
              professor_name=<?php echo $row['professor_name'];?>&
              professor_school=<?php echo $row['professor_school'];?>&
              username=<?php echo $row['username'];?>&
              rating_date=<?php echo $row['rating_date'];?>&
              rating_value=<?php echo $row['rating_value'];?>" 
              method="POST"
            >
              <input class="ratings_list_view-button" type="submit" name="view_rating" value="View Rating">
            </form>
            <?php
            
            // only show Edit and Delete actions on ratings created by the user
            if (isset($_SESSION["username"])) {
              if ($row["username"] === $_SESSION["username"] || $_SESSION["admin"]) {
                ?>
                <form action="rating_form.php?edit=true&
                  professor_name=<?php echo $row["professor_name"]?>&
                  professor_school=<?php echo $row["professor_school"]?>&
                  rating_value=<?php echo $row["rating_value"]?>&
                  search_input=<?php echo $searchInput ?>&
                  previous=list"
                  method="POST"
                >
                  <input type="hidden" name="rating_id" value="<?php echo $row["id"] ?>">
                  <input class="edit_rating-button" type="submit" name="edit" value="Edit">
                </form>
              
                <button class="delete_rating-button" id="delete_<?php echo $row["id"] ?>">Delete</button>
                <dialog class="rating_delete-modal" id="delete_modal_<?php echo $row["id"] ?>">
                  <div>
                    <h3>Are you sure you want to delete this rating?</h3>
                    <form action="rating_delete.php" method="POST">
                      <input type="hidden" name="rating_id" value="<?php echo $row['id'] ?>">
                      <input type="submit" name="delete_rating_submit" id="delete_rating_<?php echo $row["id"] ?>submit" value="Yes">
                      <input type="submit" name="delete_rating_nosubmit" id="delete_rating_<?php echo $row["id"] ?>nosubmit" value="No">
                    </form>
                  </div>
                </dialog>
  
                <!--Jquery code to handle modal toggle for delete rating -->
                <script>
                  $(document).ready(function() {
                    // Attach a click event handler to each "Delete" button to open the modal
                    $('#delete_<?php echo $row["id"] ?>').click(() => {
                      $('#delete_modal_<?php echo $row["id"] ?>').show();
                    });

                    /* attach a click event handler to the "No" button to prevent form submission
                      and hide the modal
                    */
                    $('#delete_rating_<?php echo $row["id"] ?>nosubmit').click((e) => {
                      $('#delete_modal_<?php echo $row["id"] ?>').hide();
                      return false;
                    })
  
                  });
                </script>
                <?php
              } 
            }
            ?>
          </div>
        </div>
      </div>
      <?php
    }
    echo "</div>";

    ?>

    <!-- These are just buttons to create a new form or return back to the search bar -->
    <br>
    <div class="results_buttons">
      <a href="../ratings/rating_form.php?search_input=<?php echo $searchInput ?>">
        <button class="rate_a_prof-button">Rate A Professor</button>
      </a>
      <a href="../index.php">
        <button class="rate_a_prof-button">Back to search</button>
      </a>
    </div>


    <?php include("../globals/footer.php") ?>

    <?php
  } else {
    // when there are no search results
    echo "<section class='ratings_list-wrapper'>";
    echo "<div class='results-notice'>*0 search results for '$searchInput'</div>";

    ?>
    <br>
    <div class="results_buttons">
      <a href="../ratings/rating_form.php?search_input=''">
        <button class="rate_a_prof-button">Rate A Professor</button>
      </a>
      <a href="../index.php">
        <button class="rate_a_prof-button">Back to search</button>
      </a>
    </div>

    <?php
    echo "</section>";

    include("../globals/footer.php");
  }
} else {
  // when you first login/signup; when you haven't pressed "Search" or "Back to Ratings List"

  // This is the default page that you get redirected to
  
  /*
    This is where all the success and error messeages are displayed for ratings, 
    and when you signup, login, or logout

  */

  echo "<div class='index-page'>";
  ?>
  <div class="rating_action-msgs">
    <?php
    if (isset($_GET["delete"])) {
      if ($_GET["delete"] === "success") {
        echo "<div class='success-msg'>*Successfully deleted rating</div>";
      } else if ($_GET["delete"] === "fail") {
        echo "<div class='error-msg'>*Failed to delete rating</div>";
      }
    } else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
      echo "<div class='success-msg'>*Successfully signed up</div>";
    } elseif (isset($_GET["create"])) {
      if ($_GET["create"] == "success") {
        echo "<div class='success-msg'>*Successfully created rating</div>";
      } else if ($_GET["create"] == "fail") {
        echo "<div class='error-msg'>*Failed to create rating</div>";
      }
    } elseif (isset($_GET["edit"])) {
      if ($_GET["edit"] == "success") {
        echo "<div class='success-msg'>*Successfully edited rating</div>";
      } else if ($_GET["edit"] == "fail") {
        echo "<div class='error-msg'>*Failed to edit rating</div>";
      }
    } elseif (isset($_GET["login"])) {
      if ($_GET["login"] == "success") {
        if ($_SESSION["admin"]) {
          echo "<div class='success-msg'>*Successfully logged in as an Administrator</div>";
        } else
          echo "<div class='success-msg'>*Successfully logged in</div>";
      } else if ($_GET["edit"] == "fail") {
        echo "<div class='error-msg'>*Failed to log in</div>";
      }
    } elseif (isset($_GET["logout"]) && $_GET["logout"] == "success") {
      echo "<div class='success-msg'>*You have logged out</div>";
    }

    ?>
  </div>
  <?php
  include("rating_search.php");
  ?>

  <div class="index-buttons">
    <a href="../ratings/rating_form.php?search_input=''">
      <button class="rate_a_prof-button">Rate A Professor</button>
    </a>
    <a href="../ratings/rating_list.php?search_submit=true&search_input=all">
      <button>View All Ratings</button>
    </a>
  </div>

  <?php
  echo "</div>";
}
?>


