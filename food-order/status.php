<?php
include('partials-front/menu.php');
?>

<div style="background-color: #f0f8ff;">
    <br><br>

    <h1 style="margin-left: 15%;"> My Order History and Current Status</h1>
    <br><br>
    <table style="margin-left: 15%;" class="tbl-30">
        <tr>
            <th>Food</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Status</th>
        </tr>

        <?php

        if (isset($_SESSION['customer_id'])) {
            $customer_id = $_SESSION['customer_id'];
            // unset($_SESSION['customer_id']);


            $sql = "SELECT * FROM tbl_order WHERE customer_id=$customer_id ORDER BY id DESC";
            $res = mysqli_query($conn, $sql);

            $count = mysqli_num_rows($res);

            if ($count > 0) {
                // rows avail
                while ($row = mysqli_fetch_assoc($res)) {
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $status = $row['status'];

        ?>
                    <tr>
                        <td><?php echo $food ?></td>
                        <td><?php echo $price ?></td>
                        <td><?php echo $qty ?></td>
                        <td><?php echo $total ?></td>
                        <td><?php echo $status ?></td>
                    </tr>
        <?php
                }
            } else {
                // No rows
                echo "<tr><td colspan='5' class='error'>No orders to track</td></tr>";
            }
        }else{
            ?>

            <h1 class="error" style="margin-left: 200px;" >Please Log In to view order Status.</h1>

            <?php
        }
        ?>


    </table>
    <br><br><br><br>

</div>

<?php include('partials-front/footer.php'); ?>