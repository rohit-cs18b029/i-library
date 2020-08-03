<?php

echo '<footer>
<div id="footer1" class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <p>';
            if(!isset($_SESSION["admin_id"])){
                echo '<a href="adminlogin.php?p=adminlogin" class="footerlinks">Admin Login</a>';
            }
            else{
                echo '<a href="authormanagement.php" class="footerlinks">Author Management</a>
                <a href="publishermanagement.php" class="footerlinks">Publisher Management</a>
                <a href="bookinventory.php" class="footerlinks">Book Inventory</a>
                <a href="bookissuing.php" class="footerlinks">Book Issuing</a>
                <a href="membermanagement.php" class="footerlinks">Member Management</a>';
            }
            echo'</p>
        </div>
    </div>
</div>
<div id="footer2" class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <p style="color: whitesmoke;">&copy All rights Reserved.
                <a href="#" target="_blank" class="footerlinks">Simple Snippets</a>
            </p>
        </div>
    </div>
</div>
</footer>';

?>