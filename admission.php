<?php require_once "includes/header.php"; ?>
<?php require_once "includes/banner.php" ?>

<div class="about-section section-padding admission-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                    $query = "SELECT * FROM page_contents WHERE page_name='admission_page'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    echo $row['page_text'];
                ?>
            </div>
        </div>
    </div>
</div>
<?php require_once "includes/footer.php"; ?>