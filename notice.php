<?php require_once "includes/header.php"; ?>

  <?php require_once "includes/banner.php" ?>
    
    <div class="about-section section-padding teacher-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                        if(isset($_GET['id'])) {
                            $get_the_id = $_GET['id'];

                            $query = "SELECT * FROM notice WHERE id=$get_the_id";
                            $result = mysqli_query($conn, $query);
                            while($row = mysqli_fetch_assoc($result)) {
                                $notice_title = $row['notice_title'];
                                $notice_desc = $row['notice_desc'];
                                $notice_date = $row['notice_date'];
                                echo "<h3>$notice_title</h3>";
                                echo "<p>Date: <span class='notice-date'>$notice_date</span></p>";
                                echo "<p>$notice_desc</p>";
                            }
                        } else {
                            $query = "SELECT * FROM notice ORDER BY id DESC";
                            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                            while($row = mysqli_fetch_assoc($result)) {
                                $notice_id = $row['id'];
                                $notice_title = $row['notice_title'];
                                echo "<p class='notice-title-page'><i class='fa fa-hand-o-right'><a href='notice.php?id=$notice_id'>$notice_title</a></i></p>";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php require_once "includes/footer.php"; ?>