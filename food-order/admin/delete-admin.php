<?php

    //include constants.php here
    include('../config/constants.php');

    // 1. Get the id of the admin to be deleted
    $id = $_GET['id'];

    // 2. Query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id='$id'";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // 3. Redirect to manage-admin with success or error message
    // Check whether the query executed successfully
    if($res==true){
        // Success and admin is deleted
        //Create session variable to display message 
        $_SESSION['delete'] = "<div class='success'> Admin deleted successfully </div>";
        //redirect to admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }else{
        //Failed to delete
        //Create session variable to display message 
        $_SESSION['delete'] = "<div class='error'>Admin is not deleted Error occurred </div>";
        //redirect to admin page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    

?>