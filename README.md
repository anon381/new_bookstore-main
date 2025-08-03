
<p align="center">
  <img src="https://readme-typing-svg.demolab.com?font=Fira+Code&weight=700&size=26&duration=3500&pause=1000&color=38BDF8&center=true&vCenter=true&width=500&lines=%F0%9F%93%9A+PHP+Bookstore+App" alt="Typing SVG" />
</p>

A full-stack CRUD bookstore app using PHP, MySQL, HTML, CSS, JavaScript with Bootstrap and jQuery.

Technologies:
-------------
[PHP Backend]    [Bootstrap Styled]    [jQuery AJAX Ready]    [MySQL Database]


## 🚀 Features

### ✅ Backend (PHP + MySQL)
- 📚 **Add / Edit / Delete / View** books  
- 🖼️ **Upload** book cover images (JPG / PNG)  
- 📝 **Log actions** to `log.txt` (create, update, delete)  
- ⏱️ **Auto timestamps** via MySQL  

### 🎨 Frontend (HTML + CSS + JS)
- ⚡ **AJAX-powered** operations (no page reloads)  
- 📱 **Responsive layout** with Bootstrap  
- ✅ **Client-side validation**  
- 🧩 **Interactive UI** using jQuery  

---

## 🧰 Tech Stack

| 🗂️ Category    | 🔧 Tools                            |
|----------------|------------------------------------|
| 💻 Language     | PHP, JavaScript                     |
| 🛢️ Database     | MySQL                               |
| 🎨 Styling      | CSS, Bootstrap 5                    |
| ⚙️ Scripting    | jQuery, AJAX                        |
| 🧾 Logging      | File-based logging (`log.txt`)      |



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


## 🛠️ Setup Instructions

<details>
<summary>📦 <strong>Step 1: Clone the Repository</strong></summary>

| Command | Description |
|--------|-------------|
| `git clone https://github.com/your-username/php-bookstore.git` | Clone the repository |
| `cd php-bookstore` | Navigate into the project folder |

</details>

---

<details>
<summary>💾 <strong>Step 2: Create MySQL Database</strong></summary>

Use **phpMyAdmin** or **MySQL CLI** to execute the following:

```sql
CREATE TABLE books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  author VARCHAR(255),
  price DECIMAL(10,2),
  cover VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
</details>

---

<details>
<summary>💾 <strong>Step 3 Configure Database in db.php  </strong></summary>

----------------------------------
$host = 'localhost';  
$db   = 'your_db';  
$user = 'your_user';  
$pass = 'your_pass';  

</details>

---
<details>
<summary>🌐  <strong>4. Run the App  </strong></summary>

-----------------
Start your local server (XAMPP, LAMP, etc.)  
Visit: http://localhost/bookstore/index.php  

</details>

---



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

