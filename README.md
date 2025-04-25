# 🛒 Marketplace API - Laravel

A complete e-commerce platform API built with Laravel featuring user management, products, shopping cart, orders, and discount coupons.

##✨ Key Features
JWT Authentication with multi-level access (Admin, Moderator, Customer)
User Management(admin-only)
Address System linked to user accounts
Product Inventory with stock control
Shopping Cart with automatic stock reservation
Order Processing with complete workflow
Discount Coupons (admin-only)
Product Categories

##🛠️ Tech Stack
PHP 8.1+
Laravel 10
MySQL 5.7+
Composer 2.8.6
JWT Authentication
Eloquent ORM
RESTful API

##🚀 Installation
1. ***Clone the repository:**
   git clone https://github.com/lucaszstrr/motorcycleShopLaravel.git

2. **Create the `.env` file:**  
   Copy the contents of the `.env.example` file into a new `.env` file inside the `/src` folder.

3. **Open the terminal inside the Docker container:**  
   Run the following command to access the container terminal:
   
   ```bash
   docker compose exec --user 1000:1000 php sh
   ```
   
4. **Install dependencies:**  
   Inside the Docker terminal, run the following command to install dependencies:
   
   ```bash
   composer update
   ```

5. **Generate the application key:**  
   Still inside the Docker terminal, run:
   
   ```bash
   php artisan key:generate
   ```

6. **Run the migrations:**  
   In the same terminal, run:
   
   ```bash
   php artisan migrate
   ```


##🔐 Roles and Permissions
Role	       |      Permissions
Admin	       |  Full system access
Moderator	 |  Manage products and categories
Customer	    |  Basic shopping operations



##🌟 Unique Features
✅ Automatic Stock Reservation - Items added to cart immediately reserve inventory

✅ Granular Access Control - Detailed permission hierarchy

✅ Coupon System - Create and apply discount codes

✅ Real-time Inventory - Stock updates during cart operations

✅ Zip Code - validates whether the zip is real or not


