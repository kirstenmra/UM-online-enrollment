<?php 
require 'function/function.php';
session_start();
if (isset($_SESSION['student_id'])) {
    header("location:login.php");
}
session_destroy();
session_start();
ob_start(); 
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://kit.fontawesome.com/57ce411ce4.js" crossorigin="anonymous"></script>
<meta charset="utf-8">
<title>University of Manila</title>
<link rel="stylesheet" href="css/main.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif&display=swap" rel="stylesheet">
</head>
<body>
	<div class ="logo">
		<img src="img/Logo.png" alt="logo"></div>
<h1 class="heading">The University of Manila</h1>
<h2 class="heading2">• Patria • Sciencia • Virtus </h1>
<div class="navbar">
  <a href="home.php">Home</a>
  <a class="active" href="login.php">Login</a>
  <a  href="basic-info.php">Admission</a>
</div>
<form method="post" >
<div class="container">
    <div class="content">
       <label for="uname"><b>Username:</b></label>
       <input type="text" placeholder="Enter Username" name="uname">
   
       <label for="psw"><b>Password:</b></label>
       <input type="password" placeholder="Enter Password" name="psw">
   
       <br><button class="button1" type="submit">Login</button></br>
       <br><a href="forgotpassword.php">Forgot password?</a></br>
     </div>
   </div>
</form>
<footer>
        <div class="footer-content">
            <p><i class="fas fa-map-marker-alt"></i> 546 MV delos Santos St., Sampaloc, Manila, Metro Manila</p>
            <p><i class="fas fa-phone"></i> 8735-5085</p>
            <p><i class="far fa-envelope"></i> umnla.edu.ph@gmail.com</p>
        </div>
    </footer>
</body>
</html>
<?php
$conn = connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Login process
  $Username = $_POST['uname'];
  $Password = $_POST['psw'];
  $query = mysqli_query($conn, "SELECT * FROM students WHERE username = '$Username' AND password = '$Password'");

  $query1 = mysqli_query($conn, "SELECT * FROM users WHERE username = '$Username' AND user_password = '$Password'");

  if($query){
      if(mysqli_num_rows($query) == 1) {
          $row = mysqli_fetch_assoc($query);
          $_SESSION['student_id'] = $row['student_id'];
          header("location:myprofile.php");
      }
    }
    if($query1){
      if(mysqli_num_rows($query1) == 1) {
          $row1 = mysqli_fetch_assoc($query1);
          $_SESSION['user_id'] = $row1['user_id'];
          header("location: admin/index.php");
      }
    }
  }
?>