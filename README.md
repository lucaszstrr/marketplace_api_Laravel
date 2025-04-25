# 🛒 Marketplace API - Laravel

A complete e-commerce platform API built with Laravel featuring user management, products, shopping cart, orders, and discount coupons.

## ✨ Key Features
JWT Authentication with multi-level access (Admin, Moderator, Customer) <br />

User Management(admin-only) <br />

Address System linked to user accounts <br />

Product Inventory with stock control <br />

Shopping Cart with automatic stock reservation <br />

Order Processing with complete workflow <br />

Discount Coupons (admin-only) <br />

Product Categories <br />

## 🛠️ Tech Stack
PHP 8.1+ <br />

Laravel 10 <br />

MySQL 5.7+ <br />

Composer 2.8.6 <br />

JWT Authentication <br />

Eloquent ORM <br />

RESTful API <br />

##  🚀 Installation
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


## 🔐 Roles and Permissions
Role	       |      Permissions <br />
Admin	       |  Full system access <br />
Moderator	 |  Manage products and categories <br />
Customer	    |  Basic shopping operations <br />



## 🌟 Unique Features
✅ Automatic Stock Reservation - Items added to cart immediately reserve inventory <br />

✅ Granular Access Control - Detailed permission hierarchy <br />

✅ Coupon System - Create and apply discount codes <br />

✅ Real-time Inventory - Stock updates during cart operations <br /> 

✅ Zip Code - validates whether the zip is real or not <br />


