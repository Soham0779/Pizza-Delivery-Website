<?php include('partials/menu.php'); ?>

<?php

//Check whether the id is set or not
if (isset($_GET['id'])) {
    //get id
    $id = $_GET['id'];
    //Query
    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
    // exe
    $res2 = mysqli_query($conn, $sql2);
    // Count the rows
    $count2 = mysqli_num_rows($res2);

    if ($count2 == 1) {
        //get all the data
        $row2 = mysqli_fetch_assoc($res2);

        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    } else {
        //redirect
        $_SESSION['no-food-found'] = "<div class='error'>Food Item not found</div>";
        header("location:" . SITEURL . 'admin/manage-food.php');
    }
} else {
    //redirect to manage-category
    header("location:" . SITEURL . 'admin/manage-food.php');
}

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food Item</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title ?>" placeholder="Food title">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price ?>" placeholder="Price of food in Rs. ">
                    </td>
                </tr>
                <tr>
                    <td>Current Image</td>
                    <td>
                        <?php

                        if ($current_image != "") {
                            //display the image
                        ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="120px">
                        <?php
                        } else {
                            // Display msg
                            echo "<div class='error'>Image Not Available</div>";
                        }

                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php

                            $sql = "select * from tbl_category where active='Yes'";
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);
                            if ($count > 0) {
                                // Category available
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];
                                    // echo "<option value='$category_id'>$category_title</option>";
                            ?>
                                    <option <?php if ($current_category == $category_id) {
                                                echo "selected";
                                            } ?> value='<?php echo $category_id ?>'><?php echo $category_title ?></option>
                            <?php
                                }
                            } else {
                                // Category not available
                                echo "<option value='0'>Category Not available</option>";
                            }

                            ?>
                            <option value="0">Test Category</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Food Item" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>

<?php

// If submit button is cliced or not
if (isset($_POST['submit'])) {
    // Process our form
    // 1. Get all the values from the form

    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $current_image = $_POST['current_image'];
    $category = $_POST['category'];

    $featured = $_POST['featured'];
    $active = $_POST['active'];

    // 2. Updating new image if selected
    // check whether the img is selected or not
    if (isset($_FILES['image']['name'])) {
        // Get the img details
        $image_name = $_FILES['image']['name'];
        // CHeck whether image is available or not
        if ($image_name != "") {
            //image available
            // upload new img

            // Authenticatation to auto rename image
            // Get extension of image eg .jpg .png
            $ext = end(explode('.', $image_name));

            // rename the image
            $image_name = "Food_Name_" . rand(000, 999) . '.' . $ext; // eg Pizza_category_121.jpg

            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../images/food/" . $image_name;

            // Upload image
            $upload = move_uploaded_file($source_path, $destination_path);

            // Check whether the image is uploaded or not
            // if img is not uploaded then stop the process and rediect with error msg
            if ($upload == false) {
                // SET system msg
                $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                // redired to add category
                header("location:" . SITEURL . 'admin/manage-food.php');
                // Stop the process
                die();
            }

            //remove the current_image if available
            if ($current_image != "") {
                $remove_path = "../images/food/" . $current_image;
                $remove = unlink($remove_path);

                // check whether the img is removed or not
                // if failed to remove then display msg and stop process
                if ($remove == false) {
                    // Failed to remove img
                    $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image</div>";
                    header("location:" . SITEURL . 'admin/manage-food.php');
                    die();
                }
            }
        } else {
            $image_name = $current_image;
        }
    } else {
        $image_name = $current_image;
    }

    // 3. Update database
    $sql3 = "UPDATE tbl_food SET
                    title='$title',
                    description='$description',
                    price=$price,
                    image_name='$image_name',
                    category_id='$category',
                    featured='$featured',
                    active='$active'
                    WHERE id=$id
                ";

    // Execute the query
    $res3 = mysqli_query($conn, $sql3);

    // 4. redirect
    //check query executed or not
    if ($res3 == true) {
        //Category updated
        $_SESSION['update'] = "<div class='success'>Food Item updated successfully</div>";
        header("location:" . SITEURL . 'admin/manage-food.php');
    } else {
        //Failed to update food
        $_SESSION['update'] = "<div class='error'>Failed to update food item</div>";
        header("location:" . SITEURL . 'admin/manage-food.php');
    }
}
?>

<?php include('partials/footer.php'); ?>