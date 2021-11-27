<?php 
require 'function/function.php';
$conn = connect();
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
<style>
* {
  box-sizing: border-box;
}

body {
  background-color: #f1f1f1;
}

#basic-info {
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

<nav>
<div class="navbar">
  <a href="home.php">Home</a>
  <a href="login.php">Login</a>
  <a class="active" href="basic-info.php">Admission</a>
</div>
</nav>

	<form id="basic-info" method = "POST" enctype="multipart/form-data">
        <h1>Basic Info:</h1>
        
        <!-- One "tab" for each step in the form: -->
        <div class="tab">
        <p>List of requirements you need to upload to proceed for the next step:</p>
        <br>
        <center><select id="mySelect" name="mySelect" onchange="myFunction()" oninput="this.className = ''"></center>
            <option></option>
            <option value="Freshmen">Freshmen</option>
            <option value="Transferee">Transferee</option>
          </select>
          </br>
          <p id="demo"></p>     
          Upload File:
          <p> <input type="file" name="myfile"> </p>
        </div>
        <div class="tab">
            First Name:
            <p> <input type="input" name="first_name" oninput="this.className = ''"> <br></p>
            Middle Name:
            <p> <input type="input" name="middle_name" oninput="this.className = ''"> <br></p>
            Last Name:
            <p> <input type="input" name="last_name" oninput="this.className = ''"> <br></p>
            Email:
            <p> <input type="input" name="email" oninput="this.className = ''"> <br></p>
            Contact:
            <p><input type="input" name="contact" oninput="this.className = ''" minlength="10" maxlength="10"><br></p>
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
<script>
function myFunction() {
var s = document.getElementById('mySelect');
var item1 = s.options[s.selectedIndex].value;

if (item1 == "Freshmen") {
  document.getElementById("demo").innerHTML = "<br><p>• Original Form 138/ST-9SHS (Learner's Progress Report Card)</p><p>• Form 137/ SF10-SHS (Learner's Permanent Academic Record) </p><p> • PSA Issued Birth Certificate</p></br>";
}
else if (item1 == "Transferee") {
  document.getElementById("demo").innerHTML = "<br><p>• Original Form 138/ST-9SHS (Learner's Progress Report Card)</p><p>• Form 137/ SF10-SHS (Learner's Permanent Academic Record)</p></br>";
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
        document.getElementById("basic-info").submit();
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
        }else if(currentTab == 1){
          if(!validateEmail(y[3].value)){
            y[3].className += " invalid";
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
  </body>
</html>
<?php
// Uploads files
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // if save button on the form is clicked   
  $myselect = $_POST['mySelect'];
  $first_name = $_POST['first_name'];
  $middle_name = $_POST['middle_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $contact = $_POST['contact'];
  $time = round(microtime(true)); 
  // name of the uploaded file
  $temp = explode(".", $_FILES["myfile"]["name"]);
  $newfilename = $myselect . "_" . $email . "_" . $time . '.' . end($temp);

  // destination of the file on the server
  $destination = 'data/image/requirement/freshmen/' . $newfilename;

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
        $query = mysqli_query($conn, "SELECT * FROM students WHERE email_address = '$email'");
        if(mysqli_num_rows($query) > 0){
            $row = mysqli_fetch_assoc($query);
            if($email == $row['email_address']){
              ?><script>
              alert("Email Already Taken");
            </script><?php
          }
        }else{
          $sql = "INSERT INTO students (first_name, middle_name, last_name, email_address, contact, date_time_created)
          VALUES ('$first_name', '$middle_name', '$last_name', '$email', '$contact', NOW())";
          $query = mysqli_query($conn, $sql);
            if($query){
              $student_id = mysqli_insert_id($conn);
              $sql = "INSERT INTO requirements (student_id, file_name, size, path) VALUES ('$student_id', '$newfilename', $size, '$destination')";
              if (mysqli_query($conn, $sql)) {
                ?><script>
                alert("Wait For the Email For Your Username And Password");
              </script><?php
              }
            }else {
              ?><script>
              alert("Enrollment Failed");
            </script><?php
            }
        }
       
      }
  }
    
}
?>