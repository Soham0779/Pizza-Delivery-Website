<?php include('partials-front/menu.php'); ?>

<?php

//check whether id is passed or not 
if (isset($_GET['category_id'])) {
    // cat_id is set
    $category_id = $_GET['category_id'];
    // get category title based on cat id
    $sql = "SELECT title FROM tbl_category WHERE id=$category_id";
    $res = mysqli_query($conn, $sql);

    // Get val from db
    $row = mysqli_fetch_assoc($res);
    //get title
    $category_title = $row['title'];
} else {
    // cat not passed redirect
    header('location:' . SITEURL);
}

?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <h2>Food items in <a href="#" class="text-white">"<?php echo $category_title ?>"</a> Category</h2>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php

        // sql
        $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";
        $res2 = mysqli_query($conn, $sql2);
        $count2 = mysqli_num_rows($res2);
        //check food is avail
        if ($count2 > 0) {
            // food avail

            while ($row2 = mysqli_fetch_assoc($res2)) {
                $id = $row2['id'];
                $title = $row2['title'];
                $price = $row2['price'];
                $description = $row2['description'];
                $image_name = $row2['image_name'];
        ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php

                        // img avail or not
                        if ($image_name == "") {
                            // not avail
                            echo "<div class='error'>Image not available</div>";
                        } else {
                            // avail
                        ?>
                            <img style="height: 100px ;" src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                        <?php
                        }

                        ?>

                    </div>

                    <form method="post" action="<?php echo SITEURL ?>cart.php?action=add&id=<?php echo $id; ?>">
                        <div class="food-menu-desc">

                            <h4><?php echo $title; ?></h4>
                            <p style="color: grey;"><?php echo $description; ?></p>
                            <h4>Price: <?php echo $price; ?></h4>
                            Quantity: <input type="text" name="quantity" value="1" />
                            <input type="hidden" name="hidden_name" value="<?php echo $title; ?>" />
                            <input type="hidden" name="hidden_img" value="<?php echo $image_name; ?>" />
                            <input type="hidden" name="hidden_price" value="<?php echo $price; ?>" /> <br>
                            <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-primary" value="Add to Cart" />
                        </div>
                    </form>
                </div>
        <?php
            }
        } else {
            // not avail
            echo "<div class='error'>Food not Available</div>";
        }
        ?>
        <div class="clearfix"></div>
    </div>

</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>