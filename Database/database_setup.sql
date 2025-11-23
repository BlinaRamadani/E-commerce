-- Database: urban_service
-- Create this database first, then run these queries

CREATE DATABASE IF NOT EXISTS urban_service;
USE urban_service;

-- Table for city issues/reports
CREATE TABLE IF NOT EXISTS reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reference_number VARCHAR(20) UNIQUE NOT NULL,
    category VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(255) NOT NULL,
    latitude DECIMAL(10, 8) NULL,
    longitude DECIMAL(11, 8) NULL,
    urgency ENUM('low', 'medium', 'high') DEFAULT 'low',
    photo_path VARCHAR(255) NULL,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NULL,
    email VARCHAR(100) NOT NULL,
    status ENUM('pending', 'in_progress', 'resolved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_category (category),
    INDEX idx_created_at (created_at)
);

-- Table for admin users
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user (username: admin, password: admin123)
-- Password is hashed using PHP's password_hash()
INSERT INTO admin_users (username, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@urbanservice.com');

-- Table for report updates/comments
CREATE TABLE IF NOT EXISTS report_updates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    report_id INT NOT NULL,
    update_message TEXT NOT NULL,
    updated_by VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (report_id) REFERENCES reports(id) ON DELETE CASCADE
);