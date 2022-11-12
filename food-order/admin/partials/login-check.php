<?php 

    //Authorization
    //check user is logged in or not
    if(!isset($_SESSION['user']))
    {
        //if user not logged in
        //redirect to login
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access admin panel</div>";
        header("location:".SITEURL.'admin/login.php');
    }

?>
