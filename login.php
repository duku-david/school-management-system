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
          <div class="login-heading col-md-4 col-md-offset-4"><h1>Staff Login</h1></div>
              <div class="conn col-md-4 col-md-offset-4">
                <?php $login_error = user_login(); ?>
                   <?php
                    if(!empty($login_error)) {
                      echo '<div class="alert alert-danger">
         <button type="button" class="close" data-dismiss="alert">&times;</button><p>'.$login_error.'</p></div>';
                    }
                   ?>
                <?php if(isset($_GET['logout'])){
                    echo '<div class="alert alert-success">
                        <button class="close" data-dismiss="alert" >&times;</button>
                        <p>Successful logged out!</p>
                        </div>';
                  }?>
                  <?php if(isset($_GET['pass_change'])){
                        echo'<div class="alert alert-success">
                        <button class="close" data-dismiss="alert" >&times;</button>
                         <p>Password Successfully Changed! You Can Login Again</p>
                        </div>';
                  }?>
                <form method="post" action="" id="LoginForm">
                  <div id="output"></div>
        <h2>Select The Right Year & Term</h2>               
      <table width="100%" cellpadding="0" cellspacing="10">
        <tr>
          <td>
            <label>Year</label>
          </td>
          <td>
                        <div class="form-group" style="padding-left: 10px;">
                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <select name ="year"  id="year" class="form-control">
                                  <option value="000">Select Year</option>
                                  <?php
                                    $year = date("Y");
                                    $count = $year + 7;
                                    for($i=$year; $i<$count; $i++) {
                                      echo "<option value='$i'>$i</option>";
                                    }
                                  ?>
                                
                                </select>
                          </div>
                           <p id="year_error" align="center"></p>
                        </div>
              </td>
              <td> 
                   <label style="margin-left: 20px;">Term</label> 
              </td>
              <td>       
                            <div class="form-group"  style="padding-left: 10px;">
                          
                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <select name="term" id="term" class="form-control">
                                 <option value="000">Select Term</option>  
                                 <option value="I">I</option>
                                 <option value="II">II</option>
                                 <option value="III">III</option>

                              </select>
                           
                          </div>
                          <p id="term_error" align="center"></p>
                        </div>
                      </td>
                      </tr>
                 <tr>
                  <td>
                      <label>Email/username</label>
                  </td>
                  <td colspan="5">
                   <div class="form-group" style="width: 100%; padding-left: 10px;">
                           
                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" name="username" id="username" placeholder="email" class="form-control">
                          </div>
                          <p id="username_error" style="color: red; text-align: center;"></p>
                    </div>
                  </td>
                  </tr>
                  <tr>
                    <td>
                        <label>password</label>
                    </td>
                    <td colspan="5">
                        <div  class="form-group" style="width: 100%; padding-left: 10px;">
                          <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input type="password" name="password" id="password" placeholder="Enter password" class="form-control">
                          </div>
                          <p id="password_error" align="center"></p>
                        </div>
                    </td>
                    </tr>
                    </table>      
                          <button class="btn btn-warning" type="submit" name="user_login">Login<i class="glyphicon glyphicon-send"></i></button>
                          <div class="">
                    
                    <a href="forget-password.php" name="forgetpass">Forget Password???.</a>
                    </p>
                </div>
                 
                </form>  
          </div>
    </div>
</div>
<?php require_once "includes/footer.php"; ?>

<script type="text/javascript">
       $(document).ready(function(){
        //input validateion during entering data
        $(document).on("input","#username",function(){
            emailValid('username','username_error');
        });
        $(document).on("blur","#year",function(){
            selectionValid("year","year_error");
        });
        $(document).on("blur","#term",function(){
            selectionValid("term","term_error");
        });
        $(document).on("input","#password",function(){
            passwordValid("password","password_error");
        });

        function Login_Valid()
        {
            if(selectionValid("year","year_error")==false)
            {
               return false;
            }else if(selectionValid("term","term_error")==false)
            {
                return false;
            }else if(emailValid('username','username_error')==false)
            {
                return false;
            } else if(passwordValid("password","password_error")==false)
            {
                return false;
            } else
            {
                return true;
            }
        }

         $(document).on("submit","#LoginForm",function(e) {
             // e.preventDefault();
             var username=$("#username").val();
             var password=$("#password").val();
             var year    =$("#year").val();
             var term    =$("#term").val();
             if(Login_Valid()==false){
               return false;
             }else{
              return true;
             }
             
          
         })
       });
    </script>