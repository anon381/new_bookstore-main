PHP Bookstore Application

A simple full-stack bookstore app built with PHP, MySQL, HTML, CSS, JavaScript, jQuery, and Bootstrap. 
It supports basic CRUD operations on books and includes features like image upload and logging.

Features:

Backend (PHP + MySQL)
- Add, edit, delete, and view books
- Upload book cover images (JPG/PNG)
- Store data in MySQL
- Log all actions (Add/Edit/Delete) with timestamps to a log.txt file

Frontend (HTML + CSS + JS)
- Responsive UI using Bootstrap
- Interactive operations with jQuery
- AJAX-based CRUD (no page reload)
- Image preview before upload

Folder Structure:

bookstore/
├── index.php              - Main frontend UI
├── api.php                - Backend API logic
├── db.php                 - MySQL connection config
├── uploads/               - Folder for uploaded cover images
├── log.txt                - Log file for all actions
├── assets/
│   ├── css/               - Custom CSS
│   └── js/                - Custom JavaScript
└── books.sql              - SQL dump to create books table

Technology Stack:

Backend    : PHP, MySQL  
Frontend   : HTML, CSS, JavaScript  
UI Library : Bootstrap  
Scripting  : jQuery (with AJAX)

Setup Instructions:

1. Clone or download the project to your local server (e.g., htdocs for XAMPP)
2. Create a MySQL database and import books.sql
3. Update db.php with your database credentials
4. Start your local server and visit: http://localhost/bookstore/index.php

Database Table Schema (books.sql):

CREATE TABLE books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  author VARCHAR(255),
  price DECIMAL(10,2),
  cover VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

Log Format (log.txt):

Each action is logged with a timestamp. Example:
[2025-07-21 12:30:45] Book added: "Clean Code" by Robert C. Martin

Planned Improvements:

- Search and filter functionality
- Pagination support
- Basic user login/admin panel
- Review and rating system

License:

This project is open-source. Use it freely for learning or as a base for your projects.


