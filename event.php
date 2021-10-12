<?php require_once "includes/header.php"; ?>

  <?php require_once "includes/banner.php" ?>
    
    <div class="about-section section-padding teacher-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        if(isset($_GET['id'])) {
                            $get_the_id = $_GET['id'];

                            $query = "SELECT * FROM event WHERE id=$get_the_id";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                                $event_title = $row['event_title'];
                                $event_desc = $row['event_desc'];
                                $event_date = $row['event_date'];
                                $event_image = $row['event_image'];
                                $img_path = "assets/images/event-images/{$event_image}";
                                echo "<h3>$event_title</h3>";  
                                echo "<p>Date: <span class='event-date'>$event_date</span></p>";
                                echo "<p>$event_desc</p>";
                                echo "<div class='col-md-12'>";
                                echo "<img src='$img_path' class='event-img' alt='$event_title' >";
                                echo "</div>";
                            }
                        } else {
                            $query = "SELECT * FROM event ORDER BY id DESC";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                                $event_id = $row['id'];
                                $event_title = $row['event_title'];
                                echo "<p class='notice-title-page'><i class='fa fa-hand-o-right'><a href='event.php?id=$event_id'>$event_title</a></i></p>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php require_once "includes/footer.php"; ?>