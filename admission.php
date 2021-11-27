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
$current_id = $_SESSION['student_id'];
// Establish Database Connection
$conn = connect();


$profilesql = "SELECT * FROM students a
    JOIN enrollment b ON a.student_id = b.student_id
    JOIN curriculums c ON c.curriculum_id = b.curriculum_id
    JOIN curriculum_details d ON d.curriculum_id = c.curriculum_id
    JOIN subjects e ON e.subject_id = d.subject_id
    JOIN courses f ON f.course_id = d.course_id
    JOIN yearlevel g ON g.yearlevel_id = d.yearlevel_id
    JOIN schoolyear h ON h.schoolyear_id =  d.schoolyear_id
    JOIN semester i ON i.semester_id = d.semester_id
    WHERE a.student_id = $current_id";
$profilequery = mysqli_query($conn, $profilesql);
    if(mysqli_num_rows($profilequery) > 0){
        $row = mysqli_fetch_assoc($profilequery);
        $course = $row['course_name'];
		$yearlevel = $row['year_level'];
        
    }else{
        $profilesql = "SELECT * FROM students a
        WHERE a.student_id = $current_id";
        $profilequery = mysqli_query($conn, $profilesql);
        $row = mysqli_fetch_assoc($profilequery);
        $course = "None";
		$yearlevel = "None";
    }

//All available year Level
$yearsql = "SELECT * FROM yearlevel";
$result1 = mysqli_query($conn, $yearsql);
$curriculumsql = "SELECT * FROM curriculums";
$result2 = mysqli_query($conn, $curriculumsql);
$semestersql = "SELECT * FROM semester";
$result3 = mysqli_query($conn, $semestersql);


?>

<!DOCTYPE html>
<html>
<head>
<script src="https://kit.fontawesome.com/57ce411ce4.js" crossorigin="anonymous"></script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>University of Manila</title>
<link rel="stylesheet" href="css/style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<style>
* {
  box-sizing: border-box;
}

body {
  background-color: #f1f1f1;
}

#admission {
  background-color: #ffffff;
  margin: 100px auto;
  font-family: Raleway;
  padding: 40px;
  width: 70%;
  min-width: 300px;
}

h1 {
  text-align: center;  
}

input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}

select{
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
}

button {
  background-color: #04AA6D;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 17px;
  font-family: Raleway;
  cursor: pointer;
}

button:hover {
  opacity: 0.8;
}

#prevBtn {
  background-color: #bbbbbb;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;  
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #04AA6D;
}

* {
  box-sizing: border-box;
}

/* Create three equal columns that floats next to each other */
.column {
  float: left;
  width: 33.33%;
  padding: 10px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

</style>
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
    <a href="login.php">Login</a>
    <a class="active" href="admission.php">Admission</a>
  </div><?php
  }
  else{
    ?><div class="navbar">
    <a href="home.php">Home</a>
    <a  href="myprofile.php">My Profile</a>
    <a class="active" href="admission1.php">Admission</a>
  </div><?php
  }
?>

<form id="admission"  method = "POST" enctype="multipart/form-data">
  <h1>Enrollment</h1>
  <!-- One "tab" for each step in the form: -->
  <div class="tab"><h2>Student Information:</h2>
    <div class="row">
        <div class="column"> <label for="FirstName">First Name:</label>
        <input type="text" name="FirstName"  value= "<?php echo $row['first_name']?>" placeholder="First Name" oninput="this.className = ''"></div>
        <div class="column"> <label for="MiddleName">Middle Name:</label>
        <input type="text" name="MiddleName"  value= "<?php echo $row['middle_name']?>" placeholder="Middle Name" oninput="this.className = ''"></div>
        <div class="column"> <label for="LastName">Last Name:</label>
        <input type="text" name="LastName"  value= "<?php echo $row['last_name']?>" placeholder="Last Name" oninput="this.className = ''"></div>
    </div>
    <div class="row">
        <div class="column"> <label for="LastSchoolAttended">Last School Attended:</label>
         <input type="text" name="LastSchoolAttended" value= "<?php echo $row['last_school_attended']?>" placeholder="Last School Attended" oninput="this.className = ''"></div>
        <div class="column"> <label for="Course">Choose a Course:</label>
            <select name="Course">
				<?php while($row2 = mysqli_fetch_array($result2)):;?>				
            		<option value="<?php echo $row2[0];?>" <?php if($row2[1] == $course){?>selected<?php } ?>><?php echo $row2[1];?></option>
            		<?php endwhile;?>
			</select></div>
        <div class="column"> <label for="YearLevel">Year Level:</label>
            <select Name=YearLevel>
				<?php while($row1 = mysqli_fetch_array($result1)):;?>
            		<option value="<?php echo $row1[0];?>" <?php if($row1[1] == $yearlevel ){?>selected<?php } ?>><?php echo $row1[1];?></option>
            		<?php endwhile;?>	
			</select></div>
    </div>
    <div class="row">
        <div class="column"><label for="Semester">Semester:</label>
            <select Name=Semester>
				<?php while($row3 = mysqli_fetch_array($result3)):;?>
            		<option value="<?php echo $row3[0];?>" <?php if($row3[1] == $yearlevel ){?>selected<?php } ?>><?php echo $row3[1];?></option>
            		<?php endwhile;?>	
			</select></div>
        <div class="column"> <label for="BirthDate">Date Of Birth</label>
         <input type="date" name="BirthDate" value= "<?php echo $row['birth_date']?>" oninput="this.className = ''"></div>
        <div class="column"> <label for="Gender">Gender:</label>
            <select name="Gender" oninput="this.className = ''">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            </select></div>
    </div>
    <div class="row">
    <div class="column"> <label for="Address">Address:</label>
         <input type="text" name="Address" value= "<?php echo $row['address']?>" placeholder="Address" oninput="this.className = ''"></div>
        <div class="column"> <label for="EmailAddress">Email Adress:</label>
        <input type="text" name="EmailAddress" value= "<?php echo $row['email_address']?>" placeholder="Email Adress" oninput="this.className = ''"></div>
        <div class="column"> <label for="Contact">Contact Number:</label>
        <input type="text" name="Contact" value= "<?php echo $row['contact']?>" placeholder="Contact Number" oninput="this.className = ''"></div>
    </div>
  </div>
  <div class="tab"><h2>Parents Information:</h2>
    <div class="row">
        <div class="column"> <label for="FatherName">Father Name:</label>
        <input type="text" name="FatherName" value= "<?php echo $row['father_name']?>" placeholder="Father Name" oninput="this.className = ''"></div>
        <div class="column"> <label for="FatherOccupation">Father Occupation:</label>
        <input type="text" name="FatherOccupation" value= "<?php echo $row['father_occupation']?>" placeholder="Father Occupation" oninput="this.className = ''"></div>
        <div class="column"> <label for="FatherPhoneNumber">Father Phone Number:</label>
        <input type="text" name="FatherPhoneNumber" value= "<?php echo $row['father_phone_number']?>" placeholder="Father Phone Number" oninput="this.className = ''"></div>
    </div>
    <div class="row">
        <div class="column"> <label for="MotherName">Mother Name:</label>
        <input type="text" name="MotherName" value= "<?php echo $row['mother_name']?>" placeholder="Mother Name" oninput="this.className = ''"></div>
        <div class="column"> <label for="MotherOccupation">Mother Occupation:</label>
        <input type="text" name="MotherOccupation" value= "<?php echo $row['mother_occupation']?>" placeholder="Mother Occupation" oninput="this.className = ''"></div>
        <div class="column"> <label for="MotherPhoneNumber">Mother Phone Number:</label>
        <input type="text" name="MotherPhoneNumber" value= "<?php echo $row['mother_phone_number']?>" placeholder="Mother Phone Number" oninput="this.className = ''"></div>
    </div>
    <div class="row">
        <div class="column"> <label for="GuardianName">Guardian Name:</label>
        <input type="text" name="GuardianName" value= "<?php echo $row['guardian_name']?>" placeholder="Guardian Name" oninput="this.className = ''"></div>
        <div class="column"> <label for="GuardianOccupation">Guardian Occupation:</label>
        <input type="text" name="GuardianOccupation" value= "<?php echo $row['guardian_occupation']?>" placeholder="Guardian Occupation" oninput="this.className = ''"></div>
        <div class="column"> <label for="GuardianPhoneNumber">Guardian Phone Number:</label>
        <input type="text" name="GuardianPhoneNumber" value= "<?php echo $row['guardian_phone_number']?>" placeholder="Guardian Phone Number" oninput="this.className = ''"></div>
    </div>
  </div>
  <div class="tab"><h2>Files:</h2>
  <p>List of payment methods you to upload to proceed to the next step</p>
			<select id="mySelect" name="mySelect" onchange="myFunction()">
			<option></option>
			<option value="Unionbank">Unionbank</option>
			<option value="BDO">BDO</option>
			<option value="GCash">GCash</option>
			<option value="Metrobank">Metrobank</option>
		</select>
  		<p id="demo"></p>
        <label for="myfile">Reciept:</label>
        <input type="file" name="myfile">

  </div>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>
  </div>
  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
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
<script>
function myFunction() {
    var s = document.getElementById('mySelect');
    var item1 = s.options[s.selectedIndex].value;

    if (item1 == "Unionbank") {
    document.getElementById("demo").innerHTML = "<center><p style=font-size: 20px;><b>Deposit on this account number (Unionbank only)</b></p><br><p> 1234-1234-1234-1234 </p></center>";
    }
    else if (item1 == "BDO") {
    document.getElementById("demo").innerHTML = "<center><p><b>Deposit on this account number (BDO only)</b></p><br><p> 4354-3456-3268-8765 </p></center>";
    }
    else if (item1 == "GCash") {
    document.getElementById("demo").innerHTML = "<center><p><b>Gcash Account:</b></p><br><p>09195754642</p></center>";
    }
    else if (item1 == "Metrobank") {
    document.getElementById("demo").innerHTML = "<center><p><b>Deposit on this account number (Metrobank only)</b></p><br><p> 0000-2434-4535-6970 </p></center>";
    }
    else{
    document.getElementById("demo").innerHTML = "";
    }
  }

var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("admission").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
        // If a field is empty...
        if (y[i].value == "") {
        // add an "invalid" class to the field:
        y[i].className += " invalid";
        // and set the current valid status to false
        valid = false;
        }else if(currentTab == 0){
          if(!validateEmail(y[6].value)){
            y[6].className += " invalid";
            valid = false;
        }  
    }

    // This function deals with validation of the email
  function validateEmail(email) {
    var emailformat = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\"[^\s@]+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!email.match(emailformat))
        return false;
    return true;
    }  
        
    }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}
</script>
</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $myselect = $_POST['mySelect'];
  $first_name = $_POST['FirstName'];
  $middle_name = $_POST['MiddleName'];
  $last_name = $_POST['LastName'];
  $last_school_attended = $_POST['LastSchoolAttended'];
  $course = $_POST['Course'];
  $year_level = $_POST['YearLevel'];
  $semester = $_POST['Semester'];
  $birth_date = $_POST['BirthDate'];
  $gender = $_POST['Gender'];
  $address = $_POST['Address'];
  $contact = $_POST['Contact'];
  $email_address = $_POST['EmailAddress'];
  $father_name = $_POST['FatherName'];
  $father_occupation = $_POST['FatherOccupation'];
  $father_phone_number = $_POST['FatherPhoneNumber'];
  $mother_name = $_POST['MotherName'];
  $mother_occupation = $_POST['MotherOccupation'];
  $mother_phone_number = $_POST['MotherPhoneNumber'];
  $guardian_name = $_POST['GuardianName'];
  $guardian_occupation = $_POST['GuardianOccupation'];
  $guardian_phone_number = $_POST['GuardianPhoneNumber'];
  $time = round(microtime(true));

// name of the uploaded file
$temp = explode(".", $_FILES["myfile"]["name"]);
$newfilename = $myselect . "_" . $email_address . "_" . $time . '.' . end($temp);

// destination of the file on the server
$destination = 'data/image/requirement/payments/' . $newfilename;

// get the file extension
$extension = pathinfo($newfilename, PATHINFO_EXTENSION);

// the physical file on a temporary uploads directory on the server
$file = $_FILES['myfile']['tmp_name'];
$size = $_FILES['myfile']['size'];

if (!in_array($extension, ['pdf'])) {
    echo "You file extension must be .pdf";
} elseif ($_FILES['myfile']['size'] > 1000000000) { // file shouldn't be larger than 1Megabyte
    echo "File too large!";
} else {
    // move the uploaded (temporary) file to the specified destination
    if (move_uploaded_file($file, $destination)) {
      $query = mysqli_query($conn, "SELECT * FROM students WHERE email_address = '$email_address' AND student_id != $current_id");
      if(mysqli_num_rows($query) > 0){
          $row = mysqli_fetch_assoc($query);
          if($email_address == $row['email_address']){
            ?><script>
            alert("Email Already Taken");
          </script><?php
        }
      }else{
        $sql = "INSERT INTO enrollment (student_id, yearlevel_id, semester_id, section_id, curriculum_id, file, enrollment_date_time)
        VALUES ('$current_id', '$year_level', '$semester', 123, '$course',  '$destination', NOW())";
        $query = mysqli_query($conn, $sql);
        $sql = "UPDATE students SET
        first_name = '$first_name', middle_name = '$middle_name', last_name = '$last_name',
        birth_date = '$birth_date', gender = '$gender', address = '$address', email_address = '$email_address',
        contact = '$contact', last_school_attended = '$last_school_attended', mother_name = '$mother_name', mother_occupation = '$mother_occupation',
        father_name = '$father_name', father_occupation = '$father_occupation', mother_phone_number = '$mother_phone_number',
        father_phone_number = '$father_phone_number', guardian_name = '$guardian_name', guardian_occupation = '$guardian_occupation',
        guardian_phone_number = '$guardian_phone_number', date_time_updated = NOW()
        WHERE student_id = '$current_id'";
        $query = mysqli_query($conn, $sql);
        if($query){
          $_SESSION['student_id'] = $current_id;
          header("location:myprofile.php");
        }
      }
    }
  }     
}
?>