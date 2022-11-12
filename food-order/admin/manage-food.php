<?php include('partials/menu.php'); ?>

<!-- Main Content section -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Pizza</h1>
        <br><br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; // display session message
            unset($_SESSION['add']); // remove the session message
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete']; // display session message
            unset($_SESSION['delete']); // remove the session message
        }
        if (isset($_SESSION['remove'])) {
            echo $_SESSION['remove']; // display session message
            unset($_SESSION['remove']); // remove the session message
        }
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload']; // display session message
            unset($_SESSION['upload']); // remove the session message
        }
        if (isset($_SESSION['unauthorized'])) {
            echo $_SESSION['unauthorized']; // display session message
            unset($_SESSION['unauthorized']); // remove the session message
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update']; // display session message
            unset($_SESSION['update']); // remove the session message
        }
        ?>

        <br><br>
        <!-- Button to add Pizza -->
        <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Pizza</a>
        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php

            // sql query to get all food
            $sql = "SELECT * FROM tbl_food";

            //exe
            $res = mysqli_query($conn, $sql);

            // Count rows to check we have food or not
            $count = mysqli_num_rows($res);

            // Create sn var to display serial num
            $sn = 1;

            if ($count > 0) {
                // we have food
                // Get the food from db and display
                while ($row = mysqli_fetch_assoc($res)) {
                    // get values from individual col
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
            ?>

                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td>Rs. <?php echo $price; ?></td>
                        <td>
                            <?php

                            // Check we have img or not
                            if ($image_name == "") {
                                // We don't have img
                                echo "<div class='error'>Image not added.</div>";
                            }else{
                                // We have img
                            ?>

                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name ?>" width="100px">

                            <?php
                            }

                            ?>
                        </td>
                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                            <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a> 
                        </td>
                    </tr>

            <?php
                }
            } else {
                // no food in db
                echo "<tr><td colspan='7'>Food not added yet.</td></tr>";
            }

            ?>

        </table>

    </div>
</div>

<?php include('partials/footer.php'); ?>