<?php require_once "includes/header.php"; ?>

	<?php require_once "includes/banner.php" ?>
    
	<div class="about-section section-padding teacher-section">
		<div class="container">
            <div class="row">
                <?php 
                    $query = "SELECT * FROM page_contents WHERE page_name='gallery_page'";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $image = $row['page_image'];
                ?>
                    <div class="col-md-4">
                        <a href="#"><img class="thumbnail img-responsive" src="assets/images/gallery-image/<?php echo $image; ?>"></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div tabindex="-1" class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

<?php require_once "includes/footer.php"; ?>