CREATE DATABASE lost_found_db;

USE lost_found_db;

CREATE TABLE reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(150) NOT NULL,
    description TEXT,
    category VARCHAR(100) NOT NULL,
    location VARCHAR(150) NOT NULL,
    report_date DATE NOT NULL,
    person_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    type ENUM('Lost','Found') NOT NULL,
    status ENUM('Pending','Matched','Returned','Closed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);