<?php
// Uploads files
if (isset($_POST['upload'])) { // if save button on the form is clicked
    // name of the uploaded file
    $filename = $_FILES['requirements']['name'];

    // destination of the file on the server
    $destination = 'data/image/requirement' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['requirements']['tmp_name'];
    $size = $_FILES['requirements']['size'];

    if (!in_array($extension, ['pdf'])) {
        echo "You file extension must be .pdf";
    } elseif ($_FILES['requirements']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
        echo "File too large!";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO requirements (file_name, student_id) VALUES ('$filename', '1')";
            if (mysqli_query($conn, $sql)) {
                echo "File uploaded successfully";
            }
        } else {
            echo "Failed to upload file.";
        }
    }
}?>