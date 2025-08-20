<?php
include('../includes/connect.php');
include('../functions/common_functions.php'); // Adjusted path
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
    <title>Hidden Store</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Jersey+10&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../font.css">
<style>
        .logo{
            width: 7%;
            height: 7%;
        }
        .user-image {
            width: 100px; /* Adjust the width as needed */
            height: 100px; /* Adjust the height as needed */
            object-fit: cover; /* Maintain aspect ratio */
            border-radius: 20%; /* Make it circular */
            display: block;
            margin: 0 auto; /* Center horizontally */
            margin-bottom: 20px; /* Add some space below */
        }
    </style>
</head>

<body>
<div class="container-fluid p-0">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-info">
        <div class="container-fluid">
            <img src="../front-page1/FIRSTLOGOB2.png" alt="logo" class="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="../index.php"><span class="nav-text"><h1>Home</h1></span></a></li>
                    <li class="nav-item"><a class="nav-link" href="../shop/index.php"><span class="nav-text"><h1>Products</h1></span></a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><span class="nav-text"><h1>About Us</h1></span></a></li>
                    
                    
                    <li class="nav-item">
                        <a class="nav-link" href="../cart.php">
                            <span class="material-symbols-outlined"><span class="nav-text"><h1>shopping_cart</h1></span></span>
                            <sup class="cart-item-count"><?php cart_item(); ?></sup>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#"><span class="nav-text"><h1>Total Price: <?php total_cart_price(); ?>/-</h1></span></a></li>
                </ul>
                <form class="d-flex" action="../search_product.php" method="get">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
                    <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
                </form>
            </div>
        </div>
    </nav>

        <!-- Calling cart function -->
        <?php cart(); ?>

        <!-- Welcome Message -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <ul class="navbar-nav me-auto">
                <?php
                if (!isset($_SESSION['username'])) {
                    echo "<li class='nav-item'><a class='nav-link' href='#'>Welcome Guest</a></li>";
                } else {
                    echo "<li class='nav-item'><a class='nav-link' href='#'>Welcome " . $_SESSION['username'] . "</a></li>";
                }
                if (!isset($_SESSION['username'])) {
                    echo "<li class='nav-item'><a class='nav-link' href='user_login.php'>Login</a></li>";
                } else {
                    echo "<li class='nav-item'><a class='nav-link' href='logout.php'>Logout</a></li>";
                }
                ?>
            </ul>
        </nav>

        <!-- Sidebar and Content -->
        <div class="row">
            <div class="col-md-2">
                <ul class="navbar-nav bg-secondary text-center" style="height:100vh">
                    <li class="nav-item bg-info"><a class="nav-link text-light" aria-current="page" href="#">
                        <h4>Your Profile</h4></a>
                    </li>
                    <?php
                    if (isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                        $user_query = "SELECT * FROM `user_table` WHERE username='$username'";
                        $user_result = mysqli_query($con, $user_query);
                        if ($user_result) {
                            $user_row = mysqli_fetch_assoc($user_result);
                            $user_image = $user_row['user_image'];
                            echo "<li class='nav-item'><img src='./user_images/$user_image' class='user-image' alt='Profile Image'></li>";
                        }
                    }
                    ?>
                    <li class="nav-item"><a class="nav-link text-light" href="profile.php">Pending Orders</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="profile.php?edit_account">Edit Account</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="profile.php?my_orders">My Orders</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="profile.php?delete_account">Delete Account</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="./users_area/logout.php">Logout</a></li>
                </ul>
            </div>
            <div class="col-md-10 text-center">
    <?php get_user_order_details(); 
    if(isset($_GET['edit_account'])){
        include('edit_account.php');
    }
    if(isset($_GET['my_orders'])){
        include('user_orders.php');
    }
    if(isset($_GET['delete'])){
        include('delete_account.php');
    }
    ?>
</div>

        </div>

        <!-- Footer -->
        <?php include("../includes/footer.php"); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/heic2any/dist/heic2any.js"></script>

    <script>
    // Function to convert HEIF images to JPEG or PNG
    function convertHEIFToJPEGOrPNG(imgElement) {
        if (imgElement.src.toLowerCase().endsWith('.heic')) {
            const imageBlob = fetch(imgElement.src)
                .then(response => response.blob())
                .then(blob => {
                    return blob;
                });
            const imageURL = URL.createObjectURL(imageBlob);
            const heic2any = new Heic2any();
            heic2any.convert({
                blob: imageBlob,
                toType: Heic2any.IMAGE_TYPE.JPEG // Change to PNG if needed
            }).then((convertedBlob) => {
                imgElement.src = URL.createObjectURL(convertedBlob);
            }).catch((error) => {
                console.error('Error converting HEIF to JPEG/PNG:', error);
            });
        }
    }

    // Convert HEIF images when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        const profileImage = document.querySelector('.profile_img');
        if (profileImage) {
            convertHEIFToJPEGOrPNG(profileImage);
        }
    });
</script>


</body>
</html>
