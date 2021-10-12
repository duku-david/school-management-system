<?php
		
			if(isset($_POST['submit']))
			{
				$password=$_POST['password1'];
				$password1=$_POST['password2'];

				$conn=mysqli_connect('localhost','root','','hotel2');
				
				if($password==$password1)
				{
					$query1="UPDATE loginusers SET password='$password' WHERE email='".$_SESSION['forgetpass']."'";
					$query2="UPDATE customer SET password='$password' WHERE email='".$_SESSION['forgetpass']."'";
					$res=mysqli_query($conn,$query1);
					$res=mysqli_query($conn,$query2);
					if(mysqli_affected_rows($conn)>0)
					{
						setcookie('error',"<p class='alert alert-success text-center'><strong>Your Password has been Changed Successfully.</strong></p>",time()+3);
						header('Location:student-sign-out');
					}
					else
					{
						setcookie('error',"<p class='alert alert-danger text-center'><strong>Sorry! We are Unable To Process, Try Again Later.</strong></p>",time()+3);
						header('Location:resetpassword.php');
					}
					mysqli_close($conn);
				}
				else
				{
					setcookie('error',"<p class='alert alert-warning text-center'><strong>Two Password Do Not Match.</strong></p>",time()+3);
					header('Location:resetpassword.php');
				}					
				
			}
		
		?>
<?php require_once "includes/header.php"; ?>

    <?php require_once "includes/banner.php" ?>
    <?php
        if(is_user_logged_in()) {
            header("Location: index.php");
        }
        if(!isset($_SESSION['FORGET'])) 
		{
			header('location:signIn.php');
			exit(0);
		}
    ?>
  <style type="text/css">
  #wrapper1{
    right: 0px;
    margin: 0px auto;   
    width: 570px;
    position: relative;
}

#wrapper1 h2{
    font-size: 20px;
    text-align: center;
    color: rgb(6, 106, 117);
    font-family:'Arial Narrow',Arial,sans-serif;
    font-weight: bold;
    padding-bottom: 10px;
}

 .login-heading{
    z-index: 21;
  position: relative;
  top: 0px;
  width: 88%; 
  margin: 0 0 15px 0;
  background: rgb(247, 247, 247);
  border: 1px solid rgba(147, 184, 189,0.8);
  -webkit-box-shadow: 0pt 2px 5px rgba(105, 108, 109,  0.7),  0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
     -moz-box-shadow: 0pt 2px 5px rgba(105, 108, 109,  0.7),  0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
          box-shadow: 0pt 2px 5px rgba(105, 108, 109,  0.7),  0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
  -webkit-box-shadow: 5px;
  -moz-border-radius: 5px;
     /*border-radius: 5px;*/
 }

 .login-heading h1{
    font-size: 30px;
    text-align: center;
    color: rgb(6, 106, 117);
    font-family:'Arial Narrow',Arial,sans-serif;
    font-weight: bold;
    /*padding-bottom: 10px;*/
    padding: 10px 0 0 0px;
}
  .conn
  {
  z-index: 21;
  position: relative;
  top: 0px;
  width: 88%; 
  padding: 10px 5% 10px 4%;
  margin: 0 0 0px 0;
  background: rgb(247, 247, 247);
  border: 1px solid rgba(147, 184, 189,0.8);
  -webkit-box-shadow: 0pt 2px 5px rgba(105, 108, 109,  0.7),  0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
     -moz-box-shadow: 0pt 2px 5px rgba(105, 108, 109,  0.7),  0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
          box-shadow: 0pt 2px 5px rgba(105, 108, 109,  0.7),  0px 0px 8px 5px rgba(208, 223, 226, 0.4) inset;
  -webkit-box-shadow: 5px;
  -moz-border-radius: 5px;
     border-radius: 5px;
  }
  </style>
  <div class="about-section section-padding admission-section">
      <div class="container" id="wrapper1">
      	<div class="conn">
		<div id="errorMsg" align="center" style="color:red;"></div>
		<?php
			if(isset($_COOKIE['error']))
			echo $_COOKIE['error'];
		?>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return PasswordValidation2()">
	<div class="form-group">
		<label>Enter Password</label>
		<input type="password" name="password1" id="password1" placeholder="Enter Password" 
		class="form-control" />
	</div>
	<div class="form-group">
		<label>Confirm Password</label>
		<input type="password" name="password2" id="password2" placeholder="Confirm Password" class="form-control" />
	</div>
	<div class="row">
		<div class="col-sm-6">
			<input type="submit" name="submit" value="Submit" class="btn btn-success btn-block" />
		</div>
		<div class="col-sm-6">
			<input type="reset" name="reset" value="Clear" class="btn btn-danger btn-block" />
		</div>
	</div>
</form>
</div>
</div>
</div>