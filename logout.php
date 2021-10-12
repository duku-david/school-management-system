<?php
ob_start();
session_start();
require_once("includes/db.php");
session_destroy();
mysqli_close($conn);
header("Location: login.php");