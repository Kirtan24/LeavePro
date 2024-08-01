-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2023 at 08:00 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leavepro`
--

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `leave_type` int(11) NOT NULL,
  `reasone` varchar(255) NOT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `by_whome` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `emp_id`, `leave_type`, `reasone`, `from_date`, `to_date`, `status`, `by_whome`) VALUES
(2, 1, 7, 'I am feeling very sick today.', '2023-08-03', '2023-08-04', 'canceled', 3);

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `credits` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `name`, `description`, `credits`) VALUES
(1, 'Annual Leave', 'Annual leave, also known as vacation leave, is designed to provide employees with the opportunity to take time off for personal and leisure activities.\r\n', 1),
(2, 'Parental Leave', 'Parental leave acknowledges the importance of family and provides time off for new parents to care for their newborns or adopted children.', 1),
(3, 'Bereavement Leave', 'Bereavement leave is offered to employees who have suffered the loss of a loved one.', 1),
(4, 'Personal Leave', 'Personal leave is a flexible option that you can use for various personal reasons not covered by other leave types.', 1),
(5, 'Remote Work From Hom', 'Employee will have the opportunity to work from home in some situation.', 1),
(7, 'Sick Leave', 'This is sick leave', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `salary` varchar(10) DEFAULT NULL,
  `leave_credit` int(10) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `marital_status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `password`, `gender`, `dob`, `salary`, `leave_credit`, `image`, `marital_status`) VALUES
(1, 'Kirtan', 'pithadiyakirtan08@gmail.com', 'employee', '60e9dc46d921350a39d108cba3c0913a', 'Male', '2003-08-23', '196000', 10, 'Pithadiya Kirtan_1690622621_default.jpg', 'Married'),
(2, 'Jaydeep', 'onlyadmin@gmail.com', 'superadmin', '0192023a7bbd73250516f069df18b500', 'Male', '1975-12-12', NULL, NULL, 'admin.jpg', 'Married'),
(3, 'Ravi', 'ravi@gmail.com', 'admin', 'c93ccd78b2076528346216b3b2f701e6', 'Male', '2000-01-04', '19500', 10, 'Ravi_1690989906_default.jpg', 'Married');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_emp` (`emp_id`),
  ADD KEY `fk_type` (`leave_type`) USING BTREE,
  ADD KEY `fk_by_whome` (`by_whome`) USING BTREE;

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leaves`
--
ALTER TABLE `leaves`
  ADD CONSTRAINT `fk_approved_by` FOREIGN KEY (`by_whome`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_emp` FOREIGN KEY (`emp_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_type` FOREIGN KEY (`leave_type`) REFERENCES `leave_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
