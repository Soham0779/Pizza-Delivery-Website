<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>

        <?php 
            if(isset($_SESSION['add'])){
                echo $_SESSION['add']; // display session message
                unset($_SESSION['add']); // remove the session message
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Enter your name"></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Enter username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Enter password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
// process the value from form and save it in database

// check whether the button is clicked or not

if (isset($_POST['submit'])) {
    // button Clicked
    // 1. Get the data from form
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Encryption with md5

    // 2. SQL query to save data in database
    $sql = "INSERT INTO tbl_admin SET
        full_name = '$full_name',
        username = '$username',
        password = '$password'
        ";
    // 3. database connection done in config/constants.php
    // 4. query execution
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    // 5. Check data is inserted or query is executed and display appropriate message
    if($res == true){
        //Data inserted
        //Create session variable
        $_SESSION['add'] = "<div class='success'>Admin added successfully </div>";
        //redirect to manage-admin page
        header("location:".SITEURL.'admin/manage-admin.php');
    }else{
        //Failed to insert data
        //Create session variable
        $_SESSION['add'] = "<div class='error'>Failed to add admin </div>";
        //redirect to manage-admin page
        header("location:".SITEURL.'admin/add-admin.php');
    }
}

?>