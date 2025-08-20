-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 28 2024 г., 16:56
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `mystore`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin_tabel`
--

CREATE TABLE `admin_tabel` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `admin_email` varchar(200) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_title`) VALUES
(1, 'NIKE'),
(2, 'ADIDAS'),
(3, 'NEW BALANCE');

-- --------------------------------------------------------

--
-- Структура таблицы `cart_details`
--

CREATE TABLE `cart_details` (
  `product_id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `quantity` int(100) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `cart_details`
--

INSERT INTO `cart_details` (`product_id`, `ip_address`, `quantity`, `session_id`, `user_id`) VALUES
(1, '', 1, 'okhllk4hqnb7nopqqlmqunltuu', 0),
(4, '', 1, 'okhllk4hqnb7nopqqlmqunltuu', 0),
(5, '', 1, 'okhllk4hqnb7nopqqlmqunltuu', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`) VALUES
(1, 'JERSEYS'),
(2, 'SHOES');

-- --------------------------------------------------------

--
-- Структура таблицы `orders_pending`
--

CREATE TABLE `orders_pending` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(255) NOT NULL,
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(100) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_keywords` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_image1` varchar(255) NOT NULL,
  `product_image2` varchar(255) NOT NULL,
  `product_image3` varchar(255) NOT NULL,
  `product_image4` varchar(255) NOT NULL,
  `product_price` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_description`, `product_keywords`, `category_id`, `brand_id`, `product_image1`, `product_image2`, `product_image3`, `product_image4`, `product_price`, `date`, `status`) VALUES
(1, 'Argentina home fan jersey 24/25', 'Copa America 2024 adidas jersey for Argentina ', 'Copa, America, 2024, adidas, jersey, Argentina ', 1, 2, 'c4a4f2bb11111.jpeg', '66fdeda9.jpeg', '3649487a.jpeg', '641aba25.jpeg', '2300', '2024-05-27 18:32:36', 'true'),
(4, '24/25 Arsenal home', '24/25 season Arsenal home jersey', '24/25, Arsenal, home, fan, premier league, EPL', 1, 2, '36ef491a.jpeg', 'd08d5397.jpeg', '0281a8ea.jpeg', 'e239fff7.jpeg', '23', '2024-05-22 13:17:01', 'true'),
(5, '24/25 Barcelona Home', '24/25 season Barcelona home jersey', '24/25, Barcelona, home, fan, , la liga,spain', 1, 1, 'b97ea4b4.jpeg', '37c316df.jpeg', '4d39396b.jpeg', '4dbcdc84.jpeg', '23', '2024-05-22 13:25:55', 'true'),
(6, '24/25 Real Madrid home', '24/25 season Real Madrid home jersey', '24/25, Barcelona, home, fan, , la liga,spain', 1, 2, '22dc7ada.jpeg', 'f7cd8c41.jpeg', '376ae908.jpeg', '0e830a7d.jpeg', '23', '2024-05-22 13:32:00', 'true'),
(8, 'Nike Dunk Scrap', 'Stitched White and Green Pink DM0802-001 This ingeniously crafted Dunk Scrap is inspired by the waste materials scattered on the floor of the shoemaker\'s studio.', 'Nike, Dunk, Scrap, 2024', 2, 1, '1-26.jpg', '2-26-300x211.jpg', '4-23-300x300.jpg', '5-21-300x211.jpg', '6500', '2024-05-27 18:01:14', 'true'),
(10, 'Joe Freshgoods x New Balance NB9060', 'Joint model retro casual sports jogging shoes U9060FRL #Shoes are inspired by the designer’s own nostalgic memories of summer. Size: 36-45', 'Joe, Freshgoods, New Balance, NB9060', 2, 3, 'i1715879163_2472_0.jpg', 'i1715879163_6106_2.jpg', 'i1715879163_8722_4.jpg', 'i1715879163_9194_5.jpg', '7000', '2024-05-27 18:15:53', 'true'),
(11, 'Adidas Campus 00s', 'Adidas. Men\'s and women\'s shoes. Clover CAMPUS 00s bread shoes, retro casual sneakers. Millennial resurgence! adidas Campus 00s classic returns!', 'Adidas, Campus, 00s, brown', 2, 2, 'i1716496404_8648_8.jpg', 'i1716496404_3797_4.jpg', 'i1716496404_1674_2.jpg', 'i1716496404_8418_6.jpg', '6500', '2024-05-27 18:27:24', 'true');

-- --------------------------------------------------------

--
-- Структура таблицы `user_orders`
--

CREATE TABLE `user_orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount_due` int(255) NOT NULL,
  `invoice_number` int(255) NOT NULL,
  `total_products` int(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_payments`
--

CREATE TABLE `user_payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `paynent_mode` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_ip` varchar(100) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_mobile` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `user_table`
--

INSERT INTO `user_table` (`user_id`, `username`, `user_email`, `user_password`, `user_image`, `user_ip`, `user_address`, `user_mobile`) VALUES
(1, 'XaiJ', 'xaij100@gmail.com', '$2y$10$GHiZQw7pXTfnPeo0EfZBD.77/zMH2Z36gUalWMCGDjkeYgJDJ68Iq', 'IMG_8909.heif', '127.0.0.1', 'johnlaing', 2147483647);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin_tabel`
--
ALTER TABLE `admin_tabel`
  ADD PRIMARY KEY (`admin_id`);

--
-- Индексы таблицы `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Индексы таблицы `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`product_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Индексы таблицы `orders_pending`
--
ALTER TABLE `orders_pending`
  ADD PRIMARY KEY (`order_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Индексы таблицы `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Индексы таблицы `user_payments`
--
ALTER TABLE `user_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Индексы таблицы `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admin_tabel`
--
ALTER TABLE `admin_tabel`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `orders_pending`
--
ALTER TABLE `orders_pending`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user_payments`
--
ALTER TABLE `user_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
