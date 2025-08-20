<?php
include('./includes/connect.php');
include('./functions/common_functions.php'); // Adjusted path
session_start();
if (!$con) {
    die("Database connection failed");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>xaijhavencart</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Jersey+10&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="font.css">
    <style>
        body{
            font-size:25px;
        }
        .logo {
            width: 7%;
            height: 7%;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-info">
            <div class="container-fluid">
                <img src="main-page-pictures/FIRSTLOGOB2.png" alt="logo" class="logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="./shop/index.php">Products</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="./users_area/user_registration.php">Register</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">
                                <span class="material-symbols-outlined">shopping_cart</span>
                                <sup><?php cart_item(); ?></sup>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Calling cart function -->
        <?php cart(); ?>

        <!-- Welcome Message -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                <?php
                    if(!isset($_SESSION['username'])){
                        echo "<li class='nav-item'><a class='nav-link' href='#'>Welcome Guest</a></li>";
                    }else{
                        echo "<li class='nav-item'><a class='nav-link' href='#'>Welcome ".$_SESSION['username']."</a></li>";
                    }
                    if(!isset($_SESSION['username'])){
                        echo "<li class='nav-item'><a class='nav-link' href='../users_area/user_login.php'>Login</a></li>";
                    }else{
                        echo "<li class='nav-item'><a class='nav-link' href='../users_area/logout.php'>Logout</a></li>";
                    }
                ?>
            </ul>
        </nav>

        <!-- Cart Details -->
        <div class="container">
            <div class="row">
                <form action="" method="post">
                    <table class="table table-bordered text-center">
                        <?php
                        $session_id = session_id();
                        $total_price = 0;
                        $cart_query = "SELECT * FROM `cart_details` WHERE session_id='$session_id'";
                        $result = mysqli_query($con, $cart_query);
                        $result_count = mysqli_num_rows($result);
                        if ($result_count > 0) {
                            echo "
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Image</th>
                                    <th>Quantity</th>
                                    <th>Total price</th>
                                    <th>Remove</th>
                                    <th colspan='2'>Operations</th>
                                </tr>
                            </thead>
                            <tbody>";
                            while ($row = mysqli_fetch_array($result)) {
                                $product_id = $row['product_id'];
                                $quantity = $row['quantity'];
                                $select_products = "SELECT * FROM `products` WHERE product_id='$product_id'";
                                $result_products = mysqli_query($con, $select_products);
                                while ($row_product = mysqli_fetch_array($result_products)) {
                                    $product_price = $row_product['product_price'];
                                    $product_title = $row_product['product_title'];
                                    $product_image1 = $row_product['product_image1'];
                                    $total_price += $product_price * $quantity;
                                    ?>
                                    <tr>
                                        <td class="card-title"><?php echo $product_title; ?></td>
                                        <td><img src="./admin/product_images/<?php echo $product_image1; ?>" class="img-fluid" width="100"></td>
                                        <td class="card-title"><input type="number" name="qty[<?php echo $product_id; ?>]" class="form-input w-50" value="<?php echo $quantity; ?>"></td>
                                        <td><?php echo $product_price; ?>/-</td>
                                        <td><input type="checkbox" name="removeitem[]" value="<?php echo $product_id; ?>"></td>
                                        <td>
                                            <input type="submit" value="Update Cart" class="bg-info px-3 py-2 border-0 mx-3" name="update_cart">
                                            <input type="submit" value="Remove Cart" class="bg-info px-3 py-2 border-0 mx-3" name="remove_cart">
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            echo "</tbody>";
                        } else {
                            echo "<h2 class='text-center text-danger'>Cart is empty</h2>";
                        }
                        ?>
                    </table>
                    <!-- Subtotal -->
                    <div class="d-flex mb-3">
                        <?php
                        if ($result_count > 0) {
                            echo "
                            <h4 class='px-3'>Subtotal: <strong class='text-info'> $total_price/-</strong></h4>
                            <input type='submit' value='Continue Shopping' class='bg-info px-3 py-2 border-0 mx-3' name='continue_shopping'>
                            <button class='bg-info px-3 py-2 border-0'><a href='./users_area/checkout.php' class='text-light text-decoration-none'>Checkout</a></button>
                            ";
                        } else {
                            echo "<input type='submit' value='Continue Shopping' class='bg-info px-3 py-2 border-0 mx-3' name='continue_shopping'>";
                        }
                        if (isset($_POST['continue_shopping'])) {
                            echo "<script>window.open('index.php','_self')</script>";
                        }
                        ?>
                    </div>

                    <!-- Delivery Information -->
                    <div class="alert alert-info mt-4 card-text">
                        <strong>Delivery Information:</strong>
                        <p>We offer free deliveries to a nearest pickup area like a post office for Russia and Zambia. Package arrives in 2 to 3 weeks from the moment of order.</p>
                    </div>
                </form>

                <!-- Function to update and remove cart items -->
                <?php
                function update_cart() {
                    global $con;
                    $session_id = session_id();
                    if (isset($_POST['update_cart'])) {
                        foreach ($_POST['qty'] as $product_id => $quantity) {
                            $update_cart = "UPDATE `cart_details` SET quantity='$quantity' WHERE session_id='$session_id' AND product_id='$product_id'";
                            mysqli_query($con, $update_cart);
                        }
                    }
                }

                function remove_cart_item() {
                    global $con;
                    $session_id = session_id();
                    if (isset($_POST['remove_cart'])) {
                        foreach ($_POST['removeitem'] as $remove_id) {
                            $delete_query = "DELETE FROM `cart_details` WHERE session_id='$session_id' AND product_id='$remove_id'";
                            mysqli_query($con, $delete_query);
                        }
                        echo "<script>window.open('cart.php','_self')</script>";
                    }
                }

                update_cart();
                remove_cart_item();
                ?>
            </div>
        </div>

        <!-- Footer -->
        <h11><?php include("includes/footer.php"); ?></h11>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
