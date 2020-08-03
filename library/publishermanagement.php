<?php

require "db_connect.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $t="";
    $f="";

    $publisher_id=$_POST["publisher_id"];
    $publisher_name=$_POST["publisher_name"];
    $role=$_POST["role"];

    if($role=="Add"){
        $sql = "select * from publisher_master_tbl where publisher_id='$publisher_id' ";
        $result=$mysqli->query($sql);
    
        if ( $result->num_rows == 1) {
            $f="Publisher ID Should be Different!";
        }
        else {
            $sql = "INSERT INTO publisher_master_tbl (publisher_id,publisher_name)
                    VALUES ('$publisher_id', '$publisher_name')";
    
            $result=$mysqli->query($sql);
            if($result){
                $t="Publisher is Successfully Added!";
            }
        }
    }
    else if($role=="Update"){

        $sql = "select * from publisher_master_tbl where publisher_id='$publisher_id' ";
        $result=$mysqli->query($sql);
    
        if ($result->num_rows==1) {
            $sql="update publisher_master_tbl set publisher_name='$publisher_name' where publisher_id='$publisher_id' ";
            $result=$mysqli->query($sql);
    
            if($result){
                $t="Publisher name is Successfully Updated!";
            }
        }
        else {
            $f="No Publisher Id is Found!";
        }
    }
    else if($role=="Delete"){
        $sql = "select * from publisher_master_tbl where publisher_id='$publisher_id' ";
        $result=$mysqli->query($sql);
    
        if ( $result->num_rows == 1) {
            $sql = "delete from publisher_master_tbl where publisher_id='$publisher_id' ";
            $result=$mysqli->query($sql);
    
            if($result){
                $t="Publisher is Successfully Deleted!";
            }
        }
        else {
            $f="No Publisher Id is Found!";
        }
    }
    header('location: http://localhost/library/publishermanagement.php?t='.$t.'&f='.$f);
}
?>

<?php
// fill table
$mysqli = new mysqli('127.0.0.1', 'root', '', 'elibrarydb', NULL);

$sql = "select * from publisher_master_tbl";
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

            function fill_input(){
                var publisher_id=document.getElementById("publisher_id").value;
                var req=new XMLHttpRequest();
                req.open("GET","http://localhost/library/ajax_publisher.php?publisher_id="+publisher_id, true);
                req.send();
                req.onreadystatechange=function(){
                    if(this.readyState==4 && this.status==200){
                        document.getElementById("publisher_name").value=this.responseText;
                    }
                };
            };
        </script>
    </head>
    <body>
        <!-- Start : Header -->
        <?php  require "header.php"; ?>
        <!-- End : Header -->

        <form action="publishermanagement.php" method="POST">
        <div class="container">
            <div class="row">
                <div class="col-md-5">

                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col">
                                    <center>
                                        <h4>Publisher Details</h4>
                                    </center>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <center>
                                        <img src="imgs/publisher.png" width="100px">
                                    </center>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <hr>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label>Publisher ID</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input name="publisher_id" id="publisher_id" type="text" class="form-control" placeholder="publisher ID">
                                            <input type="button" class="btn btn-primary" value="Go" onclick="fill_input()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label for="">Publisher Name</label>
                                    <div class="form-group">
                                        <input name="publisher_name" id="publisher_name" type="text" class="form-control" placeholder="Publisher Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <input type="submit" name="role" class="btn btn-success btn-block" value="Add">
                                </div>
                                <div class="col-4">
                                    <input type="submit" name="role" class="btn btn-warning btn-block" value="Update">
                                </div>
                                <div class="col-4">
                                    <input type="submit" name="role" class="btn btn-primary btn-block" value="Delete">
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
                                        <h4>Publisher List</h4>
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
                                                <th scope="col">Publisher_ID</th>
                                                <th scope="col">Publisher_Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for($i=1;$i<=$result->num_rows;$i++){
                                                    $row = $result->fetch_assoc();
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['publisher_id']; ?></td>
                                                    <td><?php echo $row['publisher_name']; ?></td>
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