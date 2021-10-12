<?php 	
	
				if(isset($_POST['submit']))
				{
					$token=$_POST['email-token'];
					if($token==$_SESSION['token'])
					{
						$_SESSION['FORGET']="FORGET";
						header('location:resetpassword');
					}
					else
					{
						setcookie('error',"<p class='alert alert-danger text-center'><strong>Sorry! TOKEN is Incorrect.</strong></p>",time()+3);
						header('location:http:emailtoken.php');
					}
				}
			?>
<?php require_once "includes/header.php"; ?>

    <?php require_once "includes/banner.php" ?>
    <?php
        if(is_user_logged_in()) {
            header("Location: index.php");
        }
        if(!isset($_SESSION['forgetpass']))
	{
		header('location:forget-password.php');
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
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onsubmit="return OTPValidation()">
			<div class="form-group">
				<div class="row">
					<div class="col-sm-6 alert alert-success text-center">
						OTP is send on this Email Address
					</div>
					<div class="col-sm-6 alert alert-info text-center">
						<b><?php  echo $_SESSION['forgetpass']; ?></b>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Enter TOKON :</label>
				<input type="number" name="email-token" id="email-token" placeholder="Enter token" class="form-control" />
			</div>	
			<input type="submit" name="submit" value="Next" class="btn btn-primary btn-block" />
			</form>
		</div>
	</div>
</div>
<script>

	function OTPValidation()
	{
		var otp=document.getElementById("email-token").value;
		if(otp=="" || otp==null)
		{
			alert("Enter TOKEN That is Send on Your Gmail !");
			document.getElementById("email-token").focus();
			return false;
		}
		else if(otp.length<5 || otp.length>5)
		{
			alert("Enter Exact 5 Digits OTP !");
			document.getElementById("email-token").focus();
			return false;
		}
	}
		
</script>