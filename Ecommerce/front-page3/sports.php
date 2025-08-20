<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
@session_start();
if (!$con) {
    die("Database connection failed");
}

// Set default language
$lang = 'en';

// Check if a language is selected
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
} elseif (isset($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
}

// Load the language file
$translations = include("../languages/{$lang}.php");

function __($section, $key) {
    global $translations;
    return $translations[$section][$key] ?? $key;
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo __('sports', 'title'); ?></title>
    <link rel="stylesheet" href="sports.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="./icons.css">
</head>
<body>
<style>
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown-content form {
        display: block;
        margin: 0;
    }

    .dropdown-content select {
        width: 100%;
        padding: 8px;
        border: none;
        background: #f9f9f9;
        cursor: pointer;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown-content select:hover {
        background-color: #f1f1f1;
    }

    .translate-icon {
        color: white;
        cursor: pointer;
    }

    .translate-icon:hover {
        color: #ddd;
    }
</style>
<header>
    <a href="../index.php" class="logo" target="_self"><img src="/front-page1/FIRSTLOGOB2.png" alt=""></a>
    <ul class="Centered-links">
        <li><a href="../index.php" target="_self"><?php echo __('common', 'content'); ?></a></li>
        <li><a href="../front-page2/shoes.php" target="_self"><?php echo __('common', 'shoes'); ?></a></li>
        <li><a href="sports.php" target="_self"><?php echo __('common', 'sportswear'); ?></a></li>
    </ul>
    <ul class="top-right-links">
        <li class="nav-item">
            <a class="nav-link" href="cart.php">
                <span class="material-symbols-outlined">shopping_cart</span>
                <sup><?php cart_item(); ?></sup>
            </a>
        </li>
        <li class="dropdown">
            <span class="material-symbols-outlined translate-icon">translate</span>
            <div class="dropdown-content">
                <form method="get" action="">
                    <select name="lang" onchange="this.form.submit()">
                        <option value="en" <?php if ($lang == 'en') echo 'selected'; ?>>English</option>
                        <option value="ru" <?php if ($lang == 'ru') echo 'selected'; ?>>Русский</option>
                         <option value="ja" <?php if ($lang == 'ja') echo 'selected'; ?>>日本語</option>
                        <option value="es" <?php if ($lang == 'es') echo 'selected'; ?>>Español</option>
                        <option value="ar" <?php if ($lang == 'ar') echo 'selected'; ?>>العربية</option>
                        <option value="fr" <?php if ($lang == 'fr') echo 'selected'; ?>>Français</option>
                    </select>
                </form>
            </div>
        </li>
    </ul>
</header>

<div class="container">
  <a href="shopjerseys.php" class="background">
    <section>
      <div class="content-wrapper">
        <img src="main-page-pictures/logo.png" alt="">
        <p class="content-title"><?php echo __('sports', 'new_season'); ?></p>
        <p class="content-subtitle"><?php echo __('sports', 'new_season_subtitle'); ?></p>
      </div>
    </section>
  </a>
  <a href="shopjerseys.php" class="background">
    <section>
      <div class="content-wrapper">
        <p class="content-title"><?php echo __('sports', 'new_jerseys'); ?></p>
        <p class="content-subtitle"><?php echo __('sports', 'new_jerseys_subtitle'); ?></p>
      </div>
    </section>
  </a>
  <a href="shopjerseys.php" class="background">
    <section>
      <div class="content-wrapper">
        <p class="content-title"><?php echo __('sports', 'retro_jerseys'); ?></p>
        <p class="content-subtitle"><?php echo __('sports', 'retro_jerseys_subtitle'); ?></p>
      </div>
    </section>
  </a>
</div>
<footer>
    <ul class="bottom-links">
        <li><a href="index.php"><span class="material-symbols-outlined">home_app_logo</span></a></li>
        <li><a href="search_product.php"><span class="material-symbols-outlined">search</span></a></li>
        <?php
        // Check if the user is logged in
        if (isset($_SESSION['username'])) {
            // If logged in, link to profile.php
            echo '<li><a href="./users_area/profile.php"><span class="material-symbols-outlined">person</span></a></li>';
        } else {
            // If not logged in, link to user_registration.php
            echo '<li><a href="./users_area/user_registration.php"><span class="material-symbols-outlined">person</span></a></li>';
        }
        ?>
    </ul>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.10.1/lodash.min.js"></script>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="../js/INDEXPRXLINKS.js"></script>
</body>
</html>