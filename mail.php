<?php
require 'function/function.php';
// Establish Database Connection
$conn = connect();

$n=15;
function getpassword($n) {
	$password = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';

	for ($i = 0; $i < $n; $i++) {
		$index = rand(0, strlen($password) - 1);
		$randomString .= $password[$index];
	}

	return $randomString;
}

// Establish Database Connection
$student_id=$_REQUEST['student_id'];
$conn = connect();

$profilesql = "SELECT * FROM students a
WHERE a.student_id = '$student_id'";
$profilequery = mysqli_query($conn, $profilesql);
$row = mysqli_fetch_assoc($profilequery);
$to = $row['email_address'];
$password = getpassword($n);
$message = "
<html>
<body>
<p>Your Username And Password</p>
<table>
<tr>
<th>Username:</th>
<td>". $to . "</td>
</tr>
<tr>
<th>Password:</th>
<td>". $password . "</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: '. $to . "\r\n";
 mail($to, 'Account', $message,$headers);
 
 $sql = "UPDATE students SET 
 username = '$to', password = '$password'
 WHERE student_id = $student_id";
 $query = mysqli_query($conn, $sql);
 if($query){
    header("location:admin/index.php");
 }
 
?>