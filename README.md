# Warung Madura Management System (WIP)

A comprehensive Point of Sale (POS), Inventory, and Supply Chain Management System tailored for traditional retail stores ("Warung Madura"). Built with modern web technologies, this system is designed to handle everyday transactions efficiently while tracking stock, distributors, and overall sales performance.

## 🚀 Features

- **Authentication & Authorization**: Secure login, registration, and role-based access control (Admin, Manager, Cashier).
- **Interactive Dashboard**: Overview of store performance, latest sales, and stock alerts.
- **Inventory Management (Products)**: Full CRUD operations for products, including stock tracking, pricing, and categorizations.
- **Point of Sale (Sales & Sale Details)**: Fast and intuitive cashier interface for recording daily transactions.
- **Sales Reporting**: Detailed analytical views and historical reports for store managers to monitor revenue.
- **Supply Chain Management**:
  - **Distributors**: Manage supplier data and connections.
  - **Purchases & Orders**: Track restocking and procurement from distributors.
  - **Expedition & Deliveries**: Monitor incoming and outgoing stock shipments.
- **User Management**: Add and manage store employee accounts and permissions.

## 🛠️ Tech Stack

- **Backend**: Laravel 12.x (PHP 8.2+)
- **Frontend**: Blade Templates, Tailwind CSS v4.0.0
- **Build Tool**: Vite v7
- **Database**: SQLite / MySQL / PostgreSQL (Configurable via Eloquent ORM)

## 📋 Requirements

Before you begin, ensure you have the following installed on your local machine:
- PHP >= 8.2
- Composer
- Node.js & npm (for frontend assets)
- Appropriate Database Server (if not using SQLite)

## ⚙️ Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd warung_madura
   ```

2. **Install PHP Dependencies:**
   ```bash
   composer install
   ```

3. **Install JavaScript Dependencies:**
   ```bash
   npm install
   ```

4. **Environment Configuration:**
   Copy the example `.env` file and generate an application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Setup:**
   Configure your database credentials in the `.env` file. If you are using SQLite, create the database file:
   ```bash
   touch database/database.sqlite
   ```
   Then, run the migrations and seeders (if applicable):
   ```bash
   php artisan migrate --seed
   ```

## 🏃‍♂️ Running the Application

You can use the built-in Laravel development server along with Vite:

```bash
# Terminal 1: Starts the Laravel local development server
php artisan serve

# Terminal 2: Starts the Vite development server for hot module replacement
npm run dev
```

Alternatively, you can use the predefined Composer script that runs everything concurrently:
```bash
composer run dev
```

Visit `http://localhost:8000` in your browser to access the application.

## 📁 Key File Structure

- `/app/Http/Controllers`: Contains the application logic for Dashboard, Auth, Products, Sales, Distributors, etc.
- `/app/Models`: Eloquent models mapping to the database tables (Product, Sale, User, Distributor, Delivery, etc.).
- `/resources/views`: Blade templates rendering the frontend UI with Tailwind CSS.
- `/routes`: Application routing definitions (`web.php` for primary browser routes).

## 📝 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). This project inherits or uses the same provided framework skeleton.
