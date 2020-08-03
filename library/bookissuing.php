<?php

require "db_connect.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $t="";
    $f="";

    $book_id=$_POST["book_id"];
    $book_name=$_POST["book_name"];
    $member_id=$_POST["member_id"];
    $member_name=$_POST["member_name"];
    $start_date=$_POST["start_date"];
    $end_date=$_POST["end_date"];
    $role=$_POST["role"];

    if($role=="Issue"){
        $sql = " select * from book_inventory where book_id='$book_id' ";
        $result=$mysqli->query($sql);
        
        if ( $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if($row['current_stock']>0){
                $q = " select * from member_master_tbl where member_id='$member_id' ";
                $result=$mysqli->query($q);
                if( $result->num_rows == 1){
                    $sql = "select * from book_issue_tbl where book_id='$book_id' and member_id='$member_id' ";
                    $result=$mysqli->query($sql);
                    if ( $result->num_rows == 0) {
                        $sql = "INSERT INTO book_issue_tbl (book_id,book_name,member_id,member_name,issue_date,due_date)
                                VALUES ('$book_id', '$book_name','$member_id', '$member_name','$start_date', '$end_date')";
    
                        $result=$mysqli->query($sql);
                        if($result){
                            $sql = "update book_inventory set current_stock=current_stock-1 where book_id='$book_id' ";
                            $mysqli->query($sql);
                            $t= "Book is Successfully Issued!";
                        }
                    }
                    else{
                        $f="Can not Issue Same Book Again to the Same Member!";
                    }
                }
                else{
                    $f="Wrong member id";
                }
            }
            else{
                $f="Stock Over!";
            }
        }
        else {
            $f="wrong book id!";
        }
    }
    
    else if($role=="Return"){
        $sql = "select * from book_issue_tbl where book_id='$book_id' and member_id='$member_id' ";
        $result=$mysqli->query($sql);
    
        if ( $result->num_rows == 1) {
            $sql = "delete from book_issue_tbl where book_id='$book_id' and member_id='$member_id'";
                $result=$mysqli->query($sql);
                if($result){
                    $sql = "update book_inventory set current_stock=current_stock+1 where book_id='$book_id' ";
                    $mysqli->query($sql);
                    $t="Book is Successfully Returned!";
                }
        }
        else {
            $f="Can Not Return Bcz He Does not Have It!";
        }
    }
    header('location: http://localhost/library/bookissuing.php?t='.$t.'&f='.$f);
}
?>

<?php
//fill table
$sql = "select * from book_issue_tbl";
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
                document.getElementById("book_name").value=res[0];
                document.getElementById("member_name").value=res[1];
            };

            function fill_input(){
                var book_id=document.getElementById("book_id").value;
                var member_id=document.getElementById("member_id").value;
                var req=new XMLHttpRequest();
                req.open("GET","http://localhost/library/ajax_bookissuing.php?book_id="+book_id+"&member_id="+member_id, true);
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

        <form action="bookissuing.php" method="POST">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">

                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col">
                                    <center>
                                        <h4>Book Issuing</h4>
                                    </center>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <center>
                                        <img src="imgs/books.png" width="100px">
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
                                    <label for="">Member ID</label>
                                    <div class="form-group">
                                        <input name="member_id" id="member_id" type="text" class="form-control" placeholder="Member ID">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Book ID</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input name="book_id" id="book_id" type="text" class="form-control" placeholder="Book ID">
                                            <input type="button" class="btn btn-primary" value="Go" onclick="fill_input()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Member Name</label>
                                    <div class="form-group">
                                        <input name="member_name" id="member_name" type="text" class="form-control" placeholder="Member Name" readonly="true">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Book Name</label>
                                    <div class="form-group">
                                        <input name="book_name" id="book_name" type="text" class="form-control" placeholder="Book Name" readonly="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Start Date</label>
                                    <div class="form-group">
                                        <input name="start_date" type="date" class="form-control" placeholder="Start Date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">End Date</label>
                                    <div class="form-group">
                                        <input name="end_date" type="date" class="form-control" placeholder="End Date">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <input name="role" type="submit" class="btn btn-primary btn-block btn-lg" value="Issue">
                                </div>
                                <div class="col-6">
                                    <input name="role" type="submit" class="btn btn-warning btn-block btn-lg" value="Return">
                                </div>
                            </div>

                        </div>
                    </div>

                    <a href="index.php"><< Back to Home</a>
                    <br><br>

                </div>

                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col">
                                    <center>
                                        <h4>Issued Book List</h4>
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
                                    <table class="table table-striped table-bordered">
                                            <thead>
                                              <tr>
                                                <th scope="col">Book_ID</th>
                                                <th scope="col">Book_Name</th>
                                                <th scope="col">Member_ID</th>
                                                <th scope="col">Member_Name</th>
                                                <th scope="col">Start_Date</th>
                                                <th scope="col">End_Date</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                for($i=1;$i<=$result->num_rows;$i++){
                                                    $row = $result->fetch_assoc();
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['book_id']; ?></td>
                                                    <td><?php echo $row['book_name']; ?></td>
                                                    <td><?php echo $row['member_id']; ?></td>
                                                    <td><?php echo $row['member_name']; ?></td>
                                                    <td><?php echo $row['issue_date']; ?></td>
                                                    <td><?php echo $row['due_date']; ?></td>
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