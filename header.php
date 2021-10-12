<?php
	ob_start();
	require_once "../functions2.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="icon" type="text/css" href="../assets/image/favicon.ico">
	<title><?php echo get_school_name(); ?></title>
	<!-- stylesheet -->
	<link rel="stylesheet" tpe="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" tpe="text/css" href="assets/css/font-awesome.min.css">
	<link rel="stylesheet" tpe="text/css" href="style1.css">
	<style type="text/css">
		.home-banner1-bg {
    background: url(assets/images/pp2.png);
    background-size:  cover;
    background-repeat:  no-repeat;
    /*background-attachment:  fixed;*/
    /*background-position: top center;*/

}
.about-banner1-bg {
    background: url(assets/images/pp2.png);
    background-size:  cover;
    background-repeat:  no-repeat;
    /*background-attachment:  fixed;*/

}

	</style>
</head>
<body>
	<div class="main-header theme-bg">
		<div class="container">
			<div class="row">
				<div class="col-md-2 text-right">
					<?php 
					$query_logo = "SELECT * FROM page_contents WHERE page_name='site_logo' LIMIT 1";
					$result_logo = mysqli_query($conn, $query_logo);
					$row_logo = mysqli_fetch_assoc($result_logo);
					$image = $row_logo['page_image'];
					?>
					 <img src="assets/images/<?php echo $image; ?>" class="main-logo" alt="">
				</div>
				<div class="col-md-10 text-left">
					<div class="rphs-logo">
						<h2><?php echo get_school_name(); ?></h2>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="main-menu-wrap">
		<nav class="navbar">
			<div class="container">
				<div class="navbar-header">
					<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div id="navbarCollapse" class="collapse navbar-collapse">
					<ul class="nav navbar-nav text-right">
						<li><a href="index.php">Home</a></li>
						<li><a href="about.php">About</a></li>
						<li><a href="teachers.php">Teachers</a></li>
						<li><a href="gallery.php">Gallery</a></li>
						<li><a href="admission.php">Admission</a></li>
						<!-- <li><a href="result.php">Result</a></li> -->
						<li><a href="contact.php">Contact</a></li>
						<?php 
							if(!is_user_logged_in()) {
								echo "<li><a href='login.php'>Login</a></li>";
							}else 
							{
								if($_SESSION['privillage'] == 'administrator')
								{
									echo "<li><a href='school-admin/index.php' target='_blank'>Dashboard</a></li>";

								}else if($_SESSION['privillage'] == 'student') {
									echo "<li><a href='student-profile/index.php' target='_blank'>Dashboard</a></li>";
								}else if($_SESSION['privillage'] == 'teacher') {
									echo "<li><a href='teacher-dashboard/index.php' target='_blank'>Dashboard</a></li>";
								}
							}
						?>
					</ul>
				</div>
			</div>
		</nav>
	</div>