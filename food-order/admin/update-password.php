<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Enter Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="Enter New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

    </div>
</div>

<?php

// Check submit is clicked or not
if (isset($_POST['submit'])) {
    // 1. get all val from form
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    // 2. Check whether user with that password exsist or not
    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

    //exe
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        //Check data available or not
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            //User exists
            //Check whether the new pass and confirm is equal
            if ($new_password == $confirm_password) {
                //Update pass
                $sql2 = "UPDATE tbl_admin SET
                        password='$new_password'
                        WHERE id=$id
                    ";

                //exe query
                $res2 = mysqli_query($conn, $sql2);

                //Check qry exe or not
                if ($res2 == true) {
                    //Success
                    $_SESSION['change-password'] = "<div class='success'>Password changed successfully</div>";
                    header("location:" . SITEURL . 'admin/manage-admin.php');
                } else {
                    //Error
                    $_SESSION['change-password'] = "<div class='error'>Failed to change password</div>";
                    header("location:" . SITEURL . 'admin/manage-admin.php');
                }
            } else {
                //redirect error
                //User doesn't exist
                $_SESSION['password-not-matched'] = "<div class='error'>Password not matched</div>";
                header("location:" . SITEURL . 'admin/manage-admin.php');
            }
        } else {
            //User doesn't exist
            $_SESSION['user-not-found'] = "<div class='error'>User not found or incorrect password</div>";
            header("location:" . SITEURL . 'admin/manage-admin.php');
        }
    }
}

?>

<?php include('partials/footer.php'); ?>