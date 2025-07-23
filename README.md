📚 PHP Bookstore App
====================

A full-stack CRUD bookstore app using PHP, MySQL, HTML, CSS, JavaScript with Bootstrap and jQuery.

Technologies:
-------------
[PHP Backend]    [Bootstrap Styled]    [jQuery AJAX Ready]    [MySQL Database]




🚀 Features
----------

✅ Backend (PHP and MySQL)
- Add / Edit / Delete / View - books
- Upload cover images (JPG/PNG)
- Logs actions in log.txt
- MySQL storage with auto timestamps

🎨 Frontend (HTML + CSS + JS)
- AJAX operations (no reloads)
- Responsive layout (Bootstrap)
- Client-side validation
- Dynamic UI with jQuery


🧰 Tech Stack
-------------

Category     | Tools
-------------|-----------------------
Language     | PHP, JavaScript
Database     | MySQL
Styling      | CSS, Bootstrap 5
Scripting    | jQuery, AJAX
Logging      | File-based logging


📁 Project Structure
--------------------

bookstore/
├── index.php          - Main UI  
├── api.php            - API logic  
├── db.php             - DB connection  
├── uploads/           - Image folder  
├── log.txt            - Activity logs  
├── assets/  
│   ├── css/           - Styles  
│   └── js/            - Scripts  
└── books.sql          - SQL schema  


🛠️ Setup Instructions
----------------------

1. 📦 Clone the Repository
---------------------------
git clone https://github.com/your-username/php-bookstore.git  
cd php-bookstore  

2. 💾 Create MySQL Database
----------------------------
Use phpMyAdmin or MySQL CLI to run the following:

CREATE TABLE books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  author VARCHAR(255),
  price DECIMAL(10,2),
  cover VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

3. 🔧 Configure Database in db.php
----------------------------------
$host = 'localhost';  
$db   = 'your_db';  
$user = 'your_user';  
$pass = 'your_pass';  

4. 🌐 Run the App
-----------------
Start your local server (XAMPP, LAMP, etc.)  
Visit: http://localhost/bookstore/index.php  





📒 Logging Example
-------------------

log.txt content:

[2025-07-21 12:30:45] Book added: "Clean Code" by Robert C. Martin  
[2025-07-21 12:31:10] Book deleted: ID 5  


🔮 Future Ideas
----------------

- 🔍 Book search and filters  
- 👤 User login & admin panel  
- ⭐ Ratings and reviews  
- 🗂️ Category management  

