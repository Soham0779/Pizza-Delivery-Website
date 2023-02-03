<?php 

    //include constant.php
    include('../config/constants.php');

    // 1. Destroy the session
    session_destroy(); // unsets $_SESSION['user']

    //redirect to login page
    header("location:".SITEURL.'login/login.php');

?>