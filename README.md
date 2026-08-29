# UnityDesignX — E-Commerce Furniture & Interactive 3D Room Studio

UnityDesignX is a full-stack PHP 8+ and MySQL 8+ web application combined with an interactive WebGL Three.js 3D Room Configurator for an interior design studio and e-commerce furniture platform.

---

## Overview

### Problem Solved
Traditional furniture e-commerce stores show flat, static images that make it difficult for customers to visualize how furniture fits, scales, and coordinates inside a real interior room before purchasing.

### Project Objective
UnityDesignX bridges e-commerce shopping with spatial room planning by providing a dynamic product catalog alongside an interactive 3D studio where users can configure room dimensions, swap wall paint and floor materials, place real catalog furniture to scale, customize finishes, and proceed directly to checkout.

### Target Audience
- Homeowners, interior designers, and architects seeking customizable luxury furniture.
- E-commerce customers who want to preview spatial arrangements before buying.

### High-Level Workflow
```text
Browser (HTML5/CSS3/Three.js)
       │
       ▼
Public Pages & 3D Configurator
       │
       ▼
REST API Layer (PHP Prepared Statements)
       │
       ▼
MySQL 8+ Database (Port 3307)
```

---

## Key Features

- **Authentication & Security Engine**: Password hashing using `password_hash()` (bcrypt), session regeneration, and role-based access control (Customer & Admin roles).
- **Admin 404 URL Masking**: Non-admin and unauthenticated visitors attempting to guess or access `/admin/*` routes are served an HTTP `404 Not Found` page to hide admin route existence.
- **Dynamic E-Commerce Catalog**: Database-driven product listing with category filtering, product detail views, real-time stock tracking, and pricing formatters.
- **Interactive 3D Room Configurator**: WebGL studio powered by Three.js featuring real-time room rendering (walls, floor, ceiling spotlight fixtures, baseboards), room dimension sliders (width, length, ceiling height), wall paint swatches, floor pattern materials (oak, marble, walnut, concrete, carpet, bamboo), drag-and-drop spatial placement, material finishes (wood, matte, metal, fabric), scale & 360° rotation controls, room layout presets (Bedroom, Living Room, Lounge, Dining Area, Home Office), and high-resolution PNG design exporting.
- **Cart & Multi-Step Checkout Wizard**: AJAX shopping cart with session persistence, quantity adjustments, stock availability validation, delivery address inputs, payment method selection (COD, UPI, Card), and atomic DB transactions for order placement (`orders` + `order_items`).
- **Customer Order History**: "My Orders" interface displaying order history, status pipeline badges (`pending`, `confirmed`, `shipped`, `delivered`, `cancelled`), and itemized breakdowns.
- **Contact Us & Email Notification Pipeline**: Contact form with AJAX submission, database storage in `contact_messages`, and HTML email dispatch with `Reply-To` header support.
- **Admin Control Panel**: Metrics dashboard (total revenue, order counts, product counts, customer count), product CRUD modal, and order fulfillment status editor.

---

## How It Works

```text
User / Customer
      │
      ▼
Public UI / 3D Configurator (HTML5, Vanilla CSS, Three.js WebGL)
      │
      ▼
Fetch API (JSON Payload + Session Headers)
      │
      ▼
API Endpoints / Controllers (PHP 8+)
      │
      ▼
Database Layer (PDO Singleton / MySQL 8+ on Port 3307)
      │
      ▼
JSON Response / State Update / Order DB Transaction
```

---

## Technology Stack

| Technology | Purpose |
| ---------- | ------- |
| **PHP 8+** | Modular backend processing, API endpoints, session management, and routing |
| **MySQL 8+ / MariaDB** | Relational database (Port `3307`, utf8mb4) storing users, products, categories, cart, orders, and messages |
| **Three.js (r128)** | WebGL 3D rendering engine for room geometry, lighting, shadows, raycasting, and furniture customizer |
| **JavaScript (ES6+)** | Dynamic DOM updates, WebGL scene logic, AJAX fetch requests, and state management |
| **Vanilla CSS3** | Custom design system, CSS grid/flexbox layouts, glassmorphism UI, and dark mode aesthetic |
| **FontAwesome 6.5** | Iconography throughout public pages, admin panel, and 3D Studio HUD |
| **PDO (PHP Data Objects)** | Prepared statement database interactions and atomic transactions |

---

## Project Structure

```text
InteriorDesign/
├── .agents/                    # Repository documentation system
│   ├── architecture.md
│   ├── database.md
│   ├── api.md
│   ├── ui-rules.md
│   └── progress.md
├── admin/                      # Admin Panel (Protected by require_admin() 404 guard)
│   ├── dashboard.php           # Analytics & metrics control center
│   ├── products.php            # Product catalog CRUD management
│   ├── orders.php              # Order fulfillment status pipeline
│   └── messages.php            # Customer contact inbox
├── api/                        # REST API Endpoints
│   ├── auth/                   # login.php, register.php, logout.php
│   ├── cart/                   # get.php, add.php, update.php, remove.php
│   ├── orders/                 # place.php, history.php
│   └── contact.php             # Contact inquiry submission handler
├── assets/                     # Static Web Assets
│   ├── css/
│   │   └── style.css           # Master CSS design system & tokens
│   └── images/                 # Product category & furniture asset images
├── config/                     # Configuration Constants & Handlers
│   ├── app.php                 # App constants, environment & SMTP settings
│   └── database.php            # PDO Singleton connection handler (Port 3307)
├── database/                   # SQL Database Scripts
│   ├── schema.sql              # Normalized DDL table schemas
│   ├── seed.sql                # Initial roles, users, categories, products
│   └── legacy_unity.sql        # Archived initial database dump
├── includes/                   # Shared Template Partials & Helper Utilities
│   ├── header.php              # Navigation header & cart badge
│   ├── footer.php              # Global footer template
│   └── functions.php           # Security helpers, sanitization, PDO helper
├── public/                     # User-Facing Web Pages
│   ├── index.php               # Dynamic homepage
│   ├── products.php            # Catalog page with search & category filters
│   ├── product-details.php     # Individual product detail view
│   ├── designs.php             # 3D Studio container page
│   ├── cart.php                # Shopping cart page
│   ├── checkout.php            # 4-Step checkout wizard
│   ├── orders.php              # Customer order history page
│   ├── contact.php             # Contact Us page
│   ├── login.php               # Customer login page
│   ├── register.php            # Customer registration page
│   └── logout.php              # Logout handler
├── threejs-raycasting-main/
│   └── src/
│       └── index.html          # WebGL 3D Room Configurator application
├── .env.example                # Safe environment variables template
├── .gitignore                  # Git ignore definitions
└── README.md                   # Project documentation
```

---

## Installation

### Prerequisites
- **Apache Web Server** (XAMPP / WAMP / Laragon / Nginx with PHP 8+)
- **PHP 8.0+**
- **MySQL 8.0+ / MariaDB** running on port **`3307`** (or configured port)

### Step-by-Step Setup

1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/InteriorDesign.git
   cd InteriorDesign
   ```

2. **Configure Environment Settings**
   Copy `.env.example` settings into your configuration if needed:
   Check `config/app.php` and verify connection parameters:
   - `DB_HOST`: `localhost`
   - `DB_PORT`: `3307`
   - `DB_NAME`: `unity`

3. **Import Database Schema & Seed Data**
   Create a database named `unity` on your MySQL server (Port 3307):
   ```bash
   mysql -u root -P 3307 -e "CREATE DATABASE IF NOT EXISTS unity;"
   mysql -u root -P 3307 unity < database/schema.sql
   mysql -u root -P 3307 unity < database/seed.sql
   ```

4. **Web Server Setup**
   Place the project folder inside your web server root (e.g. `C:\xampp\htdocs\InteriorDesign`).

5. **Access the Application**
   Open your browser and navigate to:
   - **Public Store**: `http://localhost/InteriorDesign/public/index.php`
   - **3D Room Configurator**: `http://localhost:8085/` or `http://localhost/InteriorDesign/public/designs.php`

---

## Environment Variables

The project uses configuration constants in `config/app.php` (sample template provided in `.env.example`):

```env
APP_NAME="UnityDesignX"
APP_TAGLINE="The Art of Fine Living"
APP_URL="http://localhost/InteriorDesign"
APP_DEBUG=true

DB_HOST="localhost"
DB_PORT="3307"
DB_NAME="unity"
DB_USER="root"
DB_PASS=""

ADMIN_EMAIL="admin@unitydesign.com"
SMTP_HOST="smtp.gmail.com"
SMTP_PORT=587
SMTP_USER="your-email@gmail.com"
SMTP_PASS="your-app-password"
SMTP_FROM="noreply@unitydesign.com"
ENABLE_EMAIL_NOTIFICATIONS=true
```

---

## Running the Project

1. Start Apache and MySQL services in XAMPP / WAMP.
2. Ensure MySQL is listening on port **`3307`** (or adjust `DB_PORT` in `config/app.php`).
3. Visit `http://localhost/InteriorDesign/public/index.php` in your browser.

---

## Credentials (For Testing)

| Role | Email | Password |
| --- | --- | --- |
| **Admin** | `admin@unitydesign.com` | `admin123` |
| **Customer** | `tester@gmail.com` | `Tester@123` |

---

## Current Status

### Completed
- [x] Project Audit & `.agents/` Architectural System Initialization
- [x] Normalized MySQL Database DDL & Seed Data Migration
- [x] Core PHP PDO Singleton Infrastructure & Helper Functions
- [x] Bcrypt Password Hashing Authentication Engine (`api/auth/*`)
- [x] Glassmorphism CSS Design System (`assets/css/style.css`)
- [x] Responsive E-Commerce Homepage & Dynamic Product Catalog
- [x] Session-Based Shopping Cart Engine (`api/cart/*`)
- [x] WebGL 3D Room Configurator Studio (Three.js with raycasting, wall/floor controls, catalog spawning, scale/rotation inspector, PNG exporting)
- [x] Multi-Step Checkout Wizard & Order DB Transaction Placement (`api/orders/place.php`)
- [x] Customer Order History Page (`public/orders.php`)
- [x] Admin Control Panel & 404 URL Protection Masking (`admin/*`)
- [x] Contact Us Page, DB Messaging & Email Dispatch Pipeline

### In Progress
- [ ] Automated PHPUnit API Integration Test Suite

### Planned
- [ ] Payment Gateway Integration (Razorpay / Stripe live API key hookup)
- [ ] Multi-Room Floor Plan Project Save & Load functionality

---

## Known Issues

- **Port Dependency**: MySQL must be running on port `3307` by default. If your local MySQL runs on port `3306`, update `DB_PORT` in `config/app.php`.

---

## Git Workflow

The repository follows a standard Git branching strategy:

```text
main (Production / Stable)
  ↑
development (Active Integration)
  ↑
feature/* (Feature Branches)
```

### Branch Usage Guidelines
- **`main`**: Production-ready code. Direct commits to `main` are disallowed.
- **`development`**: Integration branch for combining feature developments.
- **`feature/*`**: Isolated branches created for specific features or bug fixes.
  Examples:
  - `feature/login`
  - `feature/dashboard`
  - `feature/api`
  - `feature/database`

---

## Contributing

1. Fork the repository.
2. Create your feature branch (`git checkout -b feature/amazing-feature`).
3. Commit your changes (`git commit -m 'feat: Add amazing feature'`).
4. Push to the branch (`git push origin feature/amazing-feature`).
5. Open a Pull Request targeting the `development` branch.

---

## License

A software license has not yet been specified for this project. Please consult the author before commercial use or distribution.

---

## Author

**UnityDesignX Team**  
Interior Design & E-Commerce Web Platform Development
