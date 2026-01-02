CREATE DATABASE IF NOT EXISTS mcd_orders CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mcd_orders;

DROP TABLE IF EXISTS order_items;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS menu_items;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('customer', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT
);

CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(8,2) NOT NULL,
    category_id INT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('pending','processing','completed','cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(8,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE CASCADE
);

-- Sample data
INSERT INTO categories (name, description) VALUES
('Burgers', 'Classic burgers'),
('Sides', 'Fries & more'),
('Drinks', 'Cold beverages'),
('Desserts', 'Sweet treats');

INSERT INTO menu_items (name, description, price, category_id, image_url) VALUES
('Big Mac', 'Two all-beef patties, special sauce...', 6.99, 1, 'bigmac.jpg'),
('Cheeseburger', 'Classic cheeseburger', 3.49, 1, 'cheeseburger.jpg'),
('French Fries', 'World famous fries', 2.99, 2, 'fries.jpg'),
('McChicken', 'Crispy chicken sandwich', 4.99, 1, 'mcchicken.jpg'),
('Coca-Cola', 'Ice cold Coke', 2.29, 3, 'coke.jpg'),
('Apple Pie', 'Warm apple pie', 1.99, 4, 'applepie.jpg');

-- Default admin (password: admin123)
INSERT INTO users (username, password, email, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@mcd.com', 'admin');