<?php
/* Displays user information and some useful messages */
if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
require 'db.php';

//getting id from url
$id = $_GET['id'];
$sql = $mysqli->query("SELECT * FROM users WHERE id='$id'");
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

    <body class="user-upload-photo">

        <?php include 'header.php'; ?>

        <div class="container-fluid">
            <div class="container">
                <div class="form">
                    <form action="userprofileImage.php" method="POST" enctype="multipart/form-data" class="upload-image">
                         <div class="form-group">
                                <input class="form-control" type="hidden" name="id" value="<?php echo $_GET['id']; ?>"/>
                         </div>
                        <div class="form-group">
                            <label class="custom-file">
                                <input type="file" name="file">                              
                            </label></div>
                        <div class="form-group"><input class="form-control" type="submit" name="submit" value="upload"/></div>
                    </form>
                </div>
            </div>
        </div>


        <?php include_once 'footer.php'; ?>
        <!-- /form -->
        <?php include 'js/js.html'; ?>

    </body>
</html>


