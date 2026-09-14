CREATE DATABASE IF NOT EXISTS adelaide_bakery;

USE adelaide_bakery;


-- Products table
CREATE TABLE IF NOT EXISTS products (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL,

    description TEXT NOT NULL,

    price DECIMAL(10,2) NOT NULL,

    image VARCHAR(255) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);


-- Orders table
CREATE TABLE IF NOT EXISTS orders (

    id INT AUTO_INCREMENT PRIMARY KEY,

    customer_name VARCHAR(100) NOT NULL,

    email VARCHAR(150) NOT NULL,

    product VARCHAR(100) NOT NULL,

    quantity INT NOT NULL,

    message TEXT,

    status VARCHAR(20) NOT NULL DEFAULT 'Pending',

    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);