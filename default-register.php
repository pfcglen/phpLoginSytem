<?php



if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    // Set session variables to be used on profile.php page
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['first_name'] = $_POST['firstname'];
    $_SESSION['last_name'] = $_POST['lastname'];


    // Escape all $_POST variables to protect against SQL injections
    $first_name = $mysqli->escape_string($_POST['firstname']);
    $last_name = $mysqli->escape_string($_POST['lastname']);
    $email = $mysqli->escape_string($_POST['email']);
    $password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
    $confirmPassword = $mysqli->escape_string(password_hash($_POST['confirmPassword'], PASSWORD_BCRYPT));
    $hash = $mysqli->escape_string(md5(rand(0, 1000)));

    if (isset($_POST['register'])) { //user logging in	
        //google recaptcha v2
        $reSecretKey = '6LfsAD8UAAAAAJhiraSHJT2s5GN4CdE1MdsxdHlU';
        $responseKey = $_POST['g-recaptcha-response'];
        $remoteIp = $_SERVER['REMOTE_ADDR'];
        $reUrl = 'https://www.google.com/recaptcha/api/siteverify?secret='.$reSecretKey.'&response='.$responseKey.'&remoteip='.$remoteIp;
        $recaptchaResponse = file_get_contents($reUrl);
        $recaptchaResponse = json_decode($recaptchaResponse);
        
             
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) { //google recaptcha
            if (!$recaptchaResponse->success) {
                 $_SESSION['message'] = 'Please try again, google recaptcha is required';
                 header('Location: index.php');
                 exit();
            } else {
                if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirmPassword)) {
                    $_SESSION['message'] = 'Form fields are empty or incomplete';
                    header('Location: index.php');
                    exit();
                } else {
                    if (!preg_match('/^[a-zA-Z]*$/', $first_name) || !preg_match('/^[a-zA-Z]*$/', $last_name)) {
                        $_SESSION['message'] = 'Name must be letters and white space only allowed';
                        header('Location: index.php');
                        exit();
                    } else {
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $_SESSION['message'] = 'Email invalid';
                            header('Location: index.php');
                            exit();
                        } else {
                            // Check if user with that email already exists
                            $result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());
                            if ($result->num_rows > 0) {
                                $_SESSION['message'] = 'User with this' . '' . $email . 'already exists!';
                                header('Location: index.php');
                                exit();
                            } else {
                                if ($_POST['password'] === $_POST['confirmPassword']) {
                                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                                    // active is 0 by DEFAULT (no need to include it here)
                                    $sql = "INSERT INTO users (first_name, last_name, email, password, hash) "
                                            . "VALUES ('$first_name','$last_name','$email','$password', '$hash')";

                                    // Add user to the database
                                    if ($mysqli->query($sql)) {

                                        $_SESSION['active'] = 0; //0 until user activates their account with verify.php
                                        $_SESSION['logged_in'] = true; // So we know the user has logged in
                                        $_SESSION['message'] = 'Confirmation link has been sent to '.$email.', please verify
                                  your account by clicking on the link in the message!';

                                        // Send registration confirmation link (verify.php)
                                        $to = $email;
                                        $subject = 'Account Verification';
                                        $message_body = '
                                Hello ' . $first_name . ',
                                Thank you for signing up!
                                Please click this link to activate your account:
                                http://localhost/login-system/verify.php?email=' . $email . '&hash=' . $hash;
                                        mail($to, $subject, $message_body);
                                        header('location: profile.php');
                                        exit();
                                    } 
                                }else{
                                    header('Location: index.php');
                                    $_SESSION['message'] = 'Password don\'t match';
                                    exit();
                                }
                            }
                        }
                    }
                }
            }
        }else{
            $_SESSION['message'] = 'I\'m not a robot is required';
            header('Location: index.php');
            exit();
        } ///ggogle recaptcha
    } //user click register / create btn
} //if method is post


    