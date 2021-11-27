<?php 
require 'function/function.php';
session_start();
if (!isset($_SESSION['student_id'])) {
    header("location:login.php");
}
$current_id = $_SESSION['student_id'];
session_destroy();
session_start();
$_SESSION['student_id'] = $current_id;
ob_start(); 
// Establish Database Connection
$conn = connect();
$sql = "SELECT * FROM students a 
  JOIN enrollment b ON a.student_id = b.student_id
  JOIN curriculums c ON b.curriculum_id = c.curriculum_id
  JOIN semester d ON b.semester_id = d.semester_id
  WHERE a.student_id = $current_id";
  $result = $conn->query($sql);
  $row = mysqli_fetch_assoc($result);
  $yearlevel_id = $row['yearlevel_id'];
  $semester_id = $row['semester_id'];

$sql = "SELECT * FROM students a 
JOIN enrollment b ON a.student_id = b.student_id
JOIN curriculums c ON b.curriculum_id = c.curriculum_id
JOIN curriculum_details d ON d.curriculum_id = c.curriculum_id
JOIN subjects e ON d.subject_id = e.subject_id
JOIN yearlevel f ON b.yearlevel_id = f.yearlevel_id
JOIN semester g ON b.semester_id = g.semester_id
JOIN sections h ON b.section_id = h.section_id
WHERE d.yearlevel_id = $yearlevel_id AND a.student_id = $current_id AND d.semester_id = $semester_id";
$result = $conn->query($sql);

$row = mysqli_fetch_assoc($result);
$yearlevel = $row['year_level'];
$semester = $row['semester_name'];
$section = $row['section_name'];
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://kit.fontawesome.com/57ce411ce4.js" crossorigin="anonymous"></script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>University of Manila</title>
<link rel="stylesheet" href="css/main.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif&display=swap" rel="stylesheet">
</head>
<body>
	<section>
  <div class ="logo">
		<img src="img/Logo.png" alt="logo"></div>
<h1 class="heading">The University of Manila</h1>
<h2 class="heading2">• Patria • Sciencia • Virtus </h1>
</div>
</section>

<?php
  if (!isset($_SESSION['student_id'])) {
    ?><div class="navbar">
    <a href="home.php">Home</a>
    <a class="active" href="login.php">Login</a>
    <a  href="basic-info.php">Admission</a>
  </div><?php
  }
  else{
    ?><div class="navbar">
    <a href="home.php">Home</a>
    <a href="myprofile.php">My Profile</a>
    <?php
   if ($result->num_rows > 0) {
        if($row['user_id'] == null){?>
            <a  href="">Wait For the Email Confirmation</a>
       <?php }else{ ?>
        <a class="active" href="admin/print-card.php">Registration Card</a>

       <?php } ?>
    <?php }else { ?>
        <a class="active" href="admission.php">Admission</a>
   <?php } ?>
  </div><?php
  }
?>


<div class="container4">
		<h3>List of Subjects</h3>
        <h3><?php echo $row['name'] . " - " . $row['year_level'] . ", " . $row['semester_name']; ?></h3>
        <table  id="regcard">
          <thead>
          <tr>
            <th style="text-align:center";>Grade/Year</th>
            <th style="text-align:center";>Subjects</th>
            <th style="text-align:center";>Units</th>
          </tr>
          </thead>
          <tbody>
          <td style="text-align:center"; rowspan="<?php echo $result->num_rows ?>"><?php echo $yearlevel ?></td>
          <?php
          $total = 0;
          $result = $conn->query($sql); 
          while($row = $result->fetch_assoc()) { ?>                                       
            <td><?php echo $row["subject_code"]?></td>
            <td style="text-align:center";><?php echo $row["subject_unit"]?></td>
                </tr>       
                       
              <?php  $total += $row['subject_unit'];} ?>
            <td></td>
            <td></td>
            <td style="text-align:center";><?php echo $total?></td>
          </tbody>
        </table>
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
