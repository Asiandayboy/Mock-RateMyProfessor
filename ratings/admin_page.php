<?php

/*

  I really did not know what I would add to the admin page when I have admin functionality
  implemented in my rating_list.php file

  I just decided to make it so that the admin page allows admins to view all users info and 
  see all their ratings

*/

include("../globals/header.php");

if (!(isset($_SESSION["admin"]) && $_SESSION["admin"])) {
  header("Location: ../index.php");
  exit();
}

include ("../globals/global.php");

$getUsersSql = "select * from $accountsTableName";


$usersResult = mysqli_query($connection, $getUsersSql);

echo "<section class='users_list-wrapper'>";
echo "<h3>All Users</h3>";

if (mysqli_num_rows($usersResult) == 0) {
  ?>
  <div class="user">
    <div>No Users Registered</div>
  </div>
  <?php
} else {
  // render html for every user that is registered
  while ($row = mysqli_fetch_assoc($usersResult)) {
    $username = $row["username"];
    ?>
    <div class="user">
      <div class="user_id">User ID: <?php echo $row["id"] ?></div>
      <div>Username: <?php echo $username ?></div>
      <div>Email: <?php echo $row["email"] ?></div>
      <br>
      <button class="user_view-button" id="user_<?php echo $username ?>_view_rating-button">View Ratings</button>
      <div id="user_ratings-wrapper_<?php echo $username ?>" style="display: none;">

      <?php
      $getRatingsSql = "select * from $tableName where username='$username'";
      $ratingsResult = mysqli_query($connection, $getRatingsSql);

      if (mysqli_num_rows($ratingsResult) == 0) {
        echo "<div>No ratings created by this user</div>";
      } else {
        // render html for each of the user's ratings
        while ($row = mysqli_fetch_assoc($ratingsResult)) {
          ?>
          <div>
            <div>
              <div>ID: <?php echo $row["id"] ?></div>
              <div>Professor: <?php echo $row["professor_name"] ?></div>
              <div>School: <?php echo $row["professor_school"] ?></div>
              <div>Rating: <?php echo $row["rating_value"] ?></div>
              <div>Date: <?php echo $row["rating_date"] ?></div>
            </div>
            
            <!-- html for Edit and Delete ratings button; same as in rating_list.php -->
            <div class="user_ratings_action-button">
              <form action="rating_form.php?edit=true&
                professor_name=<?php echo $row["professor_name"]?>&
                professor_school=<?php echo $row["professor_school"]?>&
                rating_value=<?php echo $row["rating_value"]?>&
                search_input=<?php echo '' ?>&
                previous=admin"
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
            </div>
          </div>
          <?php
        }
      }
      ?>
      </div>
    </div>

    <!-- This script handles the conditional rendering for the "View Ratings" button
    Allowing admins to see ratings created by the user -->
    <script>
      $(document).ready(function() {
        const button = $("#user_<?php echo $username ?>_view_rating-button");
        button.click(() => {
          const wrapper = $("#user_ratings-wrapper_<?php echo $username ?>");

          if (button.text() == "View Ratings") {
            button.text("Close");
            wrapper.css({
              "display": "flex"
            });
          } else if (button.text() == "Close") {
            button.text("View Ratings");
            wrapper.css({
              "display": "none"
            });
          }
        })

      });
    </script>
    <?php
  }
}
echo "</section>";




include("../globals/footer.php");
?>

