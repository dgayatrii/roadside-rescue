# 🚗 Roadside Rescue (PHP Project)

This is a complete web application for a vehicle breakdown assistance service, built with PHP, MySQL, and JavaScript. It features a full user and admin system for managing bookings and services.

## 🚀 Features

* **User System:**
    * User Registration and Login
    * User Dashboard to view personal booking history
    * Ability to create new service bookings
* **Admin Panel:**
    * Secure Admin Login (different from user login)
    * Admin Dashboard with an overview of all site activity
    * **Services CRUD:** Full Create, Read, Update, and Delete functionality for all services.
    * **Booking Management:** View all user bookings and update their status (e.g., "Pending" to "Assigned" or "Completed").
    * **User Management:** View all registered users on the platform.
* **Public Pages:**
    * Homepage
    * About Us page
    * Dynamic Services page that loads all services from the database.
    * Contact page with a form that saves messages directly to the database.

## 🛠️ Tech Stack

* **Frontend:** HTML, CSS, Bootstrap, JavaScript
* **Backend:** PHP
* **Database:** MySQL

## ⚙️ How to Run This Project Locally

1.  **Prerequisites:**
    * You must have **XAMPP** (or a similar AMP stack) installed and running (Apache & MySQL).

2.  **Clone the repository:**
    ```bash
    git clone [https://github.com/YOUR-USERNAME/roadside-rescue.git](https://github.com/YOUR-USERNAME/roadside-rescue.git)
    ```

3.  **Place in `htdocs`:**
    * Move the entire `roadside-rescue` folder into your XAMPP `htdocs` directory (usually `C:\xampp\htdocs\`).

4.  **Database Setup:**
    * Open your browser and go to `http://localhost/phpmyadmin`.
    * Create a new database and name it **`roadside_rescue`**.
    * Select the `roadside_rescue` database and go to the **Import** tab.
    * Click "Choose File" and select the `roadside_rescue.sql` file included in this project.
    * Click "Import".

5.  **Create `db_connect.php` (CRITICAL):**
    * This file is **intentionally** not on GitHub for security. You must create it yourself.
    * Go into the `api/` folder.
    * Create a new file and name it `db_connect.php`.
    * Paste the following code into it:

    ```php
    <?php
    // Database configuration
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', ''); // Your XAMPP password (usually empty)
    define('DB_NAME', 'roadside_rescue');

    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Create connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Set charset to utf8mb4
    $conn->set_charset("utf8mb4");
    ?>
    ```

6.  **Run the Project:**
    * You are all set! Open your browser and go to:
    * **`http://localhost/roadside-rescue/register.php`**

### 🔑 Default Logins

* **Admin:**
    * **Email:** `admin@roadsiderescue.com`
    * **Password:** `password`
* **Sample User:**
    * **Email:** `rahul@example.com`
    * **Password:** `user123`
