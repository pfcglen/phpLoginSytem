<?php
//Updating user information and resend activation link to new 
require 'db.php';
session_start();

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];

    // checking and validiting fields
    // Set session variables to be used on profile.php page
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['first_name'] = $_POST['firstname'];
    $_SESSION['last_name'] = $_POST['lastname'];

// Escape all $_POST variables to protect against SQL injections
    $first_name = $mysqli->escape_string($_POST['firstname']);
    $last_name = $mysqli->escape_string($_POST['lastname']);
    $email = $mysqli->escape_string($_POST['email']);

//
    if (empty($first_name) || empty($last_name) || empty($email)) {
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
                $sql = mysqli_query($mysqli, "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email' WHERE id=$id");
                  
               //Check if the database has been updated or not 
                if( mysqli_affected_rows($mysqli) > 0){
                    $_SESSION['message'] = 'Profile has been updated!';
                    header("Location: profile.php");
                    exit();
                } else {
                    $_SESSION['message'] = 'Profile has not updated!';
                    header("Location: profile.php");
                    exit();
                }
                     
            }
        }
    }
}
?>
<?php
//getting id from url
$id = $_GET['id'];
$sql = $mysqli->query("SELECT * FROM users WHERE id='$id'") or die($mysqli->error());

while ($user = mysqli_fetch_array($sql)) {
    $first_name = $user['first_name'];
    $last_name = $user['last_name'];
    $email = $user['email'];
}
?>
<html>
    <head>    
        <title>Editing Data</title>
<?php include 'css/css.html'; ?>
    </head>

    <body>
        <div class="container-fluid">
            <div class="container">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Hi, <?php echo $first_name ?></strong> Before you proceed to change / update your profile information.
                    Please do note, deleted information will never be retrieve.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="login-page">            
                    <div class="form">
                        <form action="edit_profile.php" method="POST" id="updateForm" class="register-form">
                            <div class="form-group">
                                <input class="form-control" type="hidden" name="id" value="<?php echo $_GET['id']; ?>"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="First name" name="firstname" value="<?php echo $first_name; ?>" required/>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Last Name" name="lastname" value="<?php echo $last_name; ?>" required/>
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text" placeholder="Email" name="email" value="<?php echo $email; ?>" required />
                            </div>
                            <button type="submit" name="update">update</button>
                           
                        </form>			
                    </div>
                </div>
            </div>
        </div>
<?php include_once 'footer.php'; ?>
        <!-- /form -->
        <?php include 'js/js.html'; ?>

    </body>
</html>
