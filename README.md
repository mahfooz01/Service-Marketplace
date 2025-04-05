# Service-Marketplace
# 🛠️ Service Marketplace Web App (PHP + MySQL)

A lightweight and functional **Service Marketplace** built using **PHP**, **MySQL**, and **external CSS only** (no JavaScript). This application allows service providers to list their offerings and consumers to browse and hire as per their needs.

---

## 📌 Features

- 🔐 User Registration & Login (for both Providers and Consumers)
- 👨‍🔧 Service Providers can:
  - Add service details
  - Set fair pricing
  - Upload service images
  - Specify their city/location
- 👥 Consumers can:
  - View service listings in a stylish grid
  - Hire service providers
  - View their hire history
- 🗃️ Separate dashboards for providers and consumers
- 🔒 Passwords are securely hashed
- 🧾 Hire history tracking system

---

## 📁 Folder Structure

service_marketplace/
│
├── css/
│   └── style.css
├── uploads/
│   └── (user-uploaded images)
├── db.php
├── header.php / footer.php
├── index.php
├── register.php / login.php / logout.php
├── dashboard.php
├── hire.php
├── hire_history.php
├── setup.sql
