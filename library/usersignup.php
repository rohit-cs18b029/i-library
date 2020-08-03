<?php

require "db_connect.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $showError="";
    $flag=false;

    $fullname=$_POST['full_name'];
    $dob=$_POST['dob'];
    $contact_no=$_POST['contact_no'];
    $email=$_POST['email'];
    $state=$_POST['state'];
    $city=$_POST['city'];
    $pincode=$_POST['pincode'];
    $full_address=$_POST['full_address'];
    $member_id=$_POST['member_id'];
    $password=$_POST['password'];


    $q="select * from member_master_tbl where member_id='$member_id'";
    $result=$mysqli->query($q);
    if($result->num_rows>0){
        $showError="member id in use";
    }
    else{
        $hash=password_hash($password,PASSWORD_DEFAULT);
        $q = "INSERT INTO member_master_tbl (fullname,dob,contact_no,email,state,city,pincode,full_address,member_id,password,account_status)
        VALUES ('$fullname', '$dob', '$contact_no', '$email', '$state', '$city', '$pincode', '$full_address', '$member_id', '$hash','pending')";
        $result=$mysqli->query($q);
        if($result){
            $flag=true;
        }
        else{
            $showError="check details";
        }
    }
    header('location: http://localhost/library/usersignup.php?p=signup&flag='.$flag.'&showError='.$showError);
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

        
        <form action="usersignup.php" method="POST">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 mx-auto">
    
                        <div class="card">
                            <div class="card-body">
    
                                <div class="row">
                                    <div class="col">
                                        <center>
                                            <img src="imgs/generaluser.png" width="100px">
                                        </center>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col">
                                        <center>
                                            <h4>Member Sign Up</h4>
                                        </center>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col">
                                        <hr>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Full Name</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Full Name" name="full_name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Date of Birth</label>
                                        <div class="form-group">
                                            <input type="date" class="form-control" placeholder="Date of Birth" name="dob" required>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Contact Number</label>
                                        <div class="form-group">
                                            <input type="number" class="form-control" placeholder="Contact Number" name="contact_no" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">E-mail</label>
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="E-mail" name="email" required>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="">State</label>
                                        <div class="form-group">
                                            <select name="state" id="" class="form-control">
                                                <option value="MP">MP</option>
                                                <option value="UP">UP</option>
                                                <option value="RJ">RP</option>
                                                <option value="UK">UP</option>
                                                <option value="BH">BH</option>
                                                <option value="JH">JH</option>
                                            </select>
                                        </div>
                                    </div>
    
                                    <div class="col-md-4">
                                        <label for="">City</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="City" name="city" required>
                                        </div>
                                    </div>
    
                                    <div class="col-md-4">
                                        <label for="">Pincode</label>
                                        <div class="form-group">
                                            <input type="number" class="form-control" placeholder="Pincode" name="pincode" required>
                                        </div>
                                    </div>
    
                                </div>
    
                                <div class="row">
                                    <div class="col">
                                        <label>Full Address</label>
                                        <div class="form-group">
                                            <textarea name="full_address" id="" cols="30" rows="2"
                                             class="form-control" placeholder="full address" required></textarea>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col">
                                        <center>
                                            <span class="badge badge-pill badge-info">Login Credential</span>
                                        </center>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Member ID</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Member ID" name="member_id" required>
                                        </div>
                                    </div>
    
                                    <div class="col-md-6">
                                        <label for="">Password</label>
                                        <div class="form-group">
                                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success btn-block btn-lg" value="Sign Up">
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