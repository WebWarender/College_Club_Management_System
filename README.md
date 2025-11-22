# College_Club_Management_System
“A web-based College Club Management System that streamlines club registration, event management, member tracking, and announcements. Features role-based access for Admin, Club Heads, and Students, offering an organized and user-friendly platform to manage all club activities efficiently.”

# College Club Management System

## 📌 Overview
The **College Club Management System** is a web-based platform designed to streamline the management of college clubs. It simplifies tasks such as club registration, event scheduling, member tracking, and announcements by providing role-based access for Admins, Club Heads, and Students.

## 🚀 Features
- **Student Registration & Login**
- **Club Creation & Management**
- **Event Creation & Updates**
- **Member Management**
- **Admin Approval System**
- **Announcements & Notifications**
- **Role-Based Dashboards**

## 🛠️ Technologies Used
- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP / Node.js / Python (choose your stack)
- **Database:** MySQL / MongoDB
- **Server:** XAMPP / Localhost

## 📂 Project Structure
```
│   announcements.php
│   blog-detail.php
│   blogs.php
│   BLOGS_AND_EVENTS_GUIDE.md
│   club-details.php
│   clubs.php
│   COMPLETE_IMPLEMENTATION_STATUS.md
│   create-blog.php
│   events.php
│   FEATURES_OVERVIEW.md
│   IMAGES_GUIDE.md
│   IMPLEMENTATION_CHECKLIST.md
│   IMPLEMENTATION_SUMMARY.md
│   index.php
│   manage-clubs.php
│   profile.php
│   QUICK_START_BLOGS_EVENTS.md
│   README.md
│   VISUAL_USER_GUIDE.md
│
├───auth
│       login.php
│       logout.php
│       register.php
│
├───config
│       database.sql
│       db.php
│       insert-sample-data.sql
│
├───includes
│       footer.php
│       header.php
│       session.php
│
├───public
│   ├───css
│   │       style.css
│   │
│   ├───images
│   │       avatar-placeholder.svg
│   │       create-images.html
│   │       cultural-club.svg
│   │       debate-club.svg
│   │       environmental-club.svg
│   │       event-placeholder.svg
│   │       hero-bg.svg
│   │       photography-club.svg
│   │       README.md
│   │       sports-club.svg
│   │       tech-club.svg
│   │
│   └───js
│           main.js
│
└───views
```

## 🔧 Installation Guide
1. Clone the repository:
```
git clone https://github.com/your-username/college-club-management-system.git
```
2. Move project to **htdocs** (if using XAMPP).
3. Import database from `database.sql` into phpMyAdmin.
4. Update database credentials in config file.
5. Start Apache & MySQL in XAMPP.
6. Run the project in browser:
```
http://localhost/college-club-management-system/
```

## 👥 User Roles
### 🔹 Admin
- Approves clubs
- Manages users
- Posts announcements

### 🔹 Club Head
- Adds events
- Manages members

### 🔹 Student
- Joins clubs
- Views events & announcements

## 📄 License
This project is open-source. You may modify and use it for educational purposes.

---
💡 *Feel free to contribute or suggest improvements!*
