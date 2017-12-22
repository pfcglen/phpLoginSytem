 <?php 
/* Main page with two forms: sign up and log in */
 if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
require 'db.php';

?>
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>phpForm_v.1.0.0</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include 'css/css.html'; ?>
    </head>
     

<?php 	
  if ($_SERVER["REQUEST_METHOD"] == "POST"){    
	  	if (isset($_POST['login'])) { //user logging in
			require 'login.php';
		}elseif (isset($_POST['register'])) { //user registering
			require 'register.php';
		}	
	}	
?>

<body>
     <?php include 'header.php'; ?>
	
	<div class="login-page">            
		<div class="form">
			<form action="index.php" method="POST" class="register-form">
				
				<div class="form-group">
                                    <input class="form-control" type="text" placeholder="First name" name="firstname" required/>
                                </div>
                                    <div class="form-group">
                                        <input class="form-control" type="text" placeholder="Last Name" name="lastname" required/>
                                    </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" placeholder="Email" name="email" required />
                                        </div>
                                             <div class="form-group">
                                                    <input class="form-control" type="password" class="userPassword" placeholder="Password" name="password" required/>  
                                                   <p class="togglePass"><i class="material-icons">visibility_off</i></p>
                                             </div>
                                                    <div class="form-group">
                                                    <input class="form-control" type="password" class="userPassword" placeholder="Confirm Password" name="confirmPassword" required/>
                                                    <p class="togglePass"><i class="material-icons">visibility_off</i></p>     
                                                    </div>
                                                   
				
				<button type="submit" name="register">create</button>
				<p class="message">Already registered? <a href="#">Sign In</a></p>
			</form>
			<form action="index.php" method="POST" class="login-form">
                                <div class="form-group"><input class="form-control" type="text" placeholder="Email" name="email" required/></div>
                                    <div class="form-group"><input class="form-control" type="password" placeholder="Password" name="password" required/></div>
				        <p class="forgot text-right"><a href="forgot.php">Forgot Password?</a></p>
                                            <button name="login">login</button>
                                                <p class="message">Not registered? <a href="#">Create an account</a></p>
			</form>
		</div>
	</div>
    
    <?php include_once 'footer.php'; ?>
    <!-- /form -->
    <?php include 'js/js.html'; ?>

</body>

</html>