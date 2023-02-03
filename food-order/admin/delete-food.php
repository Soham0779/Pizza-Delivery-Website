<?php

//include constants file
include('../config/constants.php');

//Check id or image naem val is set or not
if(isset($_GET['id']) AND isset($_GET['image_name'])){
    //get the val and delete
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //remove the physical img file if available 
    if($image_name != ""){
        //image available and remove it
        $path = "../images/food/".$image_name;
        // to remove
        $remove = unlink($path);

        if($remove==false){
            //failed to remove
            //set the sesssion and redirect
            //Stop the process
            $_SESSION['remove'] = "<div class='error'>Failed to remove the image file</div>";
            header("location:".SITEURL.'admin/manage-food.php');
            die();
        }
    }

    // delete data from db
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    $res = mysqli_query($conn,$sql);

    // Check data deleted from db
    if($res == true){
        //Success and redirect
        $_SESSION['delete'] = "<div class='success'>Food Item deleted successfully</div>";
        header("location:".SITEURL.'admin/manage-food.php');
    }else{
        // Failure and redirect
        $_SESSION['delete'] = "<div class='error'>Failed to delete Food item</div>";
        header("location:".SITEURL.'admin/manage-food.php');
    }

}else{
    // redirect to manage food
    $_SESSION['unauthorized'] = "<div class='error'>Unauthorized access</div>";
    header("location:".SITEURL.'admin/manage-food.php');
}

?>