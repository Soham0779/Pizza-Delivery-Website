<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; // display session message
            unset($_SESSION['add']); // remove the session message
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload']; // display session message
            unset($_SESSION['upload']); // remove the session message
        }
        ?>

        <br><br>

        <!-- Add category form starts here -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Category title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php

        // Check submit is clicked or not
        if (isset($_POST['submit'])) {
            // 1. Get the val from form
            $title = $_POST['title'];

            // for radio input type we have to check wheter the the button is selected or not
            if (isset($_POST['featured'])) {
                // Get the value from form
                $featured = $_POST['featured'];
            } else {
                // Set the default value
                $featured = "No";
            }

            if (isset($_POST['active'])) {
                // Get the value from form
                $active = $_POST['active'];
            } else {
                // Set the default value
                $active = "No";
            }

            // Check img is selected or not and set the value for img name
            if (isset($_FILES['image']['name'])) {
                //upload the img
                //need - img name, src, dst
                $image_name = $_FILES['image']['name'];

                // If image name is available then upload
                if ($image_name != "") {



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
                        header("location:" . SITEURL . 'admin/add-category.php');
                        // Stop the process
                        die();
                    }
                }
            } else {
                //Don't upload img and set img name value as blank
                $image_name = "";
            }

            // 2. SQL query
            $sql = "INSERT INTO tbl_category SET 
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'
            ";

            // 3. Execute the query
            $res = mysqli_query($conn, $sql);

            // 4. Check query is exe or not and data added is added or not
            if ($res == true) {
                // Query exe and category added
                $_SESSION['add'] = "<div class='success'>Category added successfully</div>";
                //redirect
                header("location:" . SITEURL . 'admin/manage-category.php');
            } else {
                // Failed to add data
                $_SESSION['add'] = "<div class='error'>Failed to add category</div>";
                //redirect
                header("location:" . SITEURL . 'admin/add-category.php');
            }
        }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>