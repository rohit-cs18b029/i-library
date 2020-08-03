<?php

session_start();
$user="";
if(isset($_SESSION["member_id"])){
    $user=$_SESSION["member_id"];
}
if(isset($_SESSION["admin_id"])){
    $user=$_SESSION["admin_id"];
}


echo '<header>
        <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="index.php">
            <img src="imgs/books.png" width="30px" height="30px">
            E-library
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" 
        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a href="index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item active">
                    <a href="#" class="nav-link">About Us</a>
                </li>
                <li class="nav-item active">
                    <a href="#" class="nav-link">Terms</a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a href="viewbooks.php" class="nav-link">View Books</a>
                </li>';

                if($user==""){
                    if(!isset($_GET['p']) || $_GET['p']!='adminlogin'){
                        if(!isset($_GET['p']) || $_GET['p']!='login'){
                            echo '<li class="nav-item active">
                                <a href="userlogin.php?p=login" class="nav-link">Log in</a>
                                </li>';
                        }
                        if(!isset($_GET['p']) || $_GET['p']!='signup'){
                            echo '<li class="nav-item active">
                            <a href="usersignup.php?p=signup" class="nav-link">Sign Up</a>
                            </li>';
                        }
                    }
                }
                else{
                    echo '<li class="nav-item active">
                        <a href="logout.php" class="nav-link">logout</a>
                            </li>
                        <li class="nav-item active">
                            <a href="Hellouser.php" class="nav-link">'.  $user .'</a>
                        </li>';
                }

            echo '</ul>
        </div>
    </nav>
</header>';

if(isset($_GET['flag']) && $_GET['flag']==true){
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong>Ready to Login 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}
if(isset($_GET['flag']) && $_GET['flag']!=true){
    echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
            <strong>Warning!</strong> '. $_GET['showError'] .'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}

if(!isset($_GET['flag']) && isset($_GET['showError']) && $_GET['showError']!=''){
    echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
        <strong>Warning!</strong> '. $_GET['showError'] .'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
}

if(isset($_GET['t']) && $_GET['t']!=''){
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong>'. $_GET['t'] .'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}
if(isset($_GET['f']) && $_GET['f']!=''){
    echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
        <strong>Warning!</strong> '. $_GET['f'] .'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>';
}

?>