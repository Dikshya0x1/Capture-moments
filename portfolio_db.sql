CREATE DATABASE IF NOT EXISTS portfolio_db;

USE portfolio_db;

-- Table for users (Admin login)
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for the gallery (Images)
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,  
    title VARCHAR(100),               
    description TEXT,
    category VARCHAR(50), 
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for contact form submissions
CREATE TABLE IF NOT EXISTS contact (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin user
INSERT INTO admin (username, password) 
VALUES ('admin', MD5('admin123'));
