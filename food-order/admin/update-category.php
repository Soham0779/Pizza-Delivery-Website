<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update category</h1>
        <br><br>

        <?php

        //Check whether the id is set or not
        if (isset($_GET['id'])) {
            //get id
            $id = $_GET['id'];
            //Query
            $sql = "SELECT * FROM tbl_category WHERE id='$id'";
            // exe
            $res = mysqli_query($conn, $sql);
            // Count the rows
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                //get all the data
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                //redirect
                $_SESSION['no-category-found'] = "<div class='error'>Category not found</div>";
                header("location:" . SITEURL . 'admin/manage-category.php');
            }
        } else {
            //redirect to manage-category
            header("location:" . SITEURL . 'admin/manage-category.php');
        }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title ?>" placeholder="Category title">
                    </td>
                </tr>
                <tr>
                    <td>Current Image</td>
                    <td><?php

                        if ($current_image != "") {
                            //display the image
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" alt="" width="120px">
                        <?php
                        } else {
                            // Display msg
                            echo "<div class='error'>Image Not Added</div>";
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
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php

        // If submit button is clicked or not
        if (isset($_POST['submit'])) {
            // Process our form
            // 1. Get all the values from the form

            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
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
                    $image_name = "Pizza_category_" . rand(000, 999) . '.' . $ext; // eg Pizza_category_121.jpg

                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/" . $image_name;

                    // Upload image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    // Check whether the image is uploaded or not
                    // if img is not uploaded then stop the process and rediect with error msg
                    if ($upload == false) {
                        // SET system msg
                        $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                        // redired to add category
                        header("location:" . SITEURL . 'admin/manage-category.php');
                        // Stop the process
                        die();
                    }

                    //remove the current_image if available
                    if ($current_image != "") {
                        $remove_path = "../images/category/" . $current_image;
                        $remove = unlink($remove_path);

                        // check whether the img is removed or not
                        // if failed to remove then display msg and stop process
                        if ($remove == false) {
                            // Failed to remove img
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image</div>";
                            header("location:" . SITEURL . 'admin/manage-category.php');
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
            $sql2 = "UPDATE tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                    WHERE id=$id
                ";

            // Execute the query
            $res2 = mysqli_query($conn, $sql2);

            // 4. redirect
            //check query executed or not
            if ($res2 == true) {
                //Category updated
                $_SESSION['update'] = "<div class='success'>Category updated successfully</div>";
                header("location:" . SITEURL . 'admin/manage-category.php');
            } else {
                //Failed to update caegory
                $_SESSION['update'] = "<div class='error'>Failed to update category</div>";
                header("location:" . SITEURL . 'admin/manage-category.php');
            }
        }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>