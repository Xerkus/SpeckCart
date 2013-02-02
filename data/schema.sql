CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `created_time` datetime DEFAULT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `cart_line` (
  `line_id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,5) DEFAULT NULL,
  `tax` decimal(15,5) DEFAULT NULL,
  `added_time` datetime DEFAULT NULL,
  `parent_line_id` int(11) DEFAULT 0,
  `item_name` varchar(255) DEFAULT NULL
  `item_description` text DEFAULT NULL,
  `item_metadata` blob,
  PRIMARY KEY (`line_id`),
  KEY `cart_id` (`cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `cart_line`
  ADD CONSTRAINT `cart_line_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`);
