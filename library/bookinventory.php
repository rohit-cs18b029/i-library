<?php

require "db_connect.php";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $t="";
    $f="";

    $book_id=$_POST["book_id"];
    $book_name=$_POST["book_name"];
    $language=$_POST["language"];
    $publisher_name=$_POST["publisher_name"];
    $author_name=$_POST["author_name"];
    $publish_date=$_POST["publish_date"];
    $genre=$_POST['genre'];
    $edition=$_POST["edition"];
    $book_cost=$_POST["book_cost"];
    $pages=$_POST["no_of_pages"];
    $actual_stock=$_POST["actual_stock"];
    $current_stock=$_POST["current_stock"];
    $book_description=$_POST["book_description"];
    $role=$_POST['role'];

    $file=$_FILES['img_file'];
    $path="photos/".$file['name'];

    if($role=="Add"){
        if(file_exists($path)){
            $f=$file['name']." already exists, can not add this book";
        }
        else if($file['type']=="image/jpeg"){
            $sql = "select * from book_inventory where book_id='$book_id' ";
            $result=$mysqli->query($sql);
        
            if ( $result->num_rows == 1) {
                $f="Book ID Should be Different!";
            }
            else {
                $sql = "INSERT INTO book_inventory (book_id,book_name,language,publisher_name,author_name,publish_date,
                    genre,edition,book_cost,pages,actual_stock,current_stock,book_description,img_link)
                    VALUES ('$book_id','$book_name','$language','$publisher_name','$author_name','$publish_date',
                    '$genre','$edition','$book_cost','$pages','$actual_stock','$actual_stock','$book_description','$path')";
        
                $result=$mysqli->query($sql);
                if($result){
                    $t="Book is Successfully Added!";
                    move_uploaded_file($file['tmp_name'],$path);
                }
            }
        }
        else{
            $f="file format is not valid, unable to upload";
        }
    }
    else if($role=="Update"){
        $sql = "select * from book_inventory where book_id='$book_id' ";
        $result=$mysqli->query($sql);
        if ($result->num_rows==1) {
            if($file['type']=="image/jpeg"){
                $sql="update book_inventory set book_name='$book_name',publisher_name='$publisher_name',author_name='$author_name',
                publish_date='$publish_date',pages='$pages',book_cost='$book_cost',book_description='$book_description',
                language='$language',img_link='$path',actual_stock='$actual_stock' where book_id='$book_id' ";

                $result=$mysqli->query($sql);
                if($result){
                    if(!file_exists($path)){
                        move_uploaded_file($file['tmp_name'],$path);
                    }
                    $t="Book Details is Successfully Updated!";
                }
            }
            else{
                $f="file format is not valid, unable to upload";
            }
        }
        else {
            $f="No Book Id is Found!";
        }
    }
    else if($role=="Delete"){
        $sql = "select * from book_inventory where book_id='$book_id' ";
        $result=$mysqli->query($sql);
    
        if ( $result->num_rows == 1) {
            $sql = "delete from book_inventory where book_id='$book_id' ";
            $result=$mysqli->query($sql);
    
            if($result){
                $t="Book is Successfully Deleted!";
            }
        }
        else {
            $f="No Book Id is Found!";
        }
    }
    header('location: http://localhost/library/bookinventory.php?t='.$t.'&f='.$f);
}
?>

<?php

$mysqli = new mysqli('127.0.0.1', 'root', '', 'elibrarydb', NULL);

$sql = "select * from author_master_tbl";
$result=$mysqli->query($sql);

$sql = "select * from publisher_master_tbl";
$result1=$mysqli->query($sql);

$sql = "select * from book_inventory";
$result2=$mysqli->query($sql);


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
                document.getElementById("language").value=res[1];
                document.getElementById("publisher_name").value=res[2];
                document.getElementById("author_name").value=res[3];
                document.getElementById("publish_date").value=res[4];
                document.getElementById("genre").value=res[5];
                document.getElementById("edition").value=res[6];
                document.getElementById("book_cost").value=res[7];
                document.getElementById("pages").value=res[8];
                document.getElementById("actual_stock").value=res[9];
                document.getElementById("current_stock").value=res[10];
                document.getElementById("book_description").value=res[11];
                document.getElementById("imgs").src=res[12];
                document.getElementById("issued_book").value=document.getElementById("actual_stock").value-document.getElementById("current_stock").value;
            };

            function fill_input(){
                var book_id=document.getElementById("book_id").value;
                var req=new XMLHttpRequest();
                req.open("GET","http://localhost/library/ajax_bookinventory.php?book_id="+book_id, true);
                req.send();
                req.onreadystatechange=function(){
                    if(this.readyState==4 && this.status==200){
                        if(this.responseText=="000"){
                            alert("No Book id is found!");
                        }
                        else{
                            split_string(this.responseText);
                        }
                    }
                };
            };
        </script>
    </head>
    <body>
        <!-- Start : Header -->
        <?php  require "header.php"; ?>
        <!-- End : Header -->

        <form action="bookinventory.php" method="POST" enctype="multipart/form-data">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">

                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col">
                                    <center>
                                        <h4>Book Details</h4>
                                    </center>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <center>
                                        <img id="imgs" src="imgs/books.png" width="100px">
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
                                    <div class="form-group">
                                        <input id="img_link" type="file" name="img_file" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Book ID</label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input id="book_id" name="book_id" type="text" class="form-control" placeholder="ID">
                                            <input type="button" class="btn btn-primary" value="Go" onclick="fill_input()">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <label for="">Book Name</label>
                                    <div class="form-group">
                                        <input id="book_name" name="book_name" type="text" class="form-control" placeholder="Book Name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Language</label>
                                            <div class="form-group">
                                                <select name="language" id="language" class="form-control">
                                                    <option value="English">English</option>
                                                    <option value="Hindi">Hindi</option>
                                                    <option value="Marathi">Marathi</option>
                                                    <option value="French">French</option>
                                                    <option value="German">German</option>
                                                    <option value="Urdu">Urdu</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Publisher Name</label>
                                            <div class="form-group">
                                                <select name="publisher_name" id="publisher_name" class="form-control">
                                                <?php
                                                for($i=1;$i<=$result1->num_rows;$i++){
                                                    $row = $result1->fetch_assoc();
                                                ?>
                                                <option value="<?php echo $row['publisher_name']?>"><?php echo $row['publisher_name']?></option>
                                                <?php 
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Author Name</label>
                                            <div class="form-group">
                                                <select name="author_name" id="author_name" class="form-control">
                                                <?php
                                                for($i=1;$i<=$result->num_rows;$i++){
                                                    $row = $result->fetch_assoc();
                                                ?>
                                                <option value="<?php echo $row['author_name']?>"><?php echo $row['author_name']?></option>
                                                <?php 
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Publish Date</label>
                                            <div class="form-group">
                                                <input id="publish_date" name="publish_date" type="date" class="form-control" placeholder="Publisher Date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Genre</label>
                                    <div class="form-group">
                                        <select name="genre" id="genre" size="5" class="form-control" multiple>
                                            <option value="Action">Action</option>
                                            <option value="Adventure">Adventure</option>
                                            <option value="Comic Book">Comic Book</option>
                                            <option value="Self Help">Self Help</option>
                                            <option value="Motivation">Motivation</option>
                                            <option value="Healthy Living">Healthy Living</option>
                                            <option value="Wellness">Wellness</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Edition</label>
                                    <div class="form-group">
                                        <input id="edition" name="edition" type="text" class="form-control" placeholder="Edition">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Book Cost(perunit)</label>
                                    <div class="form-group">
                                        <input id="book_cost" name="book_cost" type="number" class="form-control" placeholder="Book Cost(perunit)">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Pages</label>
                                    <div class="form-group">
                                        <input id="pages" name="no_of_pages" type="number" class="form-control" placeholder="Pages">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">Actual Stock</label>
                                    <div class="form-group">
                                        <input id="actual_stock" name="actual_stock" type="number" class="form-control" placeholder="Actual Stock">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Current Stock</label>
                                    <div class="form-group">
                                        <input id="current_stock" name="current_stock" type="number" class="form-control" placeholder="Current Stock" readonly="true">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Issued Books</label>
                                    <div class="form-group">
                                        <input id="issued_book" name="issued_books" type="number" class="form-control" placeholder="Issued Books" readonly="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="">Book Description</label>
                                    <div class="form-group">
                                        <textarea class="form-control" name="book_description" id="book_description" cols="30" rows="2"
                                         placeholder="Book Description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <input name="role" type="submit" class="btn btn-success btn-block btn-lg" value="Add">
                                </div>
                                <div class="col-4">
                                    <input name="role" type="submit" class="btn btn-warning btn-block btn-lg" value="Update">
                                </div>
                                <div class="col-4">
                                    <input name="role" type="submit" class="btn btn-danger btn-block btn-lg" value="Delete">
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
                                        <h4>Book Inventory List</h4>
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
                                                <th scope="col">ID</th>
                                                <th scope="col"></th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                for($i=1;$i<=$result2->num_rows;$i++){
                                                    $row = $result2->fetch_assoc();
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['book_id']; ?></td>
                                                    <td>
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <h5><?php echo $row['book_name']; ?></h5>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <label>Author - <?php echo $row['author_name']; ?></label>
                                                                            <label> | Genre - <?php echo $row['genre']; ?></label>
                                                                            <label> | Language - <?php echo $row['language']; ?></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <label>Publisher - <?php echo $row['publisher_name']; ?></label>
                                                                            <label> | Publish Date - <?php echo $row['publish_date']; ?></label>
                                                                            <label> | Pages - <?php echo $row['pages']; ?></label>
                                                                            <label> | Edition - <?php echo $row['edition']; ?></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <label>Cost - <?php echo $row['book_cost']; ?></label>
                                                                            <label> | Actual Stock - <?php echo $row['actual_stock']; ?></label>
                                                                            <label> | Available - <?php echo $row['current_stock']; ?></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <label>Description - <?php echo $row['book_description']; ?></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <img class="img-fluid" src="<?php echo $row['img_link']; ?>" width="100px">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
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