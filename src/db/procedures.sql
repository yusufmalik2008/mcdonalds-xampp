USE mcd_orders;
DELIMITER //

CREATE PROCEDURE GetMenuItems()
BEGIN
    SELECT mi.id, mi.name, mi.description, mi.price, mi.image_url, c.name AS category
    FROM menu_items mi
    LEFT JOIN categories c ON mi.category_id = c.id
    ORDER BY c.name, mi.name;
END //

CREATE PROCEDURE CreateUser(IN p_username VARCHAR(50), IN p_password VARCHAR(255), IN p_email VARCHAR(100))
BEGIN
    INSERT INTO users (username, password, email) VALUES (p_username, p_password, p_email);
END //

CREATE PROCEDURE PlaceOrder(IN p_user_id INT, IN p_total DECIMAL(10,2), OUT p_order_id INT)
BEGIN
    START TRANSACTION;
    INSERT INTO orders (user_id, total) VALUES (p_user_id, p_total);
    SET p_order_id = LAST_INSERT_ID();
    COMMIT;
END //

CREATE PROCEDURE AddOrderItem(IN p_order_id INT, IN p_menu_item_id INT, IN p_quantity INT, IN p_price DECIMAL(8,2))
BEGIN
    INSERT INTO order_items (order_id, menu_item_id, quantity, price)
    VALUES (p_order_id, p_menu_item_id, p_quantity, p_price);
END //

CREATE PROCEDURE GetUserOrders(IN p_user_id INT)
BEGIN
    SELECT o.id, o.total, o.status, o.created_at,
           oi.quantity, mi.name AS item_name, oi.price
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN menu_items mi ON oi.menu_item_id = mi.id
    WHERE o.user_id = p_user_id
    ORDER BY o.created_at DESC;
END //

DELIMITER ;