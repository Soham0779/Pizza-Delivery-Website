<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php 

            //1. Get id of selected id
            $id = $_GET['id'];

            //2. SQL query
            $sql = "SELECT * FROM tbl_admin WHERE id='$id'";

            //exe query
            $res = mysqli_query($conn, $sql);

            // Check the qry is exe or not
            if($res == true){
                // Check if data is available or not
                $count = mysqli_num_rows($res);
                //Check whether we have admin data or not
                if($count==1){
                    // Get the details
                    $row = mysqli_fetch_assoc($res);
                    $full_name = $row['full_name'];
                    $username = $row['username'];
                }else{
                    //redirect to manage admin page
                    header("location:".SITEURL.'admin/manage-admin.php');
                }
            }

        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Enter your name" value="<?php echo $full_name; ?>"></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Enter username" value="<?php echo $username; ?>"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" >
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 

    // Check submit is clicked or not
    if(isset($_POST['submit'])){
        // 1. get all val from form
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        //sql query to UPDATE
        $sql = "UPDATE tbl_admin SET 
        full_name = '$full_name',
        username = '$username'
        WHERE id='$id'
        ";

        // Exe the query
        $res = mysqli_query($conn,$sql);

        // Check the query is exe or not
        if($res==true){
            // Query exe
            $_SESSION['update'] = "<div class='success'>Admin updated successfully</div>";
            //redirect to manage admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }else{
            //Error
            // Query exe
            $_SESSION['update'] = "<div class='error'>Failed to update admin</div>";
            //redirect to manage admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }

    }

?>

<?php include('partials/footer.php'); ?>