<?php require_once "includes/header.php"; ?>

	<?php require_once "includes/banner.php" ?>
  
	<div class="about-section section-padding admission-section">
		<div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4><strong>Our Address</strong></h4>
                    <?php echo get_school_address(); ?>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10303.617908918251!2d90.37013565923733!3d24.070563560722015!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755d94a65e490d5%3A0xec3d64ccd581ec30!2sRover+Polli+Ground!5e0!3m2!1sen!2sbd!4v1528047808066" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
               <div class="col-md-6">
                   <h4><strong>Submit this form to contact us:</strong></h4>
                   <form action="" method="post">
                       <div class="form-group">
                           <label for="">Your Name</label>
                           <input type="text" name="your-name" class="form-control">
                       </div>
                       <div class="form-group">
                           <label for="">Your Mobile Number</label>
                           <input type="text" name="your-phone" class="form-control">
                       </div>
                       <div class="form-group">
                           <label for="">Your Message</label>
                           <textarea name="your-message" id="" cols="30" rows="10" class="form-control"></textarea>
                       </div>
                       <div class="form-group">
                           <input type="submit" class="btn btn-success" name="contact-form" value="Send Message">
                       </div>
                   </form>
               </div>
            </div>
        </div>
    </div>

<?php require_once "includes/footer.php"; ?>