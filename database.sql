-- =============================================================================
-- Employee Record Tracking System - Database Schema
-- Course: Web Systems Technologies (PHP and MySQL Development)
-- Instructor: Sir Kenth Joshua Espina
-- Institution: Iloilo State University of Fisheries Science and Technology (ISUFST)
-- Database Name: employee_tracker_db
-- =============================================================================

-- -----------------------------------------------------------------------------
-- (Note: If running on local XAMPP for the first time, create the database
--  'employee_tracker_db' first in phpMyAdmin, then import this file.
--  On InfinityFree, select your created database then import.)
-- -----------------------------------------------------------------------------

-- Drop old table if exists
DROP TABLE IF EXISTS `employees`;

-- Create employees table (11 fields, meeting rubric requirement)
CREATE TABLE `employees` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `employee_id` VARCHAR(20) NOT NULL UNIQUE,
    `first_name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `phone` VARCHAR(25) NOT NULL,
    `department` VARCHAR(50) NOT NULL,
    `position` VARCHAR(50) NOT NULL,
    `salary` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    `hire_date` DATE NOT NULL,
    `status` ENUM('Active', 'On Leave', 'Probationary', 'Resigned') NOT NULL DEFAULT 'Active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
