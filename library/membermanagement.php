<?php

require "db_connect.php";
$t="";
$f="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $member_id=$_POST['member_id'];
    $role=$_POST['role'];
    if($role=="A"){
        $role="active";
    }
    if($role=="P"){
        $role="pending";
    }
    if($role=="D"){
        $role="deactive";
    }

    $q = " select * from member_master_tbl where member_id='$member_id' ";
    $result=$mysqli->query($q);
    
    if( $result->num_rows == 1){
        if($role=="active" || $role=="pending" || $role=="deactive"){
            $sql="update member_master_tbl set account_status='$role' where member_id='$member_id';";
            $result=$mysqli->query($sql);
            if($result){
                $t="account status updated to ".$role;
            }
        }
        else if($role=="Delete"){
            $sql = "delete from member_master_tbl where member_id='$member_id' ";
            $result=$mysqli->query($sql);
        
            if($result){
                $t="Member is Successfully Deleted!";
            }
        }
    }
    else{
        $f="Wrong member id!";
    }

    header('location: http://localhost/library/membermanagement.php?t='.$t.'&f='.$f);
}

?>

<?php

$sql = "select * from member_master_tbl";
$result=$mysqli->query($sql);

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
        <!-- datatables CSS -->
        <link rel="stylesheet" href="data-tables/css/jquery.dataTables.min.css">
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
        <script src="data-tables/js/jquery.dataTables.min.js"></script>

        <script type="text/javascript">
            $(document).ready( function () {
                $('.table').DataTable();
            } );

            function split_string(text) {
                var res = text.split("#");
                document.getElementById("member_name").value=res[0];
                document.getElementById("account_status").value=res[1];
                document.getElementById("dob").value=res[2];
                document.getElementById("contact_no").value=res[3];
                document.getElementById("email").value=res[4];
                document.getElementById("state").value=res[5];
                document.getElementById("city").value=res[6];
                document.getElementById("pincode").value=res[7];
                document.getElementById("full_address").value=res[8];
            };

            function fill_input(){
                var member_id=document.getElementById("member_id").value;
                var req=new XMLHttpRequest();
                req.open("GET","http://localhost/library/ajax_membermanagement.php?member_id="+member_id, true);
                req.send();
                req.onreadystatechange=function(){
                    if(this.readyState==4 && this.status==200){
                        split_string(this.responseText);
                    }
                };
            };
        </script>

    </head>
    <body>
        <!-- Start : Header -->
        <?php  require "header.php"; ?>
        <!-- End : Header -->

        <form action="membermanagement.php" method="POST">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">

                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col">
                                    <center>
                                        <h4>Member Details</h4>
                                    </center>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <center>
                                        <img src="imgs/generaluser.png" width="100px">
                                    </center>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <hr>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Member ID</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input name="member_id" id="member_id" type="text" class="form-control" placeholder="ID">
                                            <input type="button" class="btn btn-primary" value="Go" onclick="fill_input()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Full Name</label>
                                    <div class="form-group">
                                        <input id="member_name" type="text" class="form-control" placeholder="Full Name" readonly="true">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label for="">Account Status</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input id="account_status" type="text" class="form-control" placeholder="Status" readonly="true">
                                            <input name="role" value="A" type="submit" class="btn btn-success ml-1">
                                            <input name="role" value="P" type="submit" class="btn btn-warning ml-1">
                                            <input name="role" value="D" type="submit" class="btn btn-danger ml-1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">DOB</label>
                                    <div class="form-group">
                                        <input id="dob" type="date" class="form-control" placeholder="DOB" readonly="true">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Contact No</label>
                                    <div class="form-group">
                                        <input id="contact_no" type="number" class="form-control" placeholder="Contact No" readonly="true">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label for="">E-mail</label>
                                    <div class="form-group">
                                        <input id="email" type="email" class="form-control" placeholder="E-mail" readonly="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">State</label>
                                    <div class="form-group">
                                        <input id="state" type="text" class="form-control" placeholder="State" readonly="true">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">City</label>
                                    <div class="form-group">
                                        <input id="city" type="text" class="form-control" placeholder="City" readonly="true">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Pin Code</label>
                                    <div class="form-group">
                                        <input id="pincode" type="number" class="form-control" placeholder="Pin code" readonly="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="">Full Postal Address</label>
                                    <div class="form-group">
                                        <textarea class="form-control" name="" id="full_address" cols="30" rows="2"
                                         placeholder="Full Postal Address" readonly="true"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8 mx-auto">
                                    <input name="role" value="Delete" type="submit" class="btn btn-danger btn-block btn-lg">
                                </div>
                            </div>

                        </div>
                    </div>
                    <br><br>

                </div>

                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col">
                                    <center>
                                        <h4>Member List</h4>
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
                                    <table class="table table-striped">
                                        <thead>
                                          <tr>
                                            <th scope="col">Meber_ID</th>
                                            <th scope="col">Member_Name</th>
                                            <th scope="col">Account_Status</th>
                                            <th scope="col">Contact_No</th>
                                            <th scope="col">E-mail</th>
                                            <th scope="col">State</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            for($i=1;$i<=$result->num_rows;$i++){
                                                $row = $result->fetch_assoc();
                                            ?>
                                            <tr>
                                                <td><?php echo $row['member_id']; ?></td>
                                                <td><?php echo $row['fullname']; ?></td>
                                                <td><?php echo $row['account_status']; ?></td>
                                                <td><?php echo $row['contact_no']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['state']; ?></td>
                                            </tr>
                                            <?php 
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>

        <!-- Start : footer -->
        <?php  require "footer.php"; ?>
        <!-- End : footer -->
    </body>
</html>