<?php

use PHPMailer\PHPMailer\PHPMailer; ?>

<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
/* Registration process, inserts user info into the database 
  and sends account confirmation email message
 */

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

//
if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirmPassword)) {
    $_SESSION['message'] = 'Form fields are empty or incomplete';
    header("Location: error.php");
    exit();
} else {
    if (!preg_match("/^[a-zA-Z]*$/", $first_name) || !preg_match("/^[a-zA-Z]*$/", $last_name)) {
        $_SESSION['message'] = 'Name must be letters and white space only allowed';
        header("Location: error.php");
        exit();
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'] = 'Email invalid';
            header("Location: error.php");
            exit();
        } else {
            // Check if user with that email already exists
            $result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());
            if ($result->num_rows > 0) {
                $_SESSION['message'] = 'User with this' . '' . $email . 'already exists!';
                header("location: error.php");
                exit();
            } else {
                if ($_POST['password'] == $_POST['confirmPassword']) {
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                    // active is 0 by DEFAULT (no need to include it here)
                    $sql = "INSERT INTO users (first_name, last_name, email, password, hash) "
                            . "VALUES ('$first_name','$last_name','$email','$password', '$hash')";

                    // Add user to the database
                    if ($mysqli->query($sql)) {

                        $_SESSION['active'] = 0; //0 until user activates their account with verify.php
                        $_SESSION['logged_in'] = true; // So we know the user has logged in
                        $_SESSION['message'] = "Confirmation link has been sent to $email, please verify
                                  your account by clicking on the link in the message!";

                        // Send registration confirmation link (verify.php) using PHPmailer
                        //Import PHPMailer classes into the global namespace
                        require 'vendor/phpmailer/phpmailer/src/SMTP.php';
                        require 'vendor/autoload.php';
                        //Create a new PHPMailer instance
                        $mail = new PHPMailer;
                        //Tell PHPMailer to use SMTP
                        $mail->isSMTP();
                        //Enable SMTP debugging
                        // 0 = off (for production use)
                        // 1 = client messages
                        // 2 = client and server messages
                        $mail->SMTPDebug = 0;
                        //Set the hostname of the mail server
                        $mail->Host = 'smtp.mailtrap.io';
                        // use
                        // $mail->Host = gethostbyname('smtp.gmail.com');
                        // if your network does not support SMTP over IPv6
                        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
                        $mail->Port = 25;
                        //Set the encryption system to use - ssl (deprecated) or tls
                        $mail->SMTPSecure = 'tls';
                        //Whether to use SMTP authentication
                        $mail->SMTPAuth = true;
                        //Username to use for SMTP authentication - use full email address for gmail
                        $mail->Username = "a62cf990918667";
                        //Password to use for SMTP authentication
                        $mail->Password = "76a041477cf8c0";
                        //Set who the message is to be sent from
                        $mail->setFrom('from@example.com', 'First Last');
                        //Set an alternative reply-to address
                        //$mail->addReplyTo('replyto@example.com', 'First Last');
                        //Set who the message is to be sent to
                        $mail->addAddress($email, $first_name);
                        $mail->addCC('gcabiladas@outlook.com', 'first_name');
                        //Set the subject line
                        $mail->Subject = 'Account Verification';
                        //Read an HTML message body from an external file, convert referenced images to embedded,
                        //convert HTML into a basic plain-text alternative body
                        //$mail->msgHTML(file_get_contents('contents.html'), __DIR__);
                         $mail->Body = '<p>Hello '.$first_name.', Thank you for signing up! <br>
                         Please click this link to activate your account <br> </p>';
                         $mail->Body .= '<a style="color: #fff; padding: 6px 12px;margin-bottom: 0;font-size: 14px;font-weight: 400;line-height: 1.42857143;text-align: center;white-space: nowrap;vertical-align: middle; -ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-webkit-user-select: none;-ms-user-select: none; -ms-user-select: none;user-select: none;background-image: none;border: 1px solid transparent;border-radius: 4px;background-color: #337ab7;border-color: #2e6da4; text-decoration: none;" href="ttp://localhost/login-system/verify.php?email='.$email.'&hash='.$hash.'"> activate </a>';
                        //Replace the plain text body with one created manually
                         $mail->AltBody = 'This is a plain-text message body';
                         //Attach an image file
                        //$mail->addAttachment('images/phpmailer_mini.png');
                        //send the message, check for errors
                        if (!$mail->send()) {
                            echo "Mailer Error: " . $mail->ErrorInfo;
                        } else {
                            header("location: profile.php");
                            exit();                            
                        }                     
                    }// Add user to the database
                } else {
                    header("location: error.php");
                    $_SESSION['message'] = 'Password don\'t match';
                    exit();
                }
            }
        }
    }
}
