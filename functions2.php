<?php

	require_once "includes/db.php";
	require_once "includes/Util.php";
	session_start();
	date_default_timezone_set('Asia/Dhaka'); 

//******global function
	function clean_data( $data ) {
	global $conn;
	$cleaned_data = mysqli_real_escape_string($conn, trim($data));

	return $cleaned_data;
}
//login system
function user_login() {
	global $conn;
	$error_m= '';

	if(isset($_POST['user_login'])) 
	{
		$username = mysqli_real_escape_string($conn,$_POST['username']);
	     $password = mysqli_real_escape_string($conn,$_POST['password']);
	     $year = mysqli_real_escape_string($conn,$_POST['year']);
	     $term = mysqli_real_escape_string($conn,$_POST['term']);
	     
	     //Error handler
	     //check if inputs are empty

	         if(empty($username))
	         {
	          $error_m.="Please enter username";
	          }else if(empty($password))
	          {
	              $error_m.="please enter password";
	          }else if($year =="000")
	          { 
	            $error_m.="please select year";
	          }else if($term =="000")
	          {
	            $error_m.="please select term";
	          }else
	          {
	                $sql = "SELECT * FROM login INNER JOIN teacher ON teacher.initials=login.initials WHERE username='".$username."' AND password = '".md5($password)."'";
	               $result = mysqli_query($conn,$sql);
	               
	               $sqls = "SELECT * FROM login WHERE initials IN(SELECT initials FROM teacher WHERE username='".$username."') AND status ='active' AND password = '".md5($password)."'";
	               $resultstatus = mysqli_query($conn,$sqls) or die(mysqli_error($conn));
	               $_SESSION['year'] = $year;
	               $sqlR ="SELECT * FROM `term` WHERE term='".$term."'";
	               $termResult =mysqli_query($conn,$sqlR);
	               while($termMember =mysqli_fetch_assoc($termResult))
	               {
	                  $_SESSION['term_id'] = $termMember['term_id'];
	                   $_SESSION['term'] = $termMember['term'];
	               }
	                     
	                $resultcheck = mysqli_num_rows($result);
	               
	                 if( $resultcheck < 1 )
	                 {
	                  
	                     $error_m.="Invalid Login Details".$username;
	                         
	                 }else if(mysqli_num_rows($resultstatus) < 1 )
	                 {
	                   $error_m.="Your Account is Temporay blocked";
	                         
	                 }
	                 else if($year > date('Y'))
	                 {
	                    
	                    $error_m.= $year." is out of bound";
	                 }else
	                 {
	                         if($row = mysqli_fetch_assoc($result))
	                         {
	                       
	                         	$hashedpwdcheck =md5($row['password']);
	                            if($hashedpwdcheck == false)
		                        {

		                        } elseif($hashedpwdcheck == true)
		                        {
	                              // log in user here
	                                $_SESSION['staff_id'] = $row['staff_id'];
	                                $_SESSION['username'] = $row['username'];
	                                $_SESSION['picture'] = $row['picture'];
	                                $_SESSION['privillage'] = $row['privillage'];
	                                $_SESSION['initials'] = $row['initials'];
	                                $_SESSION['password'] = $password;
	                                if($row['privillage']=="administrator")
	                                {
	                                  header("Location:school-admin/index.php");

	                                }else if($row['privillage']=="teacher")
	                                {
	                                  header("Location:teacher-dashboard/index.php");
	                                }else
	                                {
	                                      $error_m.="Error occured";
	                                }
	                         	}
	                  		}

	             		}

	         }
	     }
	return $error_m;
}

/*****************************
@ Events
******************************/
//add new event from dashboard
function add_new_event() {
	global $conn;
	if(isset($_POST['add_event_btn'])) {
		$event_title = clean_data($_POST['event_title']);
		$event_desc = clean_data($_POST['event_desc']);
		$event_image = $_FILES['event_image']['name'];
		$event_image_tmp = $_FILES['event_image']['tmp_name'];

		$path = "../assets/images/event-images/{$event_image}";

		move_uploaded_file($event_image_tmp, $path);

		if(!empty($event_title)) {
			$query = "INSERT INTO event (event_title, event_desc, event_image, event_date) VALUES ('$event_title', '$event_desc', '$event_image', now())";
			$result = mysqli_query($conn, $query);
			if(!$result) {
				die("Error." . mysqli_error($conn));
			} else {
				header("Location: events.php?action=add_new&message=success");
			}

		}
	}
}

//show event data in dashboard
function showEventData() {
	$event = [];
	global $conn;
	if(isset($_GET['action']) && $_GET['action'] == "edit_event") {
		$get_the_id = $_GET['e_id'];
		$query = "SELECT * FROM event WHERE id=$get_the_id";
		$result = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_assoc($result)) {
			$event['event_title'] = $row['event_title'];
			$event['event_desc'] = $row['event_desc'];
			$event['event_image'] = $row['event_image'];
		}
	}
	return $event;
}

//update event from dashboard
function update_event() {
	global $conn;
	$get_the_id = $_GET['e_id'];
	if(isset($_POST['update_event_btn'])) {
		$event_title = clean_data($_POST['event_title']);
		$event_desc = clean_data($_POST['event_desc']);

		$event_image = $_FILES['event_image']['name'];
		$event_image_tmp = $_FILES['event_image']['tmp_name'];

		$path = "../assets/images/event-images/{$event_image}";

		if(!empty($event_image)) {
			move_uploaded_file($event_image_tmp, $path);
			$query_image = "UPDATE event SET event_image='$event_image' WHERE id=$get_the_id";
			$result_image = mysqli_query($conn, $query_image);
		}

		if(!empty($event_title) && !empty($event_desc)) {
			$query = "UPDATE event SET event_title='$event_title', event_desc='$event_desc', event_date=now() WHERE id=$get_the_id";
			$result = mysqli_query($conn, $query);
			if(!$result) {
				die("Error." . mysqli_error($conn));
			} else {
				header("Location: events.php?action=edit_event&e_id=$get_the_id&message=success");
			}
		}
	}
}


// if user logged in
function is_user_logged_in() {
	if(isset($_SESSION['privillage'])){
		return true;
	} else {
		return false;
	}
}

	// if admin
function is_admin() {
	if(isset($_SESSION['privillage']) && $_SESSION['privillage'] == "administrator") {
		return true;
	} else {
		return false;
	}
}

// if teacher
function is_teacher() {
	if(isset($_SESSION['privillage']) && $_SESSION['privillage'] == "teacher") {
		return true;
	} else {
		return false;
	}
}


	function total_subject() {
	global $conn;
	$query = "SELECT sub_cod FROM subject";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	return mysqli_num_rows($result);
}

function total_teacher() {
	global $conn;
	$query = "SELECT staff_id FROM teacher";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	return mysqli_num_rows($result);
}

function total_students() {
	global $conn;
	$query = "SELECT stud_id FROM student WHERE year='".$_SESSION['year']."'";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	return mysqli_num_rows($result);
}

function get_school_name() {
	global $conn;
	$query = "SELECT * FROM page_options WHERE school_meta_key='school_name'";
	$result = mysqli_query($conn, $query);
	if(mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$school_name = $row['school_meta_value'];
	} else {
		$school_name = 'DEMO SCHOOL';
	}
	return $school_name;
}
function get_school_name1() {
	global $conn;
	$query = "SELECT * FROM page_options WHERE school_meta_key='school_name'";
	$result = mysqli_query($conn, $query);
	if(mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$school_name = str_replace($row['school_meta_value'], "PS",$row['school_meta_value']);
	} else {
		$school_name = 'PP';
	}
	return $school_name;
}
function get_school_address() {
	global $conn;
	$query = "SELECT * FROM page_options WHERE school_meta_key='school_address'";
	$result = mysqli_query($conn, $query);
	if(mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$school_addr = $row['school_meta_value'];
	} else {
		$school_addr = 'Pagrinya, Senior';
	}
	return $school_addr;
}

/// get name by session
function get_name_by_session() {
	global $conn;
	$fullName = '';
	if(isset($_SESSION['username'])) {
		$session_user = $_SESSION['username'];
		$query = "SELECT username FROM login WHERE username='$session_user' LIMIT 1";
		$result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);

		$username = $row['username'];
		$fullName = $username;
	}
	return $fullName;
}

//get name by Registration number
function get_name_by_registration_number($Reg_no) {
	global $conn;
	$query = "SELECT firstname, othername FROM student WHERE Reg_no='$Reg_no'";
	$result = mysqli_query($conn, $query);

	$row = mysqli_fetch_assoc($result);

	return $row['firstname']. " " .$row['othername'];
}

//get name by Registration number
function get_image_by_registration_number($Reg_no) {
	global $conn;
	$query = "SELECT picture FROM student WHERE Reg_no='$Reg_no'";
	$result = mysqli_query($conn, $query);

	$row = mysqli_fetch_assoc($result);

	return $row['picture'];
}

function get_term_by_session() {
	global $conn;
	$fullName = '';
	if(isset($_SESSION['username'])) {
		$session_user = $_SESSION['username'];
		$query = "SELECT username FROM login WHERE username='$session_user' LIMIT 1";
		$result = mysqli_query($conn, $query);

		$row = mysqli_fetch_assoc($result);

		$username = $row['username'];
		$fullName = $username;
	}
	return $fullName;
}

//
function get_subject_name_by_id($id) {
	global $conn;
	$query = "SELECT name FROM subject WHERE sub_cod='$id'";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	$row = mysqli_fetch_assoc($result);

	return $row['name'];
}


function total_students_by_class($class) {
	global $conn;
	$query = "SELECT stud_id FROM student INNER JOIN stream ON student.stream_id=stream.stream_id WHERE stream.c_id=$class";
	$result = mysqli_query($conn, $query);
	return mysqli_num_rows($result);
}

function total_attendance_today_by_class($class) {
	global $conn;
	$thetoday = date("Y-m-d");
	$query = "SELECT studentattendence.stream_id FROM studentattendence INNER JOIN stream ON studentattendence.stream_id=stream.stream_id WHERE stream.c_id='$class' AND studentattendence.date='$thetoday' AND studentattendence.attendance='Y'";
	$result = mysqli_query($conn, $query);
	if(!$result) {
		die(mysqli_error($conn));
	}
	return mysqli_num_rows($result);
}

//add new notice from dashboard
function add_new_notice() {
	global $conn;
	if(isset($_POST['add_notice_btn'])) {
		$notice_title = clean_data($_POST['notice_title']);
		$notice_desc = clean_data($_POST['notice_desc']);

		if(!empty($notice_title) && !empty($notice_desc))
		{
			$query = "INSERT INTO notice (notice_title, notice_desc, notice_date) VALUES ('$notice_title', '$notice_desc', now())";
			$result = mysqli_query($conn, $query);
			if(!$result) {
				die("Error." . mysqli_error($conn));
			} else {
				header("Location: notices.php?action=add_new&message=success");
			}

		}else
		{
			return "All Fields Are Required";
		}
	}
}

//show notice data in dashboard
function showNoticeData() {
	$notice = [];
	global $conn;
	if(isset($_GET['action']) && $_GET['action'] == "edit_notice") {
		$get_the_id = $_GET['n_id'];
		$query = "SELECT * FROM notice WHERE id=$get_the_id";
		$result = mysqli_query($conn, $query);
		while ($row = mysqli_fetch_assoc($result)) {
			$notice['notice_title'] = $row['notice_title'];
			$notice['notice_desc'] = $row['notice_desc'];
		}
	}
	return $notice;
}

//update notice from dashboard
function update_notice() {
	global $conn;
	$get_the_id = $_GET['n_id'];
	if(isset($_POST['update_notice_btn'])) {
		$notice_title = clean_data($_POST['notice_title']);
		$notice_desc = clean_data($_POST['notice_desc']);

		if(!empty($notice_title) && !empty($notice_desc)) {
			$query = "UPDATE notice SET notice_title='$notice_title', notice_desc='$notice_desc', notice_date=now() WHERE id=$get_the_id";
			$result = mysqli_query($conn, $query);
			if(!$result) {
				die("Error." . mysqli_error($conn));
			} else {
				header("Location: notices.php?action=edit_notice&n_id=$get_the_id&message=success");
			}

		}
	}
}

/*******************************
@ Page contents
*******************************/
//about page
function about_content_update() {
	global $conn;
	if(isset($_POST['save_about_content'])) {
		$content = $_POST['about_content'];
		$query = "SELECT * FROM page_contents WHERE page_name='about_page'";
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) <= 0) {
			$insert_query = "INSERT INTO page_contents(page_name, page_text) VALUES('about_page', '$content')";
		} else {
			$insert_query = "UPDATE page_contents SET page_text='$content' WHERE page_name='about_page'";
		}
		$final_result = mysqli_query($conn, $insert_query);
	}
}

//teacher page
function teacher_content_update() {
	global $conn;
	if(isset($_POST['save_teacher_content'])) {
		$content = $_POST['teacher_content'];
		$query = "SELECT * FROM page_contents WHERE page_name='teacher_page'";
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) <= 0) {
			$insert_query = "INSERT INTO page_contents(page_name, page_text) VALUES('teacher_page', '$content')";
		} else {
			$insert_query = "UPDATE page_contents SET page_text='$content' WHERE page_name='teacher_page'";
		}
		$final_result = mysqli_query($conn, $insert_query);
	}
}

function school_address_update() {
	global $conn;
	if(isset($_POST['save_school_address'])) {
		$school_address = $_POST['school_address'];
		$query = "SELECT * FROM page_options WHERE school_meta_key='school_address'";
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) <= 0) {
			$insert_query = "INSERT INTO page_options(school_meta_key, school_meta_value) VALUES('school_address', '$school_address')";
		} else {
			$insert_query = "UPDATE page_options SET school_meta_value='$school_address' WHERE school_meta_key='school_address'";
		}
		$final_result = mysqli_query($conn, $insert_query);
	}
}

function school_name_update() {
	global $conn;
	if(isset($_POST['save_school_name'])) {
		$school_name = $_POST['school_name'];
		$query = "SELECT * FROM page_options WHERE school_meta_key='school_name'";
		$result = mysqli_query($conn, $query);

		if(mysqli_num_rows($result) <= 0) {
			$insert_query = "INSERT INTO page_options(school_meta_key, school_meta_value) VALUES('school_name', '$school_name')";
		} else {
			$insert_query = "UPDATE page_options SET school_meta_value='$school_name' WHERE school_meta_key='school_name'";
		}
		$final_result = mysqli_query($conn, $insert_query);
		if(!$final_result) die(mysqli_error($conn));
	}
}

//admission page
function admission_content_update() {
	global $conn;
	if(isset($_POST['save_admission_content'])) {
		$content = $_POST['admission_content'];
		$query = "SELECT * FROM page_contents WHERE page_name='admission_page'";
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) <= 0) {
			$insert_query = "INSERT INTO page_contents(page_name, page_text) VALUES('admission_page', '$content')";
		} else {
			$insert_query = "UPDATE page_contents SET page_text='$content' WHERE page_name='admission_page'";
		}
		$final_result = mysqli_query($conn, $insert_query);
	}
}

// gallery content
function gallery_content_update() {
	global $conn;
	if(isset($_POST['save_gallery_content'])) {
		$content 		= $_FILES['gallery_content']['name'];
		$content_tmp 	= $_FILES['gallery_content']['tmp_name'];

		$new_path = '../assets/images/gallery-image/'.$content;

		move_uploaded_file($content_tmp, $new_path);

		if(!empty($content)) {
			$insert_query = "INSERT INTO page_contents(page_name, page_image) VALUES('gallery_page', '$content')";
			$final_result = mysqli_query($conn, $insert_query);
		}
	}
}
function delete_gallery_image() {
	global $conn;
	if(isset($_GET['delete-image'])) {
		$id = $_GET['delete-image'];
		$query = "DELETE FROM page_contents WHERE id=$id";
		$res = mysqli_query($conn, $query);
		if($res) {
			header("Location: content_gallery.php");
		}
	}
}

function logo_content_update() {
	global $conn;
	if(isset($_POST['save_logo_content'])) {

		$content 		= $_FILES['logo_content']['name'];
		$content_tmp 	= $_FILES['logo_content']['tmp_name'];

		$new_path = '../assets/images/'.$content;

		move_uploaded_file($content_tmp, $new_path);

		$query = "SELECT * FROM page_contents WHERE page_name='site_logo'";
		$result = mysqli_query($conn, $query);
		if(mysqli_num_rows($result) <= 0) {
			$insert_query = "INSERT INTO page_contents(page_name, page_image) VALUES('site_logo', '$content')";
		} else {
			$insert_query = "UPDATE page_contents SET page_image='$content' WHERE page_name='site_logo'";
		}
		$final_result = mysqli_query($conn, $insert_query);
	}
}


?>