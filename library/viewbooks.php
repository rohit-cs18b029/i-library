<?php

$mysqli = new mysqli('127.0.0.1', 'root', '', 'elibrarydb', NULL);

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
        </script>
    </head>
    <body>
        <!-- Start : Header -->
        <?php  require "header.php"; ?>
        <!-- End : Header -->

        <div class="container">
            <div class="row">
                <div class="col-12">
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

        <!-- Start : footer -->
        <?php  require "footer.php"; ?>
        <!-- End : footer -->
    </body>
</html>