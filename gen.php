
<?php
session_start();
function is_admin() {
  if(isset($_SESSION['privillage']) && $_SESSION['privillage'] == "administrator") {
    return true;
  } else {
    return false;
  }
}
if(!is_admin())
{
  header("Location:../login.php");
}
if(isset($_GET['form']))
{

    $form =base64_decode($_GET['form']);
    include('grade_action.php');
    // include('generate.inc.php');
    include'aggregate.php';
    require_once "../includes/db.php";
                  
// header("Content-type: application/vnd.ms-word");
// header("Content-Disposition: attachment;Filename=".rand().".doc");
// header("Pragma:no-cache");
// header("Expires: 0");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";

   ?>
 
   <style type="text/css">
     
#myTable {
     margin-bottom: 5px;
      width: 100%;
    border-collapse: collapse; /* Collapse borders*/
    font-size: 15px; /* Increase font-size */
}
#myTable,table,th,td{
   border: 1px solid #000000;
}
#myTable th {
    text-align: left; 
    padding: 2px; 
}
#myTable td {
    text-align: left; /* Left-align text */
    padding: 2px; 
}

#myTable tr {
    border: 1px solid #000000; 
}
.container
{
  margin: auto;
  width: 98%;
}
 </style>
   

   
    <?php
    $sql="SELECT * FROM student INNER JOIN marksheet ON student.Reg_no = marksheet.Reg_no WHERE stream_id IN (SELECT stream_id FROM stream NATURAL JOIN class WHERE c_name='".$form."') AND term_id='".$_SESSION['term_id']."' AND year='".$_SESSION['year']."' ORDER BY total DESC";
          $runst    =mysqli_query($conn,$sql);
     

          $max =mysqli_num_rows($runst);
        
         $no =1;

     
        while($result=mysqli_fetch_assoc($runst))
      {
          $Reg_no = $result['Reg_no'];
          $firstname=$result['firstname'];
          $othername=$result['othername'];
          $stream_id     =$result['stream_id'];
          $gender   =$result['gender'];
          $profilePicture =$result['picture'];
     
          //query to generate aggregates for 7 compulsory subject 
           $sql2="SELECT SUM(grade) AS bestE FROM `grade` WHERE sub_cod IN(SELECT sub_cod FROM subject WHERE status='comp') AND Reg_no='".$Reg_no."' AND term_id='".$_SESSION['term_id']."' ";
          $runst2    =mysqli_query($conn,$sql2);
          while ($agg =mysqli_fetch_assoc($runst2)) {
            $comp =$agg['bestE'];
          }
          //find total compulsory subjects attempted 
          $sqlss="SELECT COUNT(grade) AS bestE FROM `grade` WHERE sub_cod IN(SELECT sub_cod FROM subject WHERE status='comp') AND Reg_no='".$Reg_no."' AND term_id='".$_SESSION['term_id']."' ";
          $runstss    =mysqli_query($conn,$sqlss);
          while ($aggc =mysqli_fetch_assoc($runstss)) {
            $totalCompSubAttempted =$aggc['bestE'];
          }

          //query to find the subject with the minmum grade from optional subjects
           $sql4="SELECT MIN(grade) AS bestOp FROM `grade` WHERE sub_cod IN(SELECT sub_cod FROM subject WHERE status='optional') AND Reg_no='".$Reg_no."' AND term_id='".$_SESSION['term_id']."' ";
          $runst4    =mysqli_query($conn,$sql4);
          while ($aggop =mysqli_fetch_assoc($runst4)) {
            $optionalSub=$aggop['bestOp'];
          }
          //generate aggregate for best 8 done subjects
          $aggr =((int)$comp + (int)$optionalSub);

          $sqlcount="SELECT COUNT(grade) AS totalsub FROM `grade` WHERE Reg_no='".$Reg_no."' AND term_id='".$_SESSION['term_id']."' AND grade !='F 9'";
          $resCount    =mysqli_query($conn,$sqlcount);
          while ($rowC =mysqli_fetch_assoc($resCount)) {
            $totalsubAttempted =$rowC['totalsub'];
          }
        $query_logo = "SELECT * FROM page_contents WHERE page_name='site_logo' LIMIT 1";
          $result_logo = mysqli_query($conn, $query_logo);
          $row_logo = mysqli_fetch_assoc($result_logo);
          $image = $row_logo['page_image'];
    ?>

   <div class="container" style=" border: 1px solid black; border-radius: 10px; padding: 10px; ">
    <!-- <input type="button" value="Print" class="submitbutton" onclick="window.print()"> -->
      <div width="100%">
           <table width="98%" cellpadding="0" cellspacing="0" style="border: none;" >
              <tr style="border: none;">
                <td colspan="2" style="border: none; padding: 5px;">
                  <tr style="border: none;">
                    <td style="border: none; padding: 5px;"><img src="../assets/images/<?php echo $image; ?>" alt="not found" width="80" height="80">
                    </td>
                    <td style="border: none;"><p style=" color: blue; font-size: 20px;" align="center"> PROGRESSIVE REPORT YEAR <?php echo strtoupper( $_SESSION['year']);?> TERM <?php echo strtoupper( $_SESSION['term']);?></p>
                    </td>
                      <td style="border: none; padding: 5px;"><img align="right"  src='../assets/images/student-images/<?php echo $profilePicture;?>' alt="not found" width="80" height="80">
                      </td>
                    </tr>
                </td>
              </tr>
              <tr style="border: none; padding: 5px;">
                 <td  style="border: none; padding: 5px;">STUDENT NO:</td>
                 <td style="border: none; padding: 5px;"><p align="center"><?php echo $Reg_no; ?></p></td>
                 <td style="border: none; padding: 5px;"><p align="right">SEX: <?php echo $gender;?></p></td>
             </tr>
             <tr style="border: none;">
                <td style="border: none; padding: 5px;">STUDENT NAME:</td>
                 <td style="border: none; padding: 5px;"><p align="center"><strong><?php echo strtoupper($firstname);?> <?php echo strtoupper($othername)?></strong></p></td>
                <td style="border: none; padding: 5px;"><p align="right">FORM: <?php echo $stream;?></p></td>
             </tr>
             <tr style="border: none; padding: 5px;">
                <td style="border: none; padding: 5px;">POSITION IN CLASS:</td>
                <td style="border: none; padding: 5px;"><p align="center"> <?php echo $no; ?></p></td>
                <td style="border: none; padding: 5px;"><p align="right">OUT OF:<?php echo $max ?></p></td>
  
             </tr>
        </table>
        </div>
             <table id="myTable">
       <tr class="header">
            <thead>
                 <th>SUBJECT</th>
                 <th>CODE</th>
                  <th>MOT/30</th>
                 <th>EOT/70</th>
                 <th>TOTAL/100</th>
                <th>GRADE</th>
                <th>REMARKS</th>
                <th>INITIALS</th>
             </thead>
          </tr>
          
          <tbody>

            
             <?php
              $sqlst="SELECT SUM(total) AS sumT FROM grade WHERE Reg_no='".$Reg_no."' AND term_id='".$_SESSION['term_id']."'";
                $ress =mysqli_query($conn,$sqlst);
                while ($row = mysqli_fetch_assoc($ress)) {
                    $sumt = $row['sumT'];
                }
                
                  $sub_cod="";
                $sqlst="SELECT sub_cod,mid_term,end_term,total,initials FROM grade WHERE Reg_no='".$Reg_no."' AND term_id='".$_SESSION['term_id']."'";
                $ress1 =mysqli_query($conn,$sqlst);
                while ($row1 = mysqli_fetch_assoc($ress1))
                {
                    $sub_cod = $row1['sub_cod'];
                    $mid_term =$row1['mid_term'];
                    $end_term =$row1['end_term'];
                    $total    =$row1['total'];
                    $initials =$row1['initials'];
                
                $sub="SELECT name FROM subject WHERE sub_cod='".$sub_cod."'";
                $ress2 =mysqli_query($conn,$sub);
                while ($row2 = mysqli_fetch_assoc($ress2)) {
                    $name = $row2['name'];
                }
    echo"<tr>";
             echo "<td>".$name."</td>
                  <td>".$sub_cod."</td>
                  <td>".$mid_term."</td>
                  <td>".$end_term."</td>
                  <td>".$total."</td>
                  <td>".grade($total)." </td>
                  <td>".remarks($total)." </td>
                  <td>".$initials." </td> ";
       echo "</tr>";

            }         
      echo"<tr style='border:1px solid #ffffff;'>";
      echo"<td></td>";
      echo"<td></td>";
      echo"<td></td>";
      echo"<td></td>";
       echo "<td>   TOTAL = ".$sumt."</td>";
      echo"<td></td>";
      echo"<td></td>";
      echo"<td></td>";
      echo "</tr>";    
            ?>
          </tbody>
          
        </table>
      <table width="100%" style="border: none;">
              <tr style="border: none;">
                <td width="40%" style="border: none;">Aggregates for 8 best done Subjects: </td>
                <td style="border: none;"><span style="margin-left: 10px;"><?php echo $aggr; ?></span> </td>
                <td style="border: none;"><span style="margin-left: 10px;"> Division: </span></td>
                <td style="border: none;"> <span style="margin-left: 10px;"><?php echo Division2($aggr,$totalsubAttempted,$totalCompSubAttempted);?></span></td>
              </tr>
           </table>

          <div width="99%" style="border-radius: 10px;">
           <table width="100%" style="border: 1px solid black;">
              <tr style="border: none;">
                <td style="border:none; "></td>
                <td style="border: none;">75 - 100= D1</td>
                <td style="border: none;">70 - 74 = C3</td>
                <td style="border: none;">55 - 59 = C5</td>
                <td colspan="2" style="border: none;">45 - 49 = P7</td>
              </tr>
              <tr style="border: none;">
                 <td colspan="5" style="border: none;">GRADE</td>
                 <td style="border: none;">00 - 39 = F9</td>
             </tr>
             <tr style="border: none;">
                <td width="15%" style="border: none;"></td>
                <td style="border: none;">70 - 74  = D2</td>
                <td style="border: none;">60 - 64 = C4</td>
                <td style="border: none;">50 - 54 = C6</td>
                <td style="border: none;">40 - 44 = P8</td>
             </tr>
           </table>
        </div>
          <table width="99%" style="border: none;">
             <tr style="border: none;">
               <td width="98%" style="border: none;">Class Teacher's Remarks: ..................................................................................................................................</td>
             </tr>
             <tr style="border: none;">
               <td width="99%" style="border: none;">....................................................................................................................................................................................</td>
             </tr>
             <tr style="border: none;">
               <td width="99%" style="border: none;">................................................................................................................................................................................</td>
             </tr>
             <tr style="border: none;">
               <td width="98%" style="border: none;">Head Teacher's Remarks: ........................................................................................................................................</td>
             </tr>
             <tr style="border: none;">
               <td width="99%" style="border: none;">...............................................................................................................................................................................</td>
             </tr>
             <tr style="border: none;">
               <td width="99%" style="border: none;">.............................................................................................................................................................................</td>
             </tr>
             <tr style="border: none;">
               <td width="98%" style="border: none;">PROMOTED TO/REPEAT: ...............................................................................................................................</td>
             </tr>
             <tr style="border: none;">
               <td width="99%" style="border: none;">...........................................................................................................................................................................</td>
             </tr>
              <td width="99%" style="border: none;">...........................................................................................................................................................................</td>
             </tr>
           </table>
        
        <?php
           $nt="SELECT * FROM term WHERE term_id='".$_SESSION['term_id']."'";
           $res=mysqli_query($conn,$nt);
           $nts=mysqli_fetch_array($res);
          ?>
       <div>
         <table width="96%" style="border: none; padding: 5px;">
            <tr style="border: none;" >
              <td width="30%" style="border: none;">NEXT TERM BEGINS ON:</td>
              <td style="border: none; text-align: center;"><?php echo $nts['start_date']; ?></td>
            </tr>
        </table>
      </div>
      <div style="text-align: center; padding: 5px;">
         THIS REPORT CARD IS INVALID WITHOUT A SCHOOL STAMP
      </div>
  </div>
  <br>
    <?php
       $no++; 
         }           
echo "</body>";
echo "</html>";
}
?>

<script type="text/javascript">
       window.print();
 </script> 

    