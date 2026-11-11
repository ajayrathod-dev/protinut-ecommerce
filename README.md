# Protinut - Health & Nutrition Supplement E-Commerce Platform

[![PHP Version](https://img.shields.io/badge/PHP-8.x-blue.svg)](https://www.php.net/)
[![Database](https://img.shields.io/badge/MySQL-5.7%2B%20%7C%208.0%2B-orange.svg)](https://www.mysql.com/)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

**Protinut** is a full-featured, responsive E-Commerce web application tailored for nutrition products, fitness supplements, and wellness essentials. Built with PHP and MySQL, it offers a seamless shopping experience for customers and a comprehensive administrative dashboard for managing products, orders, blogs, inquiries, and site configuration.

---

## 🌟 Features

### 🛍️ Customer Storefront
- **Modern Responsive Design**: Mobile-first UI styled with Bootstrap, custom animations, and interactive sliders (Swiper).
- **Product Catalog & Detail View**: Browse fitness and health supplements, view specifications, prices, and sale discounts.
- **Cart & Checkout**: Dynamic shopping cart management with instant total calculation.
- **Payment Options**: Supports Cash on Delivery (COD) and manual payment tracking with UTR / Transaction Reference verification.
- **User Authentication & Profiles**: Registration, secure login, profile information, and password management.
- **Order Tracking & Digital Receipts**: Customers can track order status (Pending, Processing, Shipped, Delivered) and download/print order receipts.
- **Interactive Blog & Community**: Article reader with category filtering, comment section, and like interactions.
- **Contact & Inquiries**: Integrated contact forms with customer support channels.

### 🛡️ Administrative Panel (`/admin`)
- **Dashboard Overview**: Metrics on orders, products, users, and inquiries.
- **Product Management**: Add, update, view, or remove products and product media.
- **Order Fulfillment**: Track real-time customer orders, update order status, verify payment proofs/UTR references.
- **Blog & Content Control**: Publish new blog posts, manage media types (images/videos), and curate comments.
- **User Management**: Overview of registered customer accounts.
- **Dynamic Site Customization**: Manage hero banners, promotional texts, call-to-actions, and site settings directly from the dashboard.

---

## 🛠️ Tech Stack

- **Backend**: PHP 8.x (MySQLi & PDO)
- **Database**: MySQL / MariaDB (automatic database and schema provisioning)
- **Frontend**: HTML5, CSS3, JavaScript (ES6+), Bootstrap, jQuery, FontAwesome, Swiper.js, Magnific Popup
- **Environment**: Apache / XAMPP / WAMP / LAMP

---

## 🚀 Quick Start Guide

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) or any local web server with PHP 8.0+ and MySQL.
- Git installed on your system.

### 1. Clone the Repository
Clone this project into your web server's root directory (e.g., `htdocs` for XAMPP):
```bash
cd C:/xampp/htdocs
git clone https://github.com/<your-username>/protinut-ecommerce.git Protinut
```

### 2. Configure Database
By default, the application automatically creates the database (`protinut_db`) and all necessary tables upon first page load!

If your MySQL credentials differ from XAMPP defaults, update `connection.php` and `db.php`:
```php
$host = 'localhost';
$dbname = 'protinut_db';
$db_username = 'root'; // Your DB username
$db_password = '';     // Your DB password
```

### 3. Launch the Application
1. Start **Apache** and **MySQL** in your XAMPP Control Panel.
2. Open your browser and navigate to:
   - **Storefront**: `http://localhost/Protinut/`
   - **Admin Panel**: `http://localhost/Protinut/admin/`

---

## 🔐 Default Admin Credentials

When the database initializes for the first time, default administrative credentials are automatically seeded:
- **Username**: `admin`
- **Password**: `admin123`

> ⚠️ *Note: Make sure to change your admin credentials in production environments.*

---

## 📂 Project Structure

```text
Protinut/
├── admin/                  # Administrative management panel
│   ├── assets/             # Admin CSS, JS, and vendor libraries
│   ├── blogs.php           # Blog management
│   ├── orders.php          # Order fulfillment & status updates
│   ├── products.php        # Inventory & catalog management
│   ├── settings.php        # Hero banner & site configuration
│   └── index.php           # Admin dashboard
├── assets/                 # Storefront assets (CSS, JS, Fonts, Images)
├── connection.php          # Centralized database connection & migration engine
├── db.php                  # Secondary PDO database helper
├── index.php               # Storefront homepage
├── shop.php                # Product catalog & listings
├── cart.php                # Cart management
├── checkout.php            # Order checkout & payment entry
├── my_orders.php           # Customer order history
├── receipt.php             # Printable order confirmation/receipt
└── README.md               # Project documentation
```

---

## 📄 License
This project is open-source and available under the [MIT License](LICENSE).
