<?php include('partials/menu.php'); ?>

<!-- Main Content section -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add']; // display session message
            unset($_SESSION['add']); // remove the session message
        }
        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete']; // display session message
            unset($_SESSION['delete']); // remove the session message
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update']; // display session message
            unset($_SESSION['update']); // remove the session message
        }
        if (isset($_SESSION['user-not-found'])) {
            echo $_SESSION['user-not-found']; // display session message
            unset($_SESSION['user-not-found']); // remove the session message
        }
        if (isset($_SESSION['password-not-matched'])) {
            echo $_SESSION['password-not-matched']; // display session message
            unset($_SESSION['password-not-matched']); // remove the session message
        }
        if (isset($_SESSION['change-password'])) {
            echo $_SESSION['change-password']; // display session message
            unset($_SESSION['change-password']); // remove the session message
        }
        ?>
        <br><br><br>

        <!-- Button to add Admin -->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
            //query to get all admin
            $sql = "SELECT * FROM tbl_admin";
            // execute the query
            $res = mysqli_query($conn, $sql);

            //Check whether the query is exe or not
            if ($res == true) {
                // Count rows to check whether we have data in db or not
                $count = mysqli_num_rows($res); // functiom to get all the rows in db

                // Check the num of rows
                if ($count > 0) {
                    // we have data in db

                    $sn = 1;
                    while ($rows = mysqli_fetch_assoc($res)) {
                        //Using while loop to get data from db
                        //will run till we have data in db

                        //Get individual data
                        $id = $rows['id'];
                        $full_name = $rows['full_name'];
                        $username = $rows['username'];

                        //Display values in table
            ?>
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                            </td>
                        </tr>
            <?php
                    }
                } else {
                    //db is empty
                }
            }
            ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>