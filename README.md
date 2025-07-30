
# 💼 Banking Management System

The **Banking Management System** is a full-stack web application developed using **PHP**, **MySQL**, **HTML**, **CSS**, and **JavaScript**. It simulates real-world banking functionalities such as account management, deposits, withdrawals, fund transfers, and transaction tracking, all through a simple and secure web interface.

---

## 🎯 Project Objective

To create a digital banking platform where both users and administrators can perform and manage banking operations efficiently. This project is suitable for academic use and as a base for more advanced banking systems.

---

## 🚀 Features

### 👤 User Side:
- ✅ Register and manage customer accounts
- 💰 Deposit and withdraw money
- 🔁 Transfer funds between accounts
- 📜 View detailed transaction history
- 🔎 Search/filter customer records

### 🛠️ Admin Side:
- 📋 View, add, and manage customer records
- 👁️ Monitor all transactions
- 🛑 Prevent invalid transfers (e.g., insufficient balance)
- 🧹 Delete or update customer data (if needed)

---

## 🖥️ Frontend

- Developed using **HTML**, **CSS**, and **JavaScript**
- Clean and responsive UI
- Form validations and alert messages
- Dynamic elements using JavaScript

---

## 🔧 Backend

- Developed in **PHP** (procedural style)
- **MySQL** database for storing customer and transaction data
- Secure query handling with error checks
- Includes validation for:
  - Non-negative transfers
  - Minimum balance requirements
  - Duplicate entries prevention

---

## 🔐 Security Measures

- Input validation (client-side and server-side)
- SQL injection prevention using proper escaping (`mysqli_real_escape_string`)
- Session management for restricting access (recommended enhancement)
- Error handling to avoid exposing sensitive system messages
- Separate config/database file to isolate credentials
- `dbconnect.php` secured with environment-specific settings (use `.env` in advanced versions)

---

## 🗃️ Database Structure

The project uses a MySQL database with the following core tables:

- **`customers`** – holds customer info like name, email, balance, etc.
- **`transactions`** – logs all money transfers and activities
- *(Optional)* **`admins`** – for login/authentication (can be added for security)

> A pre-configured SQL dump file (`banking.sql`) is included. Import this to set up the database easily.

---

## ⚙️ Installation & Setup Instructions

### 🔧 Prerequisites
- [XAMPP](https://www.apachefriends.org/) or [WAMP](https://www.wampserver.com/)
- PHP 7.x or 8.x
- MySQL
- Web browser (Chrome, Firefox, etc.)

### 📝 Setup Steps

1. **Download or Clone this Repository:**

   ```bash
   git clone https://github.com/your-username/Banking-Management-System.git
