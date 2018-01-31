<?php
/* Displays user information and some useful messages */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require 'db.php';


if ($_SESSION['logged_in'] == 1) {    
   // Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    
} 
    $sql = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());
    while ($user = mysqli_fetch_array($sql)) {
        $id = $user['id'];
        $first_name = $user['first_name'];
        $last_name = $user['last_name'];
        $email = $user['email'];
        $active = $user['active'];
        $photo = $user['avatar'];
        $creationDate = $user['creationDate'];
        $lastModify = $user['lastModify'];
    }


print_r($_SESSION);
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

    <body class="profile">

        <?php include 'header.php'; ?>


        <!-- alert message -->
        <!--        // Display message about account verification link only once-->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissable fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p><strong><?php echo $_SESSION['message']; ?></strong></p>
            </div>
            <!--            Don't annoy the user with more messages upon page refresh-->
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <!--        Keep reminding the user this account is not active, until they activate-->
        <?php if (!$active) : ?>
            <div class="alert alert-warning alert-dismissable fade show">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Account is unverified, please confirm your email by clicking
                    on the email link!</strong> 
            </div>
        <?php endif; ?>


        <div class="profileHeroImage">

            <?php if ($photo == "") : ?>
                <div class="jumbotron jumbotron-fluid" id="bigUserPhot" style="background-image: url(img/userImage/default.png);"></div>
            <?php else : ?>
                <img class="card-img-top" src="img/userImage/" alt="Card image cap">

            <?php endif; ?>  

            <div class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col col col-lg-4" id="userSidebar">
                            <div class="cardWrapper">
                                <div class="card">
                                    <div class="userPhoto">   
                                        <?php if ($photo == "") : ?>
                                            <img id="sideBarPhoto" class="card-img-top" src="img/userImage/default.png" alt="Card image cap">
                                            <p class="uploadImage"><a href="uploadImage.php?id=<?php echo $id; ?>">Empty<i class="fa fa-plus-circle" aria-hidden="true"></i></a></p>
                                        <?php else : ?>
                                            <img id="sideBarPhoto" class="card-img-top" src="img/userImage/" alt="Card image cap">
                                            <p class="uploadImage"><a href="uploadImage.php?id=<?php echo $id; ?>">Not empty<i class="fa fa-plus-circle" aria-hidden="true"></i></a></p>
                                        <?php endif; ?>                                              

                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">Bio:</h4>
                                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor itaque at ducimus soluta fugiat. Ad molestias et facilis culpa repellendus ducimus est quia. Asperiores, similique accusantium natus id ipsam libero!</p>

                                    </div>

                                    <!--                                    fetch and display user details, preparation for edit.php-->
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong> First name: </strong><?php echo $first_name; ?> <?php echo $last_name; ?></li>
                                        <li class="list-group-item"><strong> email: </strong><?php echo $email; ?></li>
                                        <li class="list-group-item"><strong> Created: </strong><?php echo $creationDate; ?></li>
                                        <li class="list-group-item"><strong> Lat Modify: </strong><?php echo $lastModify; ?></li>
                                        <li class="list-group-item"><strong><a href="edit_profile.php?id=<?php echo $id; ?>"><i class='fa fa-pencil-square-o' aria-hidden='true'></i>Edit Profile</a></strong></li>

                                    </ul>
                                </div>
                            </div>

                        </div>
                        <div class="col col col-lg-8" id="postContent">
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start active">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">List group item heading</h5>
                                        <small>3 days ago</small>
                                    </div>
                                    <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                                    <small>Donec id elit non mi porta.</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">List group item heading</h5>
                                        <small class="text-muted">3 days ago</small>
                                    </div>
                                    <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                                    <small class="text-muted">Donec id elit non mi porta.</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">List group item heading</h5>
                                        <small class="text-muted">3 days ago</small>
                                    </div>
                                    <p class="mb-1">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                                    <small class="text-muted">Donec id elit non mi porta.</small>
                                </a>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <?php include_once 'footer.php'; ?>
        <!-- /form -->
        <?php include 'js/js.html'; ?>

    </body>
</html>


