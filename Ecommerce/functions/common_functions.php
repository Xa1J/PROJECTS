<style>
.card-img-top {
    width: 100%;
    height: 500px; /* Set the desired height */
    object-fit: cover; /* This property maintains the aspect ratio and covers the area */
}

</style>

<?php
// Define root directory
define('ROOT_PATH', dirname(__DIR__));

// Include the connection file
include_once(ROOT_PATH . '../includes/connect.php');
// Function to get products

function getproducts(){
    global $con;
    if(!isset($_GET['category']) && !isset($_GET['brand'])){
        $select_query = "SELECT * FROM `products`";
        $result_query = mysqli_query($con, $select_query);
        while($row = mysqli_fetch_assoc($result_query)){
            $product_id = $row['product_id'];
            $product_title = $row['product_title'];
            $product_description = $row['product_description'];
            $product_image1 = $row['product_image1'];
            $product_price = $row['product_price'];

            // Card layout with Bootstrap classes
            echo "
            <div class='col-md-4 mb-4'>
                <div class='card'>
                    <img src='../admin/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                    <div class='card-body'>
                        <h5 class='card-title'>$product_title</h5>
                        <p class='card-text card-description'>$product_description</p>
                        <h6 class='card-text card-price'>Price: $$product_price</h6>
                        <div class='d-grid gap-2'>
                            <a href='../shop/index.php?add_to_cart=$product_id' class='btn btn-primary btn-sm'>Add to Cart</a>
                            <a href='../product_details.php?product_id=$product_id' class='btn btn-secondary btn-sm'>Details</a>
                        </div>
                    </div>
                </div>
            </div>
            ";
        }
    }
}




// Function to get unique categories
function get_unique_categories(){
    global $con;
    if(isset($_GET['category'])){
        $category_id = $_GET['category'];
        $select_query = "SELECT * FROM `products` WHERE category_id=$category_id";
        $result_query = mysqli_query($con, $select_query);
        $num_of_rows = mysqli_num_rows($result_query);
        if($num_of_rows == 0){
            echo "<h2 class='text-center text-danger'>No stock for this category</h2>";
        } else {
            while($row = mysqli_fetch_assoc($result_query)){
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_image1 = $row['product_image1'];
                $product_price = $row['product_price'];
                echo "
                <div class='col-md-4 mb-4'>
                    <div class='card'>
                        <img src='../admin/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_description</p>
                            <p class='card-text'>Price: $product_price/-</p>
                            <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add to cart</a>
                            <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View more</a>
                        </div>
                    </div>
                </div>";
            }
        }
    }
}

// Function to get unique brands
function get_unique_brands(){
    global $con;
    if(isset($_GET['brand'])){
        $brand_id = $_GET['brand'];
        
        
        $select_query = "SELECT * FROM `products` WHERE brand_id=$brand_id";
        $result_query = mysqli_query($con, $select_query);
        
     
        
        $num_of_rows = mysqli_num_rows($result_query);

    
        
        if($num_of_rows == 0){
            echo "<h2 class='text-center text-danger'>This brand is not available right now. Subscribe to our email for latest updates on this</h2>";
        } else {
            while($row = mysqli_fetch_assoc($result_query)){
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_image1 = $row['product_image1'];
                $product_price = $row['product_price'];
                echo "
                <div class='col-md-4 mb-4'>
                    <div class='card'>
                        <img src='../admin/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_description</p>
                            <p class='card-text'>Price: $product_price/-</p>
                            <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add to cart</a>
                            <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View more</a>
                        </div>
                    </div>
                </div>";
            }
        }
    }
}


// Function to display brands in sidenav
function getbrands(){
    global $con;
    $select_brands = "SELECT * FROM `brands`";
    $result_brands = mysqli_query($con, $select_brands);
    while($row_data = mysqli_fetch_assoc($result_brands)){
        $brand_title = $row_data['brand_title'];
        $brand_id = $row_data['brand_id'];
        echo "<li class='nav-item bg-info'><a href='../shop/index.php?brand=$brand_id' class='nav-link text-dark'>$brand_title</a></li>";
    }
}


// Function to display categories in sidenav
function getcategories(){
    global $con;
    $select_categories = "SELECT * FROM `categories`";
    $result_categories = mysqli_query($con, $select_categories);
    while($row_data = mysqli_fetch_assoc($result_categories)){
        $category_title = $row_data['category_title'];
        $category_id = $row_data['category_id'];
        echo "<li class='nav-item bg-info'><a href='../shop/index.php?category=$category_id' class='nav-link text-dark' >$category_title</a></li>";
    }
}

// Function to search products
function search_product(){
    global $con;
    if(isset($_GET['search_data_product'])){
        $search_data_value = $_GET['search_data'];
        $search_query = "SELECT * FROM `products` WHERE product_keywords LIKE '%$search_data_value%'";
        $result_query = mysqli_query($con, $search_query);
        $num_of_rows = mysqli_num_rows($result_query);
        if($num_of_rows == 0){
            echo "<h2 class='text-center text-danger'>Your Search didn't match any of our current stock!</h2>";
        } else {
            while($row = mysqli_fetch_assoc($result_query)){
                $product_id = $row['product_id'];
                $product_title = $row['product_title'];
                $product_description = $row['product_description'];
                $product_image1 = $row['product_image1'];
                $product_price = $row['product_price'];
                echo "
                <div class='col-md-4 mb-4'>
                    <div class='card'>
                        <img src='./admin/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                        <div class='card-body'>
                            <h5 class='card-title'>$product_title</h5>
                            <p class='card-text'>$product_description</p>
                            <p class='card-text'>Price: $product_price/-</p>
                            <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add to cart</a>
                            <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View more</a>
                        </div>
                    </div>
                </div>";
            }
        }
    }
}

// Function to view product details
function view_details(){
    global $con;
    if(isset($_GET['product_id'])){
        $product_id = $_GET['product_id'];
        $select_query = "SELECT * FROM `products` WHERE product_id=$product_id";
        $result_query = mysqli_query($con, $select_query);
        if($row = mysqli_fetch_assoc($result_query)){
            $product_title = $row['product_title'];
            $product_description = $row['product_description'];
            $product_image1 = $row['product_image1'];
            $product_image2 = $row['product_image2'];
            $product_image3 = $row['product_image3'];
            $product_image4 = $row['product_image4'];
            $product_price = $row['product_price'];
            echo "
            <div class='container'>
                <div class='row'>
                    <!-- Images Section -->
                    <div class='col-md-6'>
                        <div class='row'>
                            <div class='col-md-6 mb-3'>
                                <img src='./admin/product_images/$product_image1' class='img-fluid' alt='$product_title'>
                            </div>
                            <div class='col-md-6 mb-3'>
                                <img src='./admin/product_images/$product_image2' class='img-fluid' alt='$product_title'>
                            </div>
                            <div class='col-md-6 mb-3'>
                                <img src='./admin/product_images/$product_image3' class='img-fluid' alt='$product_title'>
                            </div>
                            <div class='col-md-6 mb-3'>
                                <img src='./admin/product_images/$product_image4' class='img-fluid' alt='$product_title'>
                            </div>
                        </div>
                    </div>
                    <!-- Details Section -->
                    <div class='col-md-6'>
                        <div class='product-details'>
                            <h5 class='card-title mb-4'>$product_title</h5>
                            <p class='card-text mb-4'>$product_description</p>
                            <p class='card-text mb-4'>Price: $product_price/-</p>
                            <a href='./shop/index.php?add_to_cart=$product_id' class='btn btn-primary btn-lg'>Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>";
        }
    }
}



// Function to get IP address
function getIPAddress() {  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    } else {  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}

// Cart function
function cart(){
    if (isset($_GET['add_to_cart'])) {
        global $con;
        // Use session ID instead of IP address
        $session_id = session_id();
        $get_product_id = $_GET['add_to_cart'];
        $select_query = "SELECT * FROM `cart_details` WHERE session_id='$session_id' AND product_id=$get_product_id";
        $result_query = mysqli_query($con, $select_query);
        $num_of_rows = mysqli_num_rows($result_query);
        if ($num_of_rows > 0) {
            echo "<script>alert('This item is already present inside cart')</script>";
            echo "<script>window.open('../shop/index.php', '_self')</script>";
        } else {
            $insert_query = "INSERT INTO `cart_details` (product_id, session_id, quantity) VALUES ($get_product_id, '$session_id', 1)";
            $result_query = mysqli_query($con, $insert_query);
            echo "<script>alert('Item is added to cart')</script>";
            echo "<script>window.open('../shop/index.php', '_self')</script>";
        }
    }
}

// Function to get cart item number
function cart_item(){
    global $con;
    // Use session ID instead of IP address
    $session_id = session_id();
    $select_query = "SELECT * FROM `cart_details` WHERE session_id='$session_id'";
    $result_query = mysqli_query($con, $select_query);
    $count_cart_items = mysqli_num_rows($result_query);
    echo $count_cart_items;
}

// Total price function
function total_cart_price(){
    global $con;
    // Use session ID instead of IP address
    $session_id = session_id();
    $total_price = 0;
    $cart_query = "SELECT * FROM `cart_details` WHERE session_id='$session_id'";
    $result = mysqli_query($con, $cart_query);
    while ($row = mysqli_fetch_array($result)) {
        $product_id = $row['product_id'];
        $quantity = $row['quantity']; // Get the quantity of each product
        $select_products = "SELECT * FROM `products` WHERE product_id='$product_id'";
        $result_products = mysqli_query($con, $select_products);
        while ($row_product_price = mysqli_fetch_array($result_products)) {
            $product_price = $row_product_price['product_price'];
            $total_price += $product_price * $quantity; // Multiply price by quantity
        }
    }
    echo $total_price;
}


// get user order details
function get_user_order_details(){
    global $con;

    // Check if the session variable 'username' is set
    if (!isset($_SESSION['username'])) {
        echo "<h3 class='text-center text-danger mt-5 mb-2'>Please log in to view your orders.</h3>";
        return;
    }

    $username = $_SESSION['username'];
    $get_details = "SELECT * FROM `user_table` WHERE username='$username'";
    $result_query = mysqli_query($con, $get_details);

    if ($result_query) {
        while ($row_query = mysqli_fetch_array($result_query)) {
            $user_id = $row_query['user_id'];
            if (!isset($_GET['edit_account']) && !isset($_GET['my_orders']) && !isset($_GET['delete_account'])) {
                $get_orders = "SELECT * FROM `user_orders` WHERE user_id=$user_id AND order_status='pending'";
                $result_orders_query = mysqli_query($con, $get_orders);
                $row_count = mysqli_num_rows($result_orders_query);
                if ($row_count > 0) {
                    echo "<h3 class='text-center text-success mt-5 mb-2'>You have <span class='text-danger'>$row_count</span> pending orders</h3>
                    <p class='text-center'><a href='profile.php?my_orders' class='text-dark'>Order Details</a></p>";
                } else {
                    echo "<h3 class='text-center text-success mt-5 mb-2'>You have zero pending orders</h3>
                    <p class='text-center'><a href='../index.php' class='text-dark'>Explore Haven</a></p>";
                }
            }
        }
    } else {
        echo "<h3 class='text-center text-danger mt-5 mb-2'>Error fetching user details.</h3>";
    }
}
function get_category_products($category) {
    global $con;
    $select_query = "SELECT * FROM `products` WHERE category_name='$category'";
    $result_query = mysqli_query($con, $select_query);
    $num_of_rows = mysqli_num_rows($result_query);
    if ($num_of_rows == 0) {
        echo "<h2 class='text-center text-danger'>No products available in this category</h2>";
    } else {
        while ($row = mysqli_fetch_assoc($result_query)) {
            $product_id = $row['product_id'];
            $product_title = $row['product_title'];
            $product_description = $row['product_description'];
            $product_image1 = $row['product_image1'];
            $product_price = $row['product_price'];
            echo "
            <div class='col-md-4 mb-4'>
                <div class='card'>
                    <img src='./admin/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                    <div class='card-body'>
                        <h5 class='card-title'>$product_title</h5>
                        <p class='card-text'>$product_description</p>
                        <p class='card-text'>Price: $product_price/-</p>
                        <a href='index.php?add_to_cart=$product_id' class='btn btn-primary'>Add to cart</a>
                        <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View more</a>
                    </div>
                </div>
            </div>";
        }
    }
}
// Function to get only shoe products
function get_shoe_products($brand_id = null) {
    global $con;
    $query = "SELECT * FROM products WHERE category_id = (SELECT category_id FROM categories WHERE category_title = 'Shoes')";
    if ($brand_id) {
        $query .= " AND brand_id = $brand_id";
    }
    $result = mysqli_query($con, $query);
    
    while ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['product_id'];
        $product_title = $row['product_title'];
        $product_description = $row['product_description'];
        $product_image1 = $row['product_image1'];
        $product_price = $row['product_price'];

        echo "
        <div class='col-md-4 mb-2'>
            <div class='card'>
                <img src='../admin/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                <div class='card-body'>
                    <h5 class='card-title'>$product_title</h5>
                    <p class='card-text'>$product_description</p>
                    <p class='card-text'>Price: $$product_price</p>
                    <div class='d-grid gap-2'>
                        <a href='../product_details.php?add_to_cart=$product_id' class='btn btn-primary btn-sm'>Add to Cart</a>
                        <a href='../product_details.php?product_id=$product_id' class='btn btn-secondary btn-sm'>View Details</a>
                    </div>
                </div>
            </div>
        </div>
        ";
    }
}

function get_shoe_brands() {
    global $con;
    $query = "SELECT * FROM brands";
    $result = mysqli_query($con, $query);
    
    while ($row = mysqli_fetch_assoc($result)) {
        $brand_title = $row['brand_title'];
        $brand_id = $row['brand_id'];
        echo "<li class='nav-item'><a href='shopshoes.php?brand=$brand_id' class='nav-link text-light'><h4>$brand_title</h4></a></li>";
    }
}

// Function to get only jersey products
function get_jersey_products($brand_id = null) {
    global $con;
    $query = "SELECT * FROM products WHERE category_id = (SELECT category_id FROM categories WHERE category_title = 'Jerseys')";
    if ($brand_id) {
        $query .= " AND brand_id = $brand_id";
    }
    $result = mysqli_query($con, $query);
    
    while ($row = mysqli_fetch_assoc($result)) {
        $product_id = $row['product_id'];
        $product_title = $row['product_title'];
        $product_description = $row['product_description'];
        $product_image1 = $row['product_image1'];
        $product_price = $row['product_price'];

        echo "
        <div class='col-md-4 mb-2'>
            <div class='card'>
                <img src='../admin/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                <div class='card-body'>
                    <h5 class='card-title'>$product_title</h5>
                    <p class='card-text'>$product_description</p>
                    <p class='card-text'>Price: $$product_price</p>
                    <div class='d-grid gap-2'>
                        <a href='../product_details.php?add_to_cart=$product_id' class='btn btn-primary btn-sm'>Add to Cart</a>
                        <a href='../product_details.php?product_id=$product_id' class='btn btn-secondary btn-sm'>View Details</a>
                    </div>
                </div>
            </div>
        </div>
        ";
    }
}

function get_jersey_brands() {
    global $con;
    $query = "SELECT * FROM brands";
    $result = mysqli_query($con, $query);
    
    while ($row = mysqli_fetch_assoc($result)) {
        $brand_title = $row['brand_title'];
        $brand_id = $row['brand_id'];
        echo "<li class='nav-item'><a href='shopjerseys.php?brand=$brand_id' class='nav-link text-light'><h4>$brand_title</h4></a></li>";
    }
}

// Telegram pay chat bot functions
function sendMessageToTelegram($cartDetails, $customerTelegram) {
    $botToken = "7187434159:AAHwpRaBoHMl8SFtKWda6gk0ryZXx6S43gE"; // Replace with your actual bot token
    $chatId = "1368102817"; // Replace with your actual chat ID
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    
    // Send order details message
    $orderFormattedMessage = "Customer Telegram Contact: " . $customerTelegram . "\n\n" .
                              "Order Details:\n" . $cartDetails;

    $orderPostFields = [
        'chat_id' => $chatId,
        'text' => $orderFormattedMessage
    ];

    // Send message to Telegram
    $orderCh = curl_init(); 
    curl_setopt($orderCh, CURLOPT_URL, $url); 
    curl_setopt($orderCh, CURLOPT_POST, 1); 
    curl_setopt($orderCh, CURLOPT_POSTFIELDS, $orderPostFields); 
    curl_setopt($orderCh, CURLOPT_RETURNTRANSFER, true);
    curl_exec($orderCh);
    curl_close($orderCh);
}





function getCartDetails() {
    global $con;
    $session_id = session_id();
    $query = "SELECT p.product_title, c.quantity, p.product_price 
              FROM cart_details c 
              JOIN products p ON c.product_id = p.product_id 
              WHERE c.session_id = '$session_id'";
    $result = mysqli_query($con, $query);
    
    $message = "Order Details:\n\n";
    $totalPrice = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $productTitle = $row['product_title'];
        $quantity = $row['quantity'];
        $price = $row['product_price'] * $quantity;
        $totalPrice += $price;
        
        $message .= "Product: $productTitle\nQuantity: $quantity\nPrice: $price\n\n";
    }

    $message .= "Total Price: $totalPrice";
    return $message;
}

?>
