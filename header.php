<?php
/* Displays user information and some useful messages */
if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
require 'db.php';

?>

<div class="container-main">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php">
                <img src="img/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
                Bootstrap
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav float-right">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown link
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                </ul>
            </div>

            <div id="guestWrapper" class="row">
                <!--                Check if user is logged in using the session variable-->
<?php if (isset($first_name) == true) : ?>

                    <div class="dropdown">

                        <img src="img/userImage/default.png" alt="..."  class="float-right userAvatar img-thumbnail dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <p class="uploadImage"><a href="uploadImage.php?id=<?php echo $id; ?>">Not empty<i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></p>


                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item disabled" href="#">Signed in as <span><?php echo $first_name; ?> </span></a>'
                            <a class="dropdown-item" href="profile.php">Your Profile</a>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </div>
<?php else : ?>
                    <!--                    dropdown login-->
                    <button id="headerLoginBtn" type="button" class="btn btn-outline-primary">Log in</button>
<?php endif; ?>       
            </div>
        </nav>  
    </div>
</div>



