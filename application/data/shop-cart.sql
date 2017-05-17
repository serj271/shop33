SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
use 'shop33';

DROP TABLE IF EXISTS `shopping_cart`;
CREATE TABLE `shopping_cart` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`cart_id` CHAR(32) NOT NULL,
	`product_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`attributes` VARCHAR(1000) NOT NULL DEFAULT 'a',
	`quantity` INT NOT NULL,
	`buy_now` BOOL NOT NULL DEFAULT true,
	`added_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	KEY `product_id` (`product_id`),
	KEY `idx_shopping_cart_cart_id` (`cart_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;



ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `catalog_basket_list_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ;



 
DROP PROCEDURE IF EXISTS  shopping_cart_add_product;
delimiter //
CREATE PROCEDURE shopping_cart_add_product(IN inCartId CHAR(32), IN inProductId INT, IN inAttributes VARCHAR(1000))
BEGIN
	DECLARE productQuantity INT;
	-- Obtain current shopping cart quantity for the product
	SELECT quantity	FROM shopping_cart	WHERE cart_id = inCartId AND product_id = inProductId AND attributes = inAttributes	INTO productQuantity;
	-- Create new shopping cart record, or increase quantity of existing record
	IF (productQuantity IS NULL) THEN
		INSERT INTO shopping_cart(cart_id, product_id, attributes, quantity, added_on) VALUES (inCartId, inProductId, inAttributes, 1, NOW());
	ELSE
		UPDATE shopping_cart SET quantity = quantity + 1, buy_now = true WHERE cart_id = inCartId AND product_id = inProductId	AND attributes = inAttributes;
	END IF;
	SELECT * FROM shopping_cart	WHERE cart_id = inCartId;
END 
//
delimiter ;

GRANT EXECUTE ON PROCEDURE shop33.shopping_cart_add_product TO 'user_db'@'localhost';

DROP PROCEDURE IF EXISTS  shopping_cart_remove_product;
delimiter //
CREATE PROCEDURE shopping_cart_remove_product(IN inItemId INT)
BEGIN
	DELETE FROM shopping_cart WHERE item_id = inItemId;
END
//
delimiter ;
GRANT EXECUTE ON PROCEDURE shop33.shopping_cart_remove_product TO 'user_db'@'localhost';

DROP PROCEDURE IF EXISTS  shopping_cart_update;
delimiter //
-- Create shopping_cart_update_product stored procedure
CREATE PROCEDURE shopping_cart_update(IN inItemId INT, IN inQuantity INT)
BEGIN
	IF inQuantity > 0 THEN
		UPDATE shopping_cart SET quantity = inQuantity, added_on = NOW() WHERE item_id = inItemId;
	ELSE
		CALL shopping_cart_remove_product(inItemId);
	END IF;
END
//
delimiter ;
GRANT EXECUTE ON PROCEDURE shop33.shopping_cart_update TO 'user_db'@'localhost';
/* GRANT EXECUTE ON FUNCTION shop33.* TO 'user_db'@'localhost'; */