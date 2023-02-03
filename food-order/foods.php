<?php include('partials-front/menu.php'); ?>



<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <form action="<?php echo SITEURL ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php

        // Food from db that are active and featured
        $sql2 = "SELECT * FROM tbl_food WHERE active='Yes'";
        $res2 = mysqli_query($conn, $sql2);

        $count2 = mysqli_num_rows($res2);

        // check food available or not
        if ($count2 > 0) {
            //food available
            while ($row = mysqli_fetch_assoc($res2)) {
                // Get val
                $id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $description = $row['description'];
                $image_name = $row['image_name'];

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

                    <form method="post" action="<?php echo SITEURL ?>cart.php?action=add&id=<?php echo $row["id"]; ?>">
                        <div class="food-menu-desc">

                            <h4><?php echo $row["title"]; ?></h4>
                            <p style="color: grey;"><?php echo $row["description"]; ?></p>
                            <h4>Price: <?php echo $price; ?></h4>
                            Quantity: <input type="text" name="quantity" value="1" />
                            <input type="hidden" name="hidden_name" value="<?php echo $row["title"]; ?>" />
                            <input type="hidden" name="hidden_img" value="<?php echo $row["image_name"]; ?>" />
                            <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" /> <br>
                            <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-primary" value="Add to Cart" />
                        </div>
                    </form>
                </div>
        <?php
            }
        } else {
            //food not available
            echo "<div class='error'>Food Not available</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>