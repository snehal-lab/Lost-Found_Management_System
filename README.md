Lost & Found Management System

Project Title

Lost & Found Management System

Problem Statement

Managing lost and found items manually can make it difficult to record reports, search for items, identify possible matches, and keep track of the current status of each report. This project provides a simple web-based system for recording and managing Lost and Found reports in a structured MySQL database.

Assigned Feature Set

The project was developed around the following five assigned features:

Add / Edit / Delete Lost or Found Reports

Category Selection

Search and Filter Items

Match Lost and Found Items

Status Tracking

Features Implemented

1. Add / Edit / Delete Reports

Add a new Lost or Found report.

Enter item name, description, category, location, date, person name, and phone number.

Edit existing reports.

Delete existing reports with confirmation.

2. Category Selection

Reports can be organized into categories such as:

Electronics

Documents

Bags

Books

Personal

Accessories

Other

3. Search and Filter Items

The Search & Filter page supports:

Keyword search by item name, description, location, or person name.

Category filtering.

Lost / Found type filtering.

Status filtering.

Clearing all filters.

4. Match Lost and Found Items

The Match feature checks for possible opposite-type reports using report information such as:

Lost vs Found type

Same category

Similar item name or location

Pending status

Possible matches are displayed in a popup.

5. Status Tracking

Each report can be tracked using:

Pending

Matched

Returned

Closed

The selected status is stored in the MySQL database.

Technologies Used

Frontend

HTML5

CSS3

JavaScript

Backend

Core PHP

Database

MySQL

phpMyAdmin

Development Environment

XAMPP

Apache

AI Tools Used

AI Tool: ChatGPT

ChatGPT was used as a development assistance tool for:

Generating and improving HTML/CSS/JavaScript interfaces.

Creating PHP backend files and MySQL queries.

Connecting frontend pages with PHP APIs using fetch().

Debugging navigation, form submission, JSON responses, redirects, and database-related issues.

Improving page layout and responsive styling.

Preparing project documentation and README content.

Important AI Prompt / AI Usage

Example prompts used during development:

"Create a Lost & Found Management System using HTML, CSS, JavaScript, Core PHP and MySQL with only these five features: Add/Edit/Delete Reports, Category Selection, Search and Filter, Match Lost and Found Items, and Status Tracking. Give complete ready-to-paste code with separate frontend and backend folders."

Other AI-assisted tasks included requests such as:

"Give the complete reports.html code with navigation to Home, Add Report, View Reports and Search & Filter, and make Edit, Delete, Match and Status Tracking work with the PHP backend."

"Give complete search.html and search_reports.php code for keyword search and category, type and status filters."

The generated code was then placed into the local XAMPP project, tested, and adjusted according to the project requirements.

Project Folder Structure

SnehalP/
│
├── index.php
│
├── frontend/
│   ├── index.html
│   ├── add.html
│   ├── reports.html
│   ├── search.html
│   └── edit.html
│
└── backend/
    ├── db.php
    ├── add_report.php
    ├── get_reports.php
    ├── get_report.php
    ├── edit_report.php
    ├── delete_report.php
    ├── search_reports.php
    ├── match.php
    └── update_status.php

Database Setup

Create the database in phpMyAdmin:

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

Instructions to Run the Project

Step 1: Install and Start XAMPP

Start these services from the XAMPP Control Panel:

Apache

MySQL

Step 2: Copy the Project

Copy the SnehalP project folder into:

C:\xampp\htdocs\

The final location should be:

C:\xampp\htdocs\SnehalP\

Step 3: Create the Database

Open:

http://localhost/phpmyadmin/

Create the database lost_found_db and the reports table using the SQL shown above.

Step 4: Check Database Connection

Open:

C:\xampp\htdocs\SnehalP\backend\db.php

The default XAMPP connection used by this project is:

Host: localhost
Username: root
Password: empty
Database: lost_found_db

Step 5: Open the Project

Open the main project URL:

http://localhost/SnehalP/

Step 6: Test the Features

Use the navigation menu to test:

Home
→ Add Report
→ View Reports
→ Search & Filter
→ Edit / Delete
→ Match
→ Update Status

Main Page URLs

Home:
http://localhost/SnehalP/frontend/index.html

Add Report:
http://localhost/SnehalP/frontend/add.html

View Reports:
http://localhost/SnehalP/frontend/reports.html

Search & Filter:
http://localhost/SnehalP/frontend/search.html

Edit Report:
http://localhost/SnehalP/frontend/edit.html?id=1

Screenshots of the Working Project

For the final submission, capture screenshots after the project is running successfully and save them in the screenshots folder using these names:

screenshots/
├── home.png
├── add_report.png
├── reports.png
├── search_filter.png
├── edit_report.png
├── match_result.png
└── status_tracking.png

Then add them to this section using Markdown, for example:

### Home Page
![Home Page](screenshots/home.png)

### Add Report Page
![Add Report](screenshots/add_report.png)

### Reports Page
![Reports Page](screenshots/reports.png)

### Search & Filter Page
![Search & Filter](screenshots/search_filter.png)

### Edit Report Page
![Edit Report](screenshots/edit_report.png)

### Match Result
![Match Result](screenshots/match_result.png)

### Status Tracking
![Status Tracking](screenshots/status_tracking.png)

Supplied Setup Screenshots

The screenshots currently supplied with the project documentation show setup/debugging states rather than successful working screens. They are therefore included for troubleshooting evidence and should not be presented as working-project screenshots.

Conclusion

The Lost & Found Management System provides the five assigned features in a simple web application using HTML, CSS, JavaScript, Core PHP, MySQL, and XAMPP. The system supports report management, category selection, searching and filtering, matching possible Lost and Found items, and status tracking.

## Author

Name: Snehal Krishnat Patil
Course: BCA (5th Sem)
College/University: K.L.E Society's BCA College Nipani  
Project: Lost & Found Management System
