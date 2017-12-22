<?php

require 'db.php';
session_start();

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($fileActualExt, $allowed)) {

        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameNew = "avatar" . $id . "." . $fileActualExt;
                $fileDestination = 'img/userImage/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $sql = "INSERT INTO users (avatar) " . "VALUES ('$fileNameNew')  WHERE id='$id'";
                $result = $mysqli->query("SELECT * FROM users WHERE id='$id'") or die($mysqli->error());
                /* fetch object array */
                while ($user = mysqli_fetch_array($result)) {
                    echo $user['id'] . '<br>';
                    echo $user['first_name']. '<br>';                  
                    echo $user['active']. '<br>';
                    echo $user['avatar']. '<br>';               
                }
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "There was an error uploading your file!";
            echo $id;
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}



