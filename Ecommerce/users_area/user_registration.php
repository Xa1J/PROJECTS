<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
if (!$con) {
    die("Database connection failed");
}
@session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid my-3">
        <h2 class="text-center">New User Registration</h2>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-12 col-xl-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-outline mb-4">
                        <!-- Username field -->
                        <label for="user_username" class="form-label">Username</label>
                        <input type="text" id="user_username" autocomplete="off" class="form-control" placeholder="Enter your username" required="required" name="user_username"/>
                    </div>
                    <div class="form-outline mb-4">
                        <!-- Email field -->
                        <label for="user_email" class="form-label">Email</label>
                        <input type="email" id="user_email" autocomplete="off" class="form-control" placeholder="Enter your email" required="required" name="user_email"/>
                    </div>
                    <div class="form-outline mb-4">
                        <!-- Image field -->
                        <label for="user_image" class="form-label">User Image</label>
                        <input type="file" id="user_image" required="required" name="user_image"/>
                    </div>
                    <div class="form-outline mb-4">
                        <!-- Password field -->
                        <label for="user_password" class="form-label">Password</label>
                        <input type="password" id="user_password" autocomplete="off" class="form-control" placeholder="Enter your password" required="required" name="user_password"/>
                    </div>
                    <div class="form-outline mb-4">
                        <!-- Confirm Password field -->
                        <label for="conf_user_password" class="form-label">Confirm Password</label>
                        <input type="password" id="conf_user_password" class="form-control" placeholder="Confirm password" autocomplete="off" required="required" name="conf_user_password"/>
                    </div>
                    <div class="form-outline mb-4">
                        <!-- Address field -->
                        <label for="user_address" class="form-label">Delivery Address</label>
                        <input type="text" id="user_address" autocomplete="off" class="form-control" placeholder="Enter your address" required="required" name="user_address"/>
                    </div>
                    <div class="form-outline mb-4">
                        <!-- Contact field -->
                        <label for="user_contact" class="form-label">Mobile Number</label>
                        <input type="text" id="user_contact" autocomplete="off" class="form-control" placeholder="Enter your mobile number" required="required" name="user_contact"/>
                    </div>
                    <div class="mt-4 pt-2">
                        <input type="submit" value="Register" class="bg-info py-2 px-3 border-0" name="user_register">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="user_login.php" class="text-danger">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
if (isset($_POST['user_register'])) {
    $user_username = $_POST['user_username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $user_conf_user_password = $_POST['conf_user_password'];
    $user_address = $_POST['user_address'];
    $user_contact = $_POST['user_contact'];
    $user_image = $_FILES['user_image']['name'];
    $user_image_tmp = $_FILES['user_image']['tmp_name'];
    $user_ip = getIPAddress();

    // Check if username or email already exists
    $select_query = "SELECT * FROM `user_table` WHERE username='$user_username' OR user_email='$user_email'";
    $result = mysqli_query($con, $select_query);
    $rows_count = mysqli_num_rows($result);

    if ($rows_count > 0) {
        echo "<script>alert('Username or email already exists')</script>";
    } elseif ($user_password != $user_conf_user_password) {
        echo "<script>alert('Passwords do not match!')</script>";
    } else {
        // Move uploaded file to the correct directory
        move_uploaded_file($user_image_tmp, "user_images/$user_image");

        // Hash the password before storing it
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

      // Insert new user into the database
$insert_query = "INSERT INTO `user_table` (username, user_email, user_password, user_image, user_ip, user_address, user_mobile) 
VALUES ('$user_username', '$user_email', '$hashed_password', '$user_image', '$user_ip', '$user_address', '$user_contact')";
$sql_execute = mysqli_query($con, $insert_query);

if ($sql_execute) {
// Get the inserted user ID
$user_id = mysqli_insert_id($con);

// Set session variables
$_SESSION['username'] = $user_username;
$_SESSION['user_id'] = $user_id;

// Transfer session cart to user cart
$session_id = session_id();
$update_cart_query = "UPDATE `cart_details` SET user_id='$user_id' WHERE session_id='$session_id'";
mysqli_query($con, $update_cart_query);

            echo "<script>alert('Registration successful')</script>";

            // Check if the cart has items
            $select_cart_items = "SELECT * FROM `cart_details` WHERE session_id='$session_id'";
            $result_cart = mysqli_query($con, $select_cart_items);
            $rows_count_cart = mysqli_num_rows($result_cart);

            if ($rows_count_cart > 0) {
                echo "<script>alert('You have items in your cart');</script>";
                echo "<script>window.open('checkout.php','_self')</script>";
            } else {
                echo "<script>window.open('../index.php','_self')</script>";
            }
        } else {
            echo "<script>alert('Registration failed')</script>";
        }
    }
}
?>
