# ISUFST Employee Record Tracking System

> **Web Systems Technologies &mdash; Final Project**  
> **Course:** PHP and MySQL Development  
> **Instructor:** Sir Kenth Joshua Espina ([kenthjoshuaespina@isufst.edu.ph](mailto:kenthjoshuaespina@isufst.edu.ph))  
> **Institution:** Iloilo State University of Fisheries Science and Technology (ISUFST)  
> **Frameworks:** PHP, MySQL / MariaDB, Bootstrap 5.3.3, HTML5, CSS3  
> **Hosting Platform:** InfinityFree (Free Hosting Deployment)  

---

## 1. Project Overview

A clean, responsive, and straightforward **Employee Record Tracking System** developed with PHP and MySQL. This application covers all core CRUD operations (Create, Read, Update, Delete), satisfies the database rubric (11 fields in table), and uses Bootstrap 5 for a responsive interface.

---

## 2. File Structure

The project has been simplified into essential, self-contained files:

```
EmployeeRecordTracking/
├── css/
│   └── style.css         # Custom CSS styling (badges, mobile responsiveness, cards)
├── js/
│   └── script.js         # Custom JS (instant live table filter, dynamic salary preview)
├── index.php             # READ: Dashboard, KPI counters, Search & Employee Table
├── add_employee.php      # CREATE: Form to add a new employee (INSERT)
├── edit_employee.php     # UPDATE: Form to modify existing employee records
├── delete_employee.php   # DELETE: Removes an employee record
├── db_connect.php        # Database PDO connection (Local XAMPP & InfinityFree)
├── database.sql          # SQL table schema (clean & ready for your records)
└── README.md             # Project documentation and deployment guide
```

---

## 3. CRUD Operations Breakdown

| Operation | Script File | Description |
| :--- | :--- | :--- |
| **CREATE (INSERT)** | `add_employee.php` | Adds a new employee record with form validation and duplicate check. |
| **READ (SELECT)** | `index.php` | Displays employee records in a responsive Bootstrap table with search and department filtering. |
| **UPDATE (UPDATE)** | `edit_employee.php` | Loads existing employee data into the form and updates the database record. |
| **DELETE (DELETE)** | `delete_employee.php` | Deletes the specified employee record with a JavaScript confirmation dialog. |

---

## 4. Database Design (`database.sql`)

The database `employee_tracker_db` contains an `employees` table with **11 fields**:

* `id` &mdash; INT, Primary Key, Auto Increment
* `employee_id` &mdash; VARCHAR(20), Unique identifier (e.g., `EMP-2024-001`)
* `first_name` &mdash; VARCHAR(50)
* `last_name` &mdash; VARCHAR(50)
* `email` &mdash; VARCHAR(100), Unique
* `phone` &mdash; VARCHAR(25)
* `department` &mdash; VARCHAR(50)
* `position` &mdash; VARCHAR(50)
* `salary` &mdash; DECIMAL(10,2)
* `hire_date` &mdash; DATE
* `status` &mdash; ENUM (`Active`, `On Leave`, `Probationary`, `Resigned`)
* `created_at` &mdash; TIMESTAMP

---

## 5. Local Setup Instructions (XAMPP)

1. Open **XAMPP Control Panel** and click **Start** on **Apache** and **MySQL**.
2. Open your browser and go to `http://localhost/phpmyadmin`.
3. Create a new database named `employee_tracker_db`.
4. Click **Import**, choose `database.sql` from this folder, and click **Import**.
5. Copy or clone this folder into `C:\xampp\htdocs\EmployeeRecordTracking`.
6. Open your browser to:
   ```
   http://localhost/EmployeeRecordTracking/index.php
   ```

---

## 6. InfinityFree Deployment Steps

1. Go to [https://www.infinityfree.net](https://www.infinityfree.net) and log in.
2. In the **Client Area**, create a free hosting account.
3. In the Control Panel, go to **MySQL Databases** and create a new database.
4. Note your InfinityFree credentials:
   * **Host:** `sqlXXX.epizy.com`
   * **Username:** `if0_XXXXXXXX`
   * **Password:** *(Your InfinityFree account password)*
   * **Database:** `if0_XXXXXXXX_employee_tracker_db`
5. Open `db_connect.php` and paste these 4 values in the InfinityFree section (lines 40-44).
6. In InfinityFree Control Panel &rarr; **File Manager**, upload all project files directly into the **`htdocs/`** directory.
7. Open **phpMyAdmin** in InfinityFree and import `database.sql`.
8. Access your live website URL (e.g. `https://yourname.epizy.com`).

---

## 7. Presentation Guide (5-7 Minutes)

* **Minute 1: Introduction** &mdash; Introduce yourself, project title, and state that the system is built with PHP 8, MySQL, and Bootstrap 5.
* **Minute 2: Database Structure** &mdash; Show the `employees` table in phpMyAdmin with 11 fields, primary key, and your inserted records.
* **Minute 3-4: Live CRUD Demonstration** &mdash;
  * **CREATE**: Add a new employee in `add_employee.php`.
  * **READ**: Show the table and test the search bar filter in `index.php`.
  * **UPDATE**: Edit an employee's salary and status in `edit_employee.php`.
  * **DELETE**: Delete a record with the confirmation popup.
* **Minute 5: Deployment** &mdash; Show the live deployed project running on InfinityFree.
