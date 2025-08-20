<?php
if(isset($_GET['edit_account'])){
    $user_session_name = $_SESSION['username'];
    $select_query = "SELECT * FROM `user_table` WHERE username='$user_session_name'";
    $result_query = mysqli_query($con, $select_query);
    $row_fetch = mysqli_fetch_assoc($result_query);
    $user_id = $row_fetch['user_id'];
    $username = $row_fetch['username'];
    $user_email = $row_fetch['user_email'];
    $user_address = $row_fetch['user_address'];
    $user_mobile = $row_fetch['user_mobile'];
    $user_image = $row_fetch['user_image']; // Fetch the current user image
}

if(isset($_POST['user_update'])){
    $update_id = $user_id;
    $username = $_POST['user_username'];
    $user_email = $_POST['user_email'];
    $user_address = $_POST['user_address'];
    $user_mobile = $_POST['user_mobile'];
    $user_image = $_FILES['user_image']['name'];
    $user_image_tmp = $_FILES['user_image']['tmp_name'];
    
    if(!empty($user_image_tmp)) {
        move_uploaded_file($user_image_tmp, "./user_images/$user_image");
    } else {
        // If no new image is uploaded, keep the current image
        $user_image = $row_fetch['user_image'];
    }
    
    // Update query
    $update_data = "UPDATE `user_table` SET username='$username', user_email='$user_email', user_image='$user_image', user_address='$user_address', user_mobile='$user_mobile' WHERE user_id=$update_id";
    $result_query_update = mysqli_query($con, $update_data);
    
    if($result_query_update){
        echo "<script>alert('Update made successfully');</script>";
        echo "<script>window.open('logout.php', '_self');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .edit_img {
            width: 200px; /* Adjust the width as needed */
            height: 200px; /* Adjust the height as needed */
            object-fit: cover; /* Maintain aspect ratio */
            border-radius: 20%; /* Make it circular */
            display: block;
            margin: 0 auto; /* Center horizontally */
            margin-bottom: 20px; /* Add some space below */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <img src="./user_images/<?php echo htmlspecialchars($user_image); ?>" alt="" class="edit_img mx-auto d-block">
        <h3 class="text-center text-success mb-4">Edit Account</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($username); ?>" name="user_username">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($user_email); ?>" name="user_email">
            </div>
            <div class="form-group">
                <label for="user_image">Profile Image</label>
                <input type="file" class="form-control" id="user_image" name="user_image">
            </div>
            <div class="form-group">
                <label for="address">Delivery Address</label>
                <input type="text" class="form-control" id="address" value="<?php echo htmlspecialchars($user_address); ?>" name="user_address">
            </div>
            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control" id="mobile" value="<?php echo htmlspecialchars($user_mobile); ?>" name="user_mobile">
            </div>
            <input type="submit" value="Update" class="btn btn-info py-2 px-3 border-0" name="user_update">
        </form>
    </div>
</body>
</html>
