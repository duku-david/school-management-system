<?php require_once "includes/header.php"; ?>

<?php require_once "includes/banner.php" ?>
  
<div class="about-section section-padding admission-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 ">
                <h4 class="text-center"><strong>Enter Registration number and Select Term to get result</strong></h4>
                <form action="" method="post">
                    <div class="form-group">
                        <label>Registration No</label>
                        <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" name="Reg_no" placeholder="Enter Registration number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Exam Type</label>
                        <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                        <select name="exam_type" id="" class="form-control">
                            <option value="mid_term">Mid Term Test</option>
                            <option value="end_term">End Term Test</option>
                            <option value="all">Both Mid & End Term Test</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Term</label>
                         <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <select name="term" id="term" class="form-control">
                                 <option value="000">Select Term</option>  
                                 <option value="1">I</option>
                                 <option value="2">II</option>
                                 <option value="3">III</option>

                              </select>
                           
                          </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" name="result_publish" value="Get Result">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    if(isset($_POST['result_publish'])) {
        $Reg_no = $_POST['Reg_no'];
        $exam_type = $_POST['exam_type'];
         $term = $_POST['term'];
         if($exam_type=="all")
         {
            $query = "SELECT * FROM grade WHERE mid_term AND Reg_no='$Reg_no' AND term_id='$term'";
            $get_res = mysqli_query($conn, $query) or die(mysqli_error($conn));
            $getnow = mysqli_fetch_assoc($get_res);
            $fullname = get_name_by_registration_number($getnow['Reg_no']);
            $image = get_image_by_registration_number($getnow['Reg_no']);
        }else
        {
         $query="SELECT * FROM grade WHERE $exam_type AND Reg_no='$Reg_no' AND term_id='$term'";
            $get_res = mysqli_query($conn, $query) or die(mysqli_error($conn));
            $getnow = mysqli_fetch_assoc($get_res);
            $fullname = get_name_by_registration_number($getnow['Reg_no']);
            $image = get_image_by_registration_number($getnow['Reg_no']);
        }

        

        if(mysqli_num_rows($get_res) > 0) {
    ?>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-info">
                    <div class="panel-heading"><h3>Here is your Result</h3></div>
                    <div class="panel-body">
                        <div class="col-md-8">
                             <h4>Name: <strong><?php echo $fullname; ?></strong></h4>
                             <h4>Registration Number:<strong><?php echo $Reg_no; ?></strong></h4>
                        </div>
                        <div class="col-md-4">
                            <h4 class="pull-right"><img width="50px" height="50px" src="assets/images/student-images/<?php echo $image; ?>"></h4>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <?php
                                $totalMarks = 0;
                                 $totalMarkM = 0;
                                  $totalMarkE = 0;
                                  $totalMarkT = 0;
                                 if($exam_type=="all")
                                 {
                                    ?>
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Mid term</th>
                                        <th>End_term</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                            <?php 
                                    
                                   
                                    $result = mysqli_query($conn, $query);
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $subject_id = $row['sub_cod'];
                                        $subject = get_subject_name_by_id($subject_id);
                                        $mid_term = $row['mid_term'];
                                        $end_term=$row['end_term'];
                                         $total=$row['total'];
                                        $totalMarkM=$totalMarkM + $mid_term;
                                        $totalMarkE =$totalMarkE+ $end_term;
                                        $totalMarkT =$totalMarkT+ $total;
                                        echo "<tr>";
                                        echo "<td>$subject</td>";
                                        echo "<td>$mid_term</td>";
                                         echo "<td>$end_term</td>";
                                         echo "<td>$total</td>";
                                        echo "</tr>";
                                    }
                                      echo '<tr>
                                <th>Total</th>
                                <th>'.$totalMarkM.'</th>
                                <th>'.$totalMarkE.'</th>
                                <th>'.$totalMarkT.'</th>
                            </tr>';  
                                 }else
                                 {
                                    ?>
                                    <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th><?php echo $exam_type; ?></th>
                                    </tr>
                                </thead>
                                    <?php
                                    $result = mysqli_query($conn, $query);
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $subject_id = $row['sub_cod'];
                                        $subject = get_subject_name_by_id($subject_id);
                                        $marks = $row[$exam_type];
                                        $totalMarks = $totalMarks + $marks;

                                        echo "<tr>";
                                        echo "<td>$subject</td>";
                                        echo "<td>$marks</td>";
                                        echo "</tr>";
                                    }
                                    echo '<tr>
                                <th>Total</th>
                                <th>'.$totalMarks.'</th>
                            </tr>';  
                                 }
                                
                            ?>
                            
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <h2 class="text-center">Please fill up the correct information.</h2>
    <?php } } ?>
</div>

<?php require_once "includes/footer.php"; ?>