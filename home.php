<?php
require 'function/function.php';
session_start();

?>
<!DOCTYPE html>
<html>

<head>
  <script src="https://kit.fontawesome.com/57ce411ce4.js" crossorigin="anonymous"></script>
  <meta charset="utf-8">
  <title>University of Manila</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link  href="css/style.css" rel="stylesheet">
</head>

<body>
  <div class="logo">
    <img src="img/Logo.png" alt="logo">
  </div>
  <h1 class="heading">The University of Manila</h1>
  <h2 class="heading2">• Patria • Sciencia • Virtus </h1>
  <?php
  if (!isset($_SESSION['student_id'])) {
    ?><div class="navbar">
    <a class = "active" href="home.php">Home</a>
    <a href="login.php">Login</a>
    <a  href="basic-info.php">Admission</a>
  </div><?php
  }
  else{
    ?><div class="navbar">
    <a class="active" href="home.php">Home</a>
    <a href="myprofile.php">My Profile</a>
    <?php
      $current_id = $_SESSION['student_id'];
      session_destroy();
      session_start();
      $_SESSION['student_id'] = $current_id;
      ob_start(); 
      $conn = connect();
      $sql = "SELECT * FROM students a 
      JOIN enrollment b ON a.student_id = b.student_id
      WHERE a.student_id = $current_id";
      $result = $conn->query($sql);
   if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
        if($row['user_id'] == null){ ?>
            <a  href="">Wait For the Email Confirmation</a>
       <?php }else{ ?>
        <a  href="regcard.php">Registration Card</a>

       <?php } ?>
    <?php }else { ?>
        <a  href="admission.php">Admission</a>
   <?php } ?>
  </div><?php
  }
?>


    <div class="column1">
             <img src="img/enrollmentlogo.png" alt="enroll">
                <button onclick="location.href = 'basic-info.php';">Enroll Now</button>
                  <meta name="viewport" content="width=device-width, initial-scale=1">
                    <h1>Enrollment is ongoing</h1>
                    <p>(FOR 2022 - 2023)</p>
                    <br><p>Online Enrollment Available:</p></br>
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