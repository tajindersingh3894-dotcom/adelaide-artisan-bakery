# Adelaide Artisan Bakery

## Project Overview

Adelaide Artisan Bakery is a PHP and MySQL web application developed for a bakery business scenario.

The website allows customers to view bakery products and submit an order enquiry. An administrator can log in and manage products using Create, Read, Update and Delete (CRUD) operations. Administrators can also view customer orders and update their order status.

## Technologies Used

- PHP
- MySQL
- HTML5
- CSS3
- XAMPP
- Apache
- MySQL/MariaDB
- Git

No external PHP framework is required.

## Main Features

### Public Website

- Bakery homepage
- Product catalogue
- Product images
- Responsive layout
- Customer order/enquiry form
- Server-side form validation
- Accessible form labels and error messages

### Admin Area

- Admin login
- Customer order management
- Order status updates
- Product management
- Add products
- View products
- Edit products
- Delete products

## Project Structure

```text
adelaide-artisan-bakery/
│
├── database/
│   └── schema.sql
│
├── css/
│   └── style.css
│
├── images/
│   ├── bread.jpg
│   ├── croissant.jpg
│   ├── cake.jpg
│   └── pastry.jpg
│
├── index.php
├── login.php
├── admin.php
├── products.php
├── add_product.php
├── edit_product.php
├── delete_product.php
├── order.php
├── db.php
├── .env.example
├── .gitignore
└── README.md