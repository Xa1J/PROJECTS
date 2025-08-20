<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
@session_start();
if (!$con) {
    die("Database connection failed");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
        overflow-x: hidden;
    }
</style>
<body>

<div class="container-fluid my-3">
    <h2 class="text-center">User Login</h2>
    <div class="row d-flex align-items-center justify-content-center">
        <div class="col-lg-12 col-xl-6">
            <form action="" method="post">
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
                    <!-- Password field -->
                    <label for="user_password" class="form-label">Password</label>
                    <input type="password" id="user_password" autocomplete="off" class="form-control" placeholder="Enter your password" required="required" name="user_password"/>
                </div>
                <div class="mt-4 pt-2">
                    <input type="submit" value="Login" class="bg-info py-2 px-3 border-0" name="user_login">
                    <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="user_registration.php" class="text-danger">Register</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>

<?php
if (isset($_POST['user_login'])) {
    $user_username = $_POST['user_username'];
    $user_password = $_POST['user_password'];

    $select_query = "SELECT * FROM `user_table` WHERE username='$user_username'";
    $result = mysqli_query($con, $select_query);
    $row_count = mysqli_num_rows($result);

    if ($row_count > 0) {
        $row_data = mysqli_fetch_assoc($result);

        // Check for cart items using session ID
        $session_id = session_id();
        $select_cart_query = "SELECT * FROM `cart_details` WHERE session_id='$session_id'";
        $select_cart = mysqli_query($con, $select_cart_query);
        $row_count_cart = mysqli_num_rows($select_cart);

        if (password_verify($user_password, $row_data['user_password'])) {
            $_SESSION['username'] = $user_username;
            $_SESSION['user_id'] = $row_data['user_id'];

            // Transfer session cart to user cart
$update_cart_query = "UPDATE `cart_details` SET user_id='{$row_data['user_id']}' WHERE session_id='$session_id'";
mysqli_query($con, $update_cart_query);


            if ($row_count_cart == 0) {
                echo "<script>alert('Login successful');</script>";
                echo "<script>window.open('profile.php', '_self');</script>";
            } else {
                echo "<script>alert('Login successful');</script>";
                echo "<script>window.open('../index.php', '_self');</script>";
            }
        } else {
            echo "<script>alert('Invalid Credentials');</script>";
        }
    } else {
        echo "<script>alert('Invalid Credentials');</script>";
    }
}
?>
