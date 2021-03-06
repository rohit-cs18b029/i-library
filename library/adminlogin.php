<?php

require "db_connect.php";
$showError="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $admin_id=$_POST["admin_id"];
    $admin_password=$_POST["admin_password"];

    $q = " select * from admin_master_tbl where admin_id='$admin_id' ";
    $result=$mysqli->query($q);

    if( $result->num_rows == 1){
        $row = $result->fetch_assoc();
        if($admin_password==$row['admin_password']){
            session_start();
            if(isset($_SESSION['member_id'])){
                unset($_SESSION['member_id']);
            }
            $_SESSION["admin_id"]=$admin_id;
            header('location: http://localhost/library/index.php');
            exit();
        }
        else{
            $showError="Different password";
        }
    }
    else{
        $showError="Different username";
    }
    header('location: http://localhost/library/adminlogin.php?p=adminlogin&showError='.$showError);
}

$mysqli->close();

?>


<!DOCTYPE html>
<html>
    <head lang="en">
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <!-- CSS -->
        <link rel="stylesheet" href="css/style.css">

<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
    </head>
    <body>
        <!-- Start : Header -->
        <?php  require "header.php"; ?>
        <!-- End : Header -->

        <form action="adminlogin.php" method="POST">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mx-auto">
    
                        <div class="card">
                            <div class="card-body">
    
                                <div class="row">
                                    <div class="col">
                                        <center>
                                            <img src="imgs/adminuser.png" width="150px">
                                        </center>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col">
                                        <center>
                                            <h3>Admin Login</h3>
                                        </center>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col">
                                        <hr>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col">
                                        <label for="">Admin ID</label>
                                        <div class="form-group">
                                            <input name="admin_id" type="text" class="form-control" placeholder="Admin ID">
                                        </div>
    
                                        <label for="">Password</label>
                                        <div class="form-group">
                                            <input name="admin_password" type="password" class="form-control" placeholder="Password">
                                        </div>
    
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success btn-block btn-lg" value="Login">
                                        </div>
                                    </div>
                                </div>
    
                            </div>
                        </div>
                        <br><br>
    
                    </div>
                </div>
            </div>
        </form>

        <!-- Start : footer -->
        <?php  require "footer.php"; ?>
        <!-- End : footer -->
    </body>
</html>