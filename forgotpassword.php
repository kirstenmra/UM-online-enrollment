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

<div class="container">
    <div class="content">
        <form method ="POST">
        <h1>Forgot Password</h1>
       <p>Please enter your Email address to search for your account</p>
        <label for="uname"><b>Email:</b></label>
       <input type="text" placeholder="Enter Email" name="Email">
        
       <input type="submit" value="Change Password" name="Send">
</form>
   </div>
</div>
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
require 'function/function.php';
$conn = connect();
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Login process
    $Email = $_POST['Email'];
    $query = mysqli_query($conn, "SELECT * FROM students WHERE email_address = '$Email' AND username IS NOT NULL AND password IS NOT NULL");

    
    if(mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_assoc($query);
        $student_id = $row['student_id'];
        $n=8;
        function getpassword($n) {
            $password = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';

            for ($i = 0; $i < $n; $i++) {
                $index = rand(0, strlen($password) - 1);
                $randomString .= $password[$index];
            }

            return $randomString;
        }
        $password = getpassword($n);
        $message = "
        <html>
        <body>
        <h3>Your new Password is ". $password . "</h3>
        </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: '. $Email . "\r\n";
        mail($Email, 'New Password', $message,$headers);
        
        $sql = "UPDATE students SET 
         password = '$password'
        WHERE student_id = $student_id";
        $query = mysqli_query($conn, $sql);
        if($query){
            header("location:login.php");
        }   
    }else{
       ?>
       <script>
        alert("There's no Match Email Address to the database");
        </script>
       <?php
    }
    

}
?>