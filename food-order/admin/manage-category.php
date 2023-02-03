<?php

use function PHPSTORM_META\map;

include('partials/menu.php'); ?>

<!-- Main Content section -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Category</h1>
        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; // display session message
            unset($_SESSION['add']); // remove the session message
        }
        if (isset($_SESSION['remove'])) {
            echo $_SESSION['remove']; // display session message
            unset($_SESSION['remove']); // remove the session message
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete']; // display session message
            unset($_SESSION['delete']); // remove the session message
        }
        if (isset($_SESSION['no-category-found'])) {
            echo $_SESSION['no-category-found']; // display session message
            unset($_SESSION['no-category-found']); // remove the session message
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update']; // display session message
            unset($_SESSION['update']); // remove the session message
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload']; // display session message
            unset($_SESSION['upload']); // remove the session message
        }
        if (isset($_SESSION['failed-remove'])) {
            echo $_SESSION['failed-remove']; // display session message
            unset($_SESSION['failed-remove']); // remove the session message
        }
        ?>
        <br><br>

        <!-- Button to add Category -->
        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php

            // 1. SQL q to select all rows and display
            $sql = "SELECT * FROM tbl_category";

            // Execution
            $res = mysqli_query($conn, $sql);

            // Count rows
            $count = mysqli_num_rows($res);

            $sn = 1;

            //Check we have data in db
            if ($count > 0) {
                //we have data
                // Get the data and sdisplay
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

            ?>

                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>

                        <td>
                            <?php
                            //Check whether img name available or not
                            if ($image_name != "") {
                                //display img
                            ?>

                                <img src="<?php echo SITEURL ?>images/category/<?php echo $image_name ?>" width="150px">

                            <?php
                            } else {
                                //display msg
                                echo "<div class='error'>Image not available</div>";
                            }
                            ?>
                        </td>

                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a> 
                        </td>
                    </tr>

                <?php
                }
            } else {
                //we dont have data
                //will display msg inside table
                ?>

                <tr>
                    <td colspan="6">
                        <div class="error">No Category added</div>
                    </td>
                </tr>

            <?php
            }

            ?>
        </table>

    </div>
</div>

<?php include('partials/footer.php'); ?>