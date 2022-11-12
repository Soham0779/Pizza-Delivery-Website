<?php

use function PHPSTORM_META\map;

include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Pizza or Other food here</h1>
        <br><br>

        <?php

        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload']; // display session message
            unset($_SESSION['upload']); // remove the session message
        }
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; // display session message
            unset($_SESSION['add']); // remove the session message
        }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" placeholder="Enter Title"></td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td><textarea name="description" placeholder="Description of pizza" cols="30" rows="5"></textarea></td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td><input type="number" name="price"></td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                            <?php

                            // PHP code to display categories from db
                            // 1. Create sql to get active categories
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            //exe
                            $res = mysqli_query($conn, $sql);
                            //count rows to check whether we have categories or not
                            $count = mysqli_num_rows($res);

                            // if count > 0 we have categories else we dont have
                            if ($count > 0) {
                                // we have categories
                                while ($row = mysqli_fetch_assoc($res)) {
                                    // Get the details of caegory
                                    $id = $row['id'];
                                    $title = $row['title'];
                            ?>
                                    <option value="<?php echo $id ?>"><?php echo $title ?></option>
                                <?php
                                }
                            } else {
                                // we dont have categories
                                ?>
                                <option value="0">No Category found</option>
                            <?php
                            }

                            // 2. display on dropdown


                            ?>

                        </select>
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
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php

        // Check whether the button is clicked or not
        if (isset($_POST['submit'])) {
            //add the food in db
            // 1. Get the data from form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            // for radio input type we have to check whether the the button is selected or not
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

            // 2. Upload image of selected
            // Check whether select img is clicked or not and upload img if selected
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
                        header("location:" . SITEURL . 'admin/add-food.php');
                        // Stop the process
                        die();
                    }
                }
            } else {
                //Don't upload img and set default img name value as blank
                $image_name = "";
            }

            // 3. Insert into db
            $sql2 = "INSERT INTO tbl_food SET 
                title='$title',
                description='$description',
                price=$price,
                image_name='$image_name',
                category_id=$category,
                featured='$featured',
                active='$active'
            ";

            //exe
            $res2 = mysqli_query($conn, $sql2);

            // Check data inserted or not
            if ($res == true) {
                // Query exe and category added
                $_SESSION['add'] = "<div class='success'>Food added successfully</div>";
                //redirect
                header("location:" . SITEURL . 'admin/manage-food.php');
            } else {
                // Failed to add data
                $_SESSION['add'] = "<div class='error'>Failed to add category</div>";
                //redirect
                header("location:" . SITEURL . 'admin/add-food.php');
            }
        }

        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>