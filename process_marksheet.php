
<?php
  //require_once "../../functions2.php";
	require_once "../../includes/db.php";
if(isset($_POST['subject']))
{
          $subject = $_POST['subject'];
         $stream_id = $_POST['stream_id'];
         $initials=$_POST['initials'];
         $year    =$_POST['year'];
          $sql="SELECT * FROM teacher WHERE initials='".strtoupper($initials)."'";
          $sql1="SELECT * FROM subjecttakenbyteacher WHERE initials ='".$initials."' AND sub_cod='".$subject."' AND stream_id='".$stream_id."' AND year='".$year."'";

         $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
         $result_check=mysqli_num_rows($result);
         $result1 = mysqli_query($conn,$sql1) or die(mysqli_error($conn));
         $result_check1=mysqli_num_rows($result1);
       $response ='';  
    if($subject =="000"){
        $response.='Please Select Subject!';
    
    } else if($stream_id =="000"){
    
      $response.='Please Select Class!';
     
      }else if($result_check < 1)
      {
          $response.='Please Enter Correct initials!';
      }else if($result_check1 < 1)
      {
         $sql ="SELECT name FROM subject WHERE sub_cod='".$subject."'";
        $res =mysqli_query($conn,$sql);
        $row =mysqli_fetch_assoc($res); 
           $sub =$row['name'];
         $sql2 ="SELECT * FROM stream NATURAL JOIN class WHERE stream_id='".$stream_id."'";
        $res2 =mysqli_query($conn,$sql2);
        $row2 =mysqli_fetch_assoc($res2); 
           $stream=$row2['stream'];
           $class=$row2['c_name'];
          $response.='You Are not Registered for '.$sub.' in S '.$class.' '.$stream.', '.$year.'</div>';

      } else{
          $_SESSION['initials']=$initials;
          $_SESSION['subject'] =$subject;
          $_SESSION['stream_id'] =$stream_id;
	header("Location:marksheet_display.php");

   }
   echo $response;
}  
	
?>