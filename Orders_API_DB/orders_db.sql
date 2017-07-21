-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2017 at 02:05 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orders_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_Payment` (IN `order_id` INT)  begin
update orders_entity set status='processed' where id=order_id;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cancel_order` (IN `order_id` INT)  begin
update orders_entity set status='cancelled',updated_at=now() where id=order_id;
update order_items_entity set updated_at=now() where order_id=order_id;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_order_sp` (IN `email_id` VARCHAR(150), IN `name` VARCHAR(100), IN `price` DOUBLE, IN `quantity` INT)  begin
declare order_id int default 0;


insert into Orders_Entity(email_id,status,created_at)values(email_id,'created',now());
set order_id=last_insert_id();

insert into Order_Items_Entity(order_id,name,price,quantity,created_at)values(order_id,name,price,quantity,now());
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_order_orderItem_sp` (IN `order_id` INT, IN `email_id` VARCHAR(150), IN `status` ENUM('created','processed','delivered','cancelled'), IN `name` VARCHAR(100), IN `price` DOUBLE, IN `quantity` INT)  begin

update Orders_Entity set Orders_Entity.email_id = email_id, Orders_Entity.status= status,Orders_Entity.updated_at=now() where Orders_Entity.id=order_id;
update Order_Items_Entity set Order_Items_Entity.name=name,Order_Items_Entity.price=price,Order_Items_Entity.quantity=quantity,Order_Items_Entity.updated_at=now() where Order_Items_Entity.order_id=order_id;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `orders_entity`
--

CREATE TABLE `orders_entity` (
  `id` bigint(20) NOT NULL,
  `email_id` varchar(150) DEFAULT NULL,
  `status` enum('created','processed','delivered','cancelled') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders_entity`
--

INSERT INTO `orders_entity` (`id`, `email_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'john.zacc99gmail.com', 'created', '2016-05-19 13:51:00', NULL),
(2, 'john.zacc99gmail.com', 'cancelled', '2017-06-21 13:51:28', '2017-07-21 14:02:57'),
(3, 'john.zacc99gmail.com', 'created', '2017-07-21 13:52:00', NULL),
(4, 'john.zacc99gmail.com', 'created', '2017-07-21 13:52:26', NULL),
(5, 'kiran.malhotra@gmail.com', 'created', '2017-07-21 13:53:46', NULL),
(6, 'kiran.malhotra@gmail.com', 'created', '2017-07-21 13:54:22', NULL),
(7, 'katy.p449@outlook.com', 'created', '2017-07-21 13:55:42', NULL),
(8, 'katy.p449@outlook.com', 'delivered', '2017-07-21 13:56:45', '2017-07-21 14:00:03');

-- --------------------------------------------------------

--
-- Table structure for table `order_items_entity`
--

CREATE TABLE `order_items_entity` (
  `id` bigint(20) NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items_entity`
--

INSERT INTO `order_items_entity` (`id`, `order_id`, `name`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bluetooth Speaker', 3999, 2, '2017-07-21 13:51:00', '2017-07-21 14:02:57'),
(2, 2, 'MotoG4Plus', 16000, 1, '2017-07-21 13:51:28', '2017-07-21 14:02:57'),
(3, 3, 'Fidget Spinner', 360, 1, '2017-07-21 13:52:00', '2017-07-21 14:02:57'),
(4, 4, 'Lenovo 22inch Monitor', 15000, 1, '2017-07-21 13:52:26', '2017-07-21 14:02:57'),
(5, 5, 'Nike_Blue sport shoes', 2899, 2, '2017-07-21 13:53:46', '2017-07-21 14:02:57'),
(6, 6, 'Key Holder Kit', 150, 4, '2017-07-21 13:54:22', '2017-07-21 14:02:57'),
(7, 7, 'Dell inspiron 5000series', 65000, 1, '2017-07-21 13:55:42', '2017-07-21 14:02:57'),
(8, 8, 'Adidas Ladies Sport Shoes', 2000, 2, '2017-07-21 13:56:45', '2017-07-21 14:02:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders_entity`
--
ALTER TABLE `orders_entity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items_entity`
--
ALTER TABLE `order_items_entity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders_entity`
--
ALTER TABLE `orders_entity`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `order_items_entity`
--
ALTER TABLE `order_items_entity`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
