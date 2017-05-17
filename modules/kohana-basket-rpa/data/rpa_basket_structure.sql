CREATE TABLE `baskets` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `created_by` INT UNSIGNED NOT NULL,
  `updated_at` DATETIME NOT NULL,
  `updated_by`	INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `basket_items` (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
  `basket_id` INT UNSIGNED NOT NULL,
  `item_type` VARCHAR(100) NOT NULL,
  `item_identifier` VARCHAR(100) NOT NULL,
  `quantity` TINYINT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;