<?php require_once "includes/header.php"; ?>

    <?php require_once "includes/banner.php" ?>
    <?php
        if(is_user_logged_in()) {
            header("Location: index.php");
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
	<?php
		
		if(isset($_POST['submit']))
		{
			$email=$_POST['email'];
			if(!empty($email))
			{
		
			$query="SELECT * FROM login WHERE username='".$email."'";
			$result=mysqli_query($conn,$query);
			$num=mysqli_num_rows($result);
			$row=mysqli_fetch_assoc($result);
			mysqli_close($conn);

				if ($num==1) 
				{
					if($row['status']=="active")
					{
							
						$to=$email;
						$subject="Forget Password, SCHOOL SYSTEM";
						$token=substr(str_shuffle(time()),3,5);
						$message="Hello, ".$email."<br>
								 Your TOKEN is: <b><i>".$token."</i></b><br>
								 Thanks.<br>
								 SCHOOL";
						$headers='From: <dukudavidjoseph02@gmail.com>' . "\r\n" .
									'MIME-Version: 1.0' . "\r\n" .
									'Content-type: text/html; charset=utf-8';
						if(mail($to, $subject, $message, $headers))
						{
							$_SESSION['forgetpass']=$email;
							$_SESSION['token']=$token;
							header('location:emailtoken.php');
						}
						else
						{
							setcookie('error',"<p class='alert alert-warning text-center'><strong>Email sent Failed</strong></p>",time()+3);
							header('location:forget-password.php');
						}
						
					}
					else
					{
						setcookie('error',"<p class='alert alert-warning text-center'><strong>First, Activate Your Account From Your Email Link.</strong></p>",time()+3);
						header('location:forget-password.php');
					}
				}
				else
				{
					setcookie('error',"<p class='alert alert-danger text-center'><strong>Sorry! Email Id is Incorrect.</strong></p>",time()+3);
					header('location:forget-password.php');
				}
			}else
			{
				setcookie('error',"<p class='alert alert-danger text-center'><strong>Please Enter Email.</strong></p>",time()+3);
				header('location:forget-password.php');	
			}
				
		}
	?>
        

            	<h2 class="text-center">Forget Password</h2>
        		<div id="errorMsg" align="center" style="color:red;"></div>
        		<?php 
			    	if(isset($_COOKIE['error']))
			    	echo $_COOKIE['error'];?>
        		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="forget-passwordForm">
					<div class="form-group">
						<label>Enter Registered Email ID :</label>
						<input type="email" name="email" id="email" placeholder="Enter Your Email" class="form-control">
					</div>
					<input type="submit" name="submit" value="Next"  class="btn btn-primary btn-block" />
				</form>	
    		</div>
    	</div>
</div>
<?php include"includes/footer.php";?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#forget-passwordForm").on("submit",function(){
			if(emailValid("email")==false)
			{
				return false;
			}
		});
	});
</script>


