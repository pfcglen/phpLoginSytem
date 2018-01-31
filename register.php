<?php

// You can access the values posted by jQuery.ajax
// through the global variable $_POST, like this:
$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : null;
$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;


$errors = []; //array for errors
$noError = "No error found";

if(empty($_POST['firstname']) || !preg_match("/^[a-zA-Z ]*$/",$firstname)){
    $errors[]['firstname'] = "Missing First name";         
}else{
    $firstname = sanitizedData($_POST['firstname']);
}

if (empty($_POST['lastname']) || !preg_match("/^[a-zA-Z ]*$/", $lastname)) {
    $errors[]['lastname'] = "Missing Last name";      
}else{
    $lastname = sanitizedData($_POST['lastname']);
}

if (empty($_POST['email']) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[]['email'] = "Missing email";      
}else{
    $email = sanitizedData($_POST['email']);  
}

if(!empty($errors)){
    $result_array = array('errors' => $errors);
    echo json_encode($result_array);
    exit();
}else{
    echo json_encode($noError);   
}

//sanitized data from user inputs
function sanitizedData($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>