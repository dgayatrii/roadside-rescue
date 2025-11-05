-- Create Database
CREATE DATABASE IF NOT EXISTS roadside_rescue;
USE roadside_rescue;

-- Drop existing tables if they exist
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS contact_messages;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS users;

-- ==========================================
-- Table: users
-- ==========================================
CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  fullname VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  phone VARCHAR(15) NOT NULL,
  vehicle VARCHAR(100) DEFAULT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('user', 'admin') DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX idx_email (email),
  INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Table: services
-- ==========================================
CREATE TABLE services (
  id INT(11) NOT NULL AUTO_INCREMENT,
  service_name VARCHAR(100) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  image_url VARCHAR(255) DEFAULT 'images/default.png',
  status ENUM('active', 'inactive') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Table: bookings
-- ==========================================
CREATE TABLE bookings (
  id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  service_id INT(11) NOT NULL,
  location VARCHAR(255) NOT NULL,
  vehicle_details VARCHAR(255),
  issue_description TEXT,
  status ENUM('pending', 'assigned', 'completed', 'cancelled') DEFAULT 'pending',
  booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  completed_date TIMESTAMP NULL DEFAULT NULL,
  mechanic_name VARCHAR(100) DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE,
  INDEX idx_user_id (user_id),
  INDEX idx_service_id (service_id),
  INDEX idx_status (status),
  INDEX idx_booking_date (booking_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Table: contact_messages
-- ==========================================
CREATE TABLE contact_messages (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  status ENUM('unread', 'read') DEFAULT 'unread',
  PRIMARY KEY (id),
  INDEX idx_status (status),
  INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Insert Default Data
-- ==========================================

-- Insert Admin User
-- Password: password (hashed with bcrypt)
INSERT INTO users (fullname, email, phone, vehicle, password, role) VALUES
('Admin', 'admin@roadsiderescue.com', '9876543210', 'Admin Vehicle', 
'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert Sample User
-- Password: user123
INSERT INTO users (fullname, email, phone, vehicle, password, role) VALUES
('Rahul Sharma', 'rahul@example.com', '9876543211', 'Maruti Swift 2019', 
'$2y$10$hVfZQv3Q0p8HfGvzj3k2euV5qP3aHZdNfRy8K9Wb4QAvQ2l7p05ti', 'user');

-- Insert Services
INSERT INTO services (service_name, description, price, image_url) VALUES
('Battery Jump-Start', 'Professional battery jump-start service to get you moving. Our technicians will safely jump-start your vehicle.', 500.00, 'images/battery.png'),
('Flat Tire Change', 'Quick and safe tire change with your spare tire. We handle all tire changes professionally with proper tools.', 800.00, 'images/tire.png'),
('Fuel Delivery', 'Emergency fuel delivery to your location. We bring enough fuel to get you to the nearest gas station.', 600.00, 'images/fuel.png'),
('Vehicle Lockout', 'Professional vehicle unlocking without damage. Our trained technicians can unlock most vehicle models safely.', 1000.00, 'images/lockout.png'),
('Towing Service', 'Safe vehicle towing to your preferred location. We have modern tow trucks and trained operators.', 1500.00, 'images/towing.png'),
('Minor On-Site Repairs', 'Quick fixes and minor repairs done on the spot. Our mechanics carry common parts and tools.', 2000.00, 'images/repair.png');

-- Insert Sample Bookings
INSERT INTO bookings (user_id, service_id, location, vehicle_details, issue_description, status, mechanic_name) VALUES
(2, 1, 'Near CBS College, Nashik Road', 'Maruti Swift 2019', 'Car battery is dead, need jump start', 'completed', 'Amit Kumar'),
(2, 3, 'Gangapur Road, Near IOCL Petrol Pump', 'Maruti Swift 2019', 'Running out of fuel', 'completed', 'Rajesh Patil'),
(2, 2, 'Mumbai-Agra Highway, KM 45', 'Maruti Swift 2019', 'Flat tire on highway', 'pending', NULL);

-- Insert Sample Contact Messages
INSERT INTO contact_messages (name, email, message, status) VALUES
('Priya Desai', 'priya@example.com', 'Great service! Very quick response time. Highly recommended.', 'read'),
('Vikram Singh', 'vikram@example.com', 'Need to know about your monthly service packages. Please call me.', 'unread');

-- ==========================================
-- Create Views for Reports
-- ==========================================
CREATE OR REPLACE VIEW booking_summary AS
SELECT 
    b.*,
    u.fullname as customer_name,
    u.email,
    u.phone,
    s.service_name,
    s.price
FROM bookings b
JOIN users u ON b.user_id = u.id
JOIN services s ON b.service_id = s.id
ORDER BY b.booking_date DESC;