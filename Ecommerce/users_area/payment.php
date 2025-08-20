<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
@session_start();

if (!$con) {
    die("Database connection failed");
}

// Handle form submission for completing the order
if (isset($_POST['complete_order'])) {
    // Example variables
    $cartDetails = getCartDetails();
    $customerTelegram = $_POST['customer_telegram']; // Assuming you get the customer's Telegram contact from the form

    // Call the function with the required arguments
    sendMessageToTelegram($cartDetails, $customerTelegram);

    echo "<script>alert('Your order details have been sent. Please check your Telegram chat for details.');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Options</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            overflow-x: hidden; /* Prevent horizontal overflow */
        }
        .container {
            max-width: 900px;
            margin: auto;
        }
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .card-img-top {
            max-height: 150px;
            object-fit: contain;
            margin: 20px auto; /* Center the image */
        }
        .card-title {
            font-size: 1.5rem;
        }
        .card-text {
            font-size: 1.2rem;
        }
        .btn-continue {
            margin-top: 20px;
            font-size: 1.2rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<div class="alert alert-info mt-4 card-text">
                        <strong>Important Information:</strong>
                        <p>We are only doing payment through direct transfers. Details will be automatically sent to us. You can also message us for more customisation and size options. We will message you to complete the payment</p>
                    </div>
    <div class="container mt-5">
        <h5 class="text-center text-info mb-4">PAYMENT OPTIONS</h5>
        <div class="row flex-column align-items-center">
           
            <div class="col-md-6">
                <div class="card text-center p-4 mb-4 shadow-sm">
                    <!-- Checkout Form -->
                    <form method="post" action="payment.php">
                        <div class="form-group">
                            <label for="customer_telegram">Telegram Contact:</label>
                            <input type="text" id="customer_telegram" name="customer_telegram" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-continue" name="complete_order">Complete Order</button>
                    </form>
                    <div class="card-body">
                        <h2 class="card-title">On Telegram</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Continue Shopping Button -->
        <div class="text-center">
            <a href="../shop/index.php" class="btn btn-primary btn-continue">Continue Shopping</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
