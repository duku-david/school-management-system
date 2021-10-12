<?php require_once "includes/header.php"; ?>

	<?php require_once "includes/banner.php" ?>
	
	<div class="about-section section-padding teacher-section">
		<div class="container">
			<div class="row">
                <?php
                    $query = "SELECT * FROM teacher LEFT JOIN login ON teacher.initials=login.initials";
                    $result = mysqli_query($conn, $query);
                    if(!$result) {
                        die(mysqli_error($conn));
                    }
                ?>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col-md-4">
					<div class="single-about text-center">
                       <img src="assets/images/teacher-images/<?php echo $row['picture']; ?>" alt="">
                        <div class="theme-margin"></div>
                        <h4 class="teacher-name"><?php echo $row['firstname']; ?> <?php echo $row['othername']; ?></h4>
                        <p><?php echo $row['initials']; ?></p>
                        <a id="teacher_id" data-id="<?php echo $row['staff_id']; ?>" class="btn btn-success btn-block">View Details</a>
					</div>
				</div>
                <?php } ?>
			</div>
		</div>
	</div>

    <!-- modal -->
    <div id="TeacherD" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Teacher Detail</h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-4 col-md-offset-4">
            
                    <span id="picture"></span>
                    <?php echo '<span id="picture"></span>'?>
                </div>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>First Name</th>
                                <td id="firstname"></td>
                            </tr>
                            <tr>
                                <th>Other Name</th>
                                <td id="othername"></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td id="username"></td>
                            </tr>
                            <tr>
                                <th>Initials</th>
                                <td id="initials"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php require_once "includes/footer.php"; ?>
<script>
    $(document).on("click","#teacher_id",function(){
        var id =$(this).data('id');
        $.ajax({
            url:"app/viewTeacher.php",
            type:"post",
            data:{id:id,viewTeacher:""},
            dataType:"JSON",
            success:function(d){
                
                $("#picture").html("<img src='assets/images/teacher-images/"+d.picture+"'>");

                $("#firstname").html(d.firstname);
                $("#othername").html(d.othername);
                $("#username").html(d.username);
                $("#initials").html(d.initials);
                $("#TeacherD").modal("show");
            }
        });
        
    });
</script>