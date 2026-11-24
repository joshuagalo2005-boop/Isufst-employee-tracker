# 🏢 ISUFST Employee Record Tracking System

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/MySQL-8.x%20%2F%20MariaDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Bootstrap-5.3.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap 5" />
  <img src="https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript" />
  <img src="https://img.shields.io/badge/Status-Complete-success?style=for-the-badge" alt="Status" />
</p>

---

> **Academic Coursework &mdash; Final Term Project**  
> **Course:** Web Systems Technologies (PHP and MySQL Web Application)  
> **Institution:** Iloilo State University of Fisheries Science and Technology (ISUFST)  
> **Instructor:** Sir Kenth Joshua Espina ([kenthjoshuaespina@isufst.edu.ph](mailto:kenthjoshuaespina@isufst.edu.ph))  
> **Student Developer:** Joshua Galo ([@joshuagalo2005-boop](https://github.com/joshuagalo2005-boop))  
> **Repository:** [https://github.com/joshuagalo2005-boop/Isufst-employee-tracker](https://github.com/joshuagalo2005-boop/Isufst-employee-tracker)

---

## 📋 Table of Contents
- [Project Overview](#-project-overview)
- [Key Features](#-key-features)
- [System Architecture & Tech Stack](#-system-architecture--tech-stack)
- [Database Schema (11 Fields)](#-database-schema-11-fields)
- [CRUD Operations Breakdown](#-crud-operations-breakdown)
- [Directory Structure](#-directory-structure)
- [Local Installation & Setup (XAMPP)](#-local-installation--setup-xampp)
- [Live Hosting Deployment (InfinityFree)](#-live-hosting-deployment-infinityfree)
- [Security & Best Practices](#-security--best-practices)
- [Rubric Compliance Checklist](#-rubric-compliance-checklist)
- [Oral Presentation Guide](#-oral-presentation-guide)

---

## 🌟 Project Overview

The **ISUFST Employee Record Tracking System** is a lightweight, responsive, and robust Human Resources information portal engineered for educational and institutional human resource management. 

Developed specifically for the **Web Systems Technologies** course at **ISUFST**, this project demonstrates complete mastery over the database lifecycle: **Create (INSERT)**, **Read (SELECT)**, **Update (UPDATE)**, and **Delete (DELETE)** using PHP Data Objects (PDO) and MariaDB/MySQL, paired with a modern Bootstrap 5 user interface enhanced with custom JavaScript and CSS animations.

---

## ✨ Key Features

- **📊 Comprehensive KPI Metrics Dashboard:** Instant overview cards presenting total personnel headcount, active workforce, department counts, and monthly payroll expenditure.
- **⚡ Instant Real-Time Search & Filtering:** Client-side JavaScript filtering that searches across employee names, designations, and IDs without full-page reloads.
- **🏷️ Department Category Filter:** Quickly isolate records by academic and administrative units (IT, HR, Finance, Faculty, Administration).
- **🛡️ Duplicate Prevention & Form Validation:** Server-side checks ensure duplicate Employee IDs and email addresses cannot be recorded.
- **💰 Live Annual Compensation Calculator:** Client-side JavaScript (`Intl.NumberFormat`) calculates and previews projected annual salary as the user enters monthly compensation.
- **📱 Fully Responsive UI:** Optimized for desktop monitors, tablets, and smartphones using Bootstrap 5 grid utilities and custom mobile CSS touch targets.
- **🌐 Dual-Environment Database Adapter:** Automatically detects whether it is running on a local XAMPP Apache development server or an online cloud hosting environment (InfinityFree), switching PDO credentials dynamically.

---

## 🛠️ System Architecture & Tech Stack

| Component | Technology | Purpose |
| :--- | :--- | :--- |
| **Backend Language** | PHP 8.x | Server-side routing, database queries, and session validation |
| **Database Engine** | MySQL / MariaDB | Relational storage for employee records with indexing |
| **Database Access** | PDO (PHP Data Objects) | Secure database abstraction layer with Prepared Statements |
| **Frontend Framework** | Bootstrap 5.3.3 | Responsive CSS grid, modal dialogs, and navigation cards |
| **Iconography** | Bootstrap Icons 1.11.3 | Semantic visual indicators across cards and action buttons |
| **Client Scripting** | JavaScript (ES6+) | Live search filtering, dynamic salary preview, alert dismissals |
| **Custom Styling** | CSS3 | Status badge pill highlights, subtle hover animations, mobile styling |
| **Deployment** | InfinityFree / Apache | Cloud web server and phpMyAdmin MySQL administration |

---

## 🗄️ Database Schema (11 Fields)

The application utilizes a clean, normalized relational table structure named `employees` inside the `employee_tracker_db` database, fulfilling all institutional rubric requirements:

| # | Field Name | Data Type | Key / Constraints | Description |
| :-: | :--- | :--- | :--- | :--- |
| **1** | `id` | `INT` | `PRIMARY KEY`, `AUTO_INCREMENT` | System internal unique sequential identifier |
| **2** | `employee_id` | `VARCHAR(20)` | `UNIQUE`, `NOT NULL` | Formal organizational ID (e.g., `EMP-2024-001`) |
| **3** | `first_name` | `VARCHAR(50)` | `NOT NULL` | Employee's legal given name |
| **4** | `last_name` | `VARCHAR(50)` | `NOT NULL` | Employee's family name / surname |
| **5** | `email` | `VARCHAR(100)`| `UNIQUE`, `NOT NULL` | Primary corporate communication email |
| **6** | `phone` | `VARCHAR(25)` | `NOT NULL` | Contact telephone or mobile number |
| **7** | `department` | `VARCHAR(50)` | `NOT NULL` | Assigned division (IT, HR, Finance, Faculty, etc.) |
| **8** | `position` | `VARCHAR(50)` | `NOT NULL` | Job role or academic designation |
| **9** | `salary` | `DECIMAL(10,2)`| `NOT NULL` | Monthly basic salary compensation in PHP (₱) |
| **10**| `hire_date` | `DATE` | `NOT NULL` | Official date of appointment / induction |
| **11**| `status` | `ENUM(...)` | `DEFAULT 'Active'` | Employment state: `Active`, `On Leave`, `Probationary`, `Resigned` |
| *—* | `created_at` | `TIMESTAMP` | `DEFAULT CURRENT_TIMESTAMP` | Audit log record creation timestamp |

---

## 🔄 CRUD Operations Breakdown

| Operation | Script File | HTTP Method | Implementation Details |
| :--- | :--- | :---: | :--- |
| **CREATE** | `add_employee.php` | `POST` | Validates required fields, checks for duplicate `employee_id` and `email`, executes parameterized `INSERT INTO employees`, and redirects with feedback toast. |
| **READ** | `index.php` | `GET` | Executes parameterized `SELECT * FROM employees ORDER BY id DESC`, calculates summary KPIs, and populates the responsive data grid. |
| **UPDATE** | `edit_employee.php` | `GET` / `POST` | Loads specific employee details by `?id=X`, validates modified inputs (excluding current ID from uniqueness check), and executes `UPDATE employees SET ...`. |
| **DELETE** | `delete_employee.php` | `GET` | Receives target record ID, prompts client-side JavaScript confirmation, executes `DELETE FROM employees WHERE id = :id`, and redirects with deletion alert. |

---

## 📁 Directory Structure

```text
EmployeeRecordTracking/
├── css/
│   └── style.css                               # Custom status badges, mobile touch-targets & card styling
├── js/
│   └── script.js                               # Real-time search filter, dynamic salary preview & alert timeouts
├── add_employee.php                            # CREATE: Employee registration form with validation
├── database.sql                                # Clean database schema ready for local/cloud phpMyAdmin import
├── db_connect.php                              # Dual-environment PDO connection handler (Local XAMPP + InfinityFree)
├── delete_employee.php                         # DELETE: Record deletion processor with security validation
├── edit_employee.php                           # UPDATE: Employee modification form with pre-populated values
├── index.php                                   # READ: Primary dashboard, KPI counters, and data table
└── README.md                                   # Comprehensive project documentation
```

---

## 💻 Local Installation & Setup (XAMPP)

Follow these steps to run the project on your local machine:

### 1. Prerequisites
- **XAMPP** installed with **Apache** and **MySQL** modules.
- Web browser (Google Chrome, Microsoft Edge, Mozilla Firefox).

### 2. Clone the Repository
Open Command Prompt, PowerShell, or Git Bash and clone the repository directly into your XAMPP `htdocs` directory:
```bash
cd C:\xampp\htdocs
git clone https://github.com/joshuagalo2005-boop/Isufst-employee-tracker.git EmployeeRecordTracking
```

### 3. Database Configuration
1. Launch **XAMPP Control Panel** and click **Start** for both **Apache** and **MySQL**.
2. Open your web browser and navigate to:
   ```
   http://localhost/phpmyadmin
   ```
3. Click **New** in the left sidebar and create a database named:
   ```
   employee_tracker_db
   ```
4. Select the newly created database, navigate to the **Import** tab.
5. Click **Choose File**, select `database.sql` from the project directory, and click **Import**.

### 4. Run the Application
Open your browser and navigate to:
```
http://localhost/EmployeeRecordTracking/index.php
```

---

## ☁️ Live Hosting Deployment (InfinityFree)

This application is engineered for zero-friction deployment to free hosting environments such as **InfinityFree**:

1. **Sign in to InfinityFree:** Access the [InfinityFree Client Area](https://www.infinityfree.net/) and create a free hosting account.
2. **Create MySQL Database:**
   - In the InfinityFree Control Panel (cPanel), navigate to **MySQL Databases**.
   - Create a database (e.g., `if0_XXXXXXXX_employee_tracker_db`).
3. **Configure `db_connect.php`:**
   - Open `db_connect.php` and update the InfinityFree production credentials section (lines 40–44) with your database host, database name, username, and password.
4. **Upload Files:**
   - Launch the online **File Manager** in InfinityFree.
   - Navigate into the **`htdocs/`** root directory.
   - Upload all project files (`index.php`, `add_employee.php`, `edit_employee.php`, `delete_employee.php`, `db_connect.php`, `database.sql`, `css/`, `js/`).
5. **Import Schema in Cloud phpMyAdmin:**
   - In the InfinityFree Control Panel, click **phpMyAdmin** beside your database.
   - Click the **Import** tab, upload `database.sql`, and execute.
6. **Visit Live URL:** Access your live public domain (e.g., `https://yourdomain.epizy.com/index.php`).

---

## 🔒 Security & Best Practices

- **Prepared Statements (PDO):** Every dynamic SQL query employs parameterized placeholders (`:id`, `:employee_id`, etc.) to eliminate the risk of **SQL Injection (SQLi)** attacks.
- **XSS Mitigation:** All database strings rendered into HTML are scrubbed using `htmlspecialchars($str, ENT_QUOTES, 'UTF-8')`.
- **Database Connection Security:** PDO error mode is configured to `PDO::ERRMODE_EXCEPTION` wrapped inside robust `try-catch` blocks to protect internal database credentials from exposure.
- **Validation Layers:** Client-side HTML5 constraints paired with strict server-side validation to ensure data integrity.

---

## 🎯 Rubric Compliance Checklist

| Rubric Requirement | Status | Implementation Details |
| :--- | :---: | :--- |
| **Complete CRUD Functionality** | ✅ Pass | Full Create, Read, Update, and Delete workflows implemented |
| **Database Design (10+ fields)** | ✅ Pass | 11 relational fields with appropriate datatypes, primary key, and unique indices |
| **Responsive Web Design** | ✅ Pass | Mobile-first Bootstrap 5 grid layout with custom CSS enhancements |
| **User Experience & Clean UI** | ✅ Pass | Instant search, badge status pill indicators, animated KPI cards |
| **Secure Database Transactions** | ✅ Pass | 100% PDO prepared statements across all queries |
| **Deployment Readiness** | ✅ Pass | Dual-environment connection script supporting both local and live cloud hosting |
| **Comprehensive Documentation** | ✅ Pass | Complete repository technical documentation, deployment guides, and presentation outline |

---

## 🎙️ Oral Presentation Guide (5-7 Minutes)

When presenting this project to your instructor, use this structured outline:

- **Minute 1: Introduction & Architecture**
  - Greet the instructor: *"Good day, Sir Kenth Joshua Espina. Today I am presenting my Web Systems Technologies final project: the ISUFST Employee Record Tracking System."*
  - State the tech stack: PHP 8, MariaDB/MySQL, Bootstrap 5, JavaScript, and CSS.
- **Minute 2: Database Design**
  - Open phpMyAdmin and display the `employees` table schema.
  - Highlight the 11 database fields, primary key (`id`), and unique constraints (`employee_id`, `email`).
- **Minute 3–4: Live CRUD Demonstration**
  - **Create:** Click "Add New Employee", show the dynamic salary calculator preview, submit the form, and show the success alert.
  - **Read & Filter:** Demonstrate the real-time search filter and department dropdown on the dashboard.
  - **Update:** Edit an employee's salary and status, save changes, and verify the updated table row.
  - **Delete:** Click the delete button, show the confirmation dialog, and delete a test record.
- **Minute 5: Code Walkthrough & Security**
  - Open `db_connect.php` to explain the dual-mode PDO connection.
  - Highlight prepared statements in `add_employee.php` and `edit_employee.php` as proof of SQL injection protection.
- **Minute 6: Deployment & Conclusion**
  - Show the live deployed application running on InfinityFree.
  - Conclude and welcome any questions.

---

## 👤 Author & Acknowledgements

- **Developer:** **Joshua Galo**
- **GitHub:** [@joshuagalo2005-boop](https://github.com/joshuagalo2005-boop)
- **Institution:** [Iloilo State University of Fisheries Science and Technology (ISUFST)](https://isufst.edu.ph/)
- **Course Instructor:** Sir Kenth Joshua Espina ([kenthjoshuaespina@isufst.edu.ph](mailto:kenthjoshuaespina@isufst.edu.ph))

---
<p align="center">
  <sub>ISUFST Web Systems Technologies Final Project &bull; Academic Year 2024–2025</sub>
</p>
