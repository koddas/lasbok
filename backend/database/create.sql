SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `176690-lasbok` DEFAULT CHARACTER SET utf8 COLLATE utf8_swedish_ci ;
USE `176690-lasbok` ;

-- -----------------------------------------------------
-- Table `176690-lasbok`.`Customers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Customers` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Customers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(64) NOT NULL ,
  `contact_name` VARCHAR(64) NULL ,
  `phone_number` VARCHAR(45) NOT NULL ,
  `e-mail` VARCHAR(256) NOT NULL ,
  `postal_address` VARCHAR(256) NOT NULL ,
  `invoicing_address` VARCHAR(256) NULL ,
  `comments` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
COMMENT = 'This table holds customer data';


-- -----------------------------------------------------
-- Table `176690-lasbok`.`Sites`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Sites` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Sites` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `has_automatic_locks` TINYINT(1) NOT NULL DEFAULT false ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
ENGINE = InnoDB
COMMENT = 'This table contains the rudimentary information about our fa' /* comment truncated */;


-- -----------------------------------------------------
-- Table `176690-lasbok`.`Facilities`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Facilities` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Facilities` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `Sites_id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  `description` TEXT NULL ,
  PRIMARY KEY (`id`, `Sites_id`) ,
  INDEX `fk_Facilities_Sites1` (`Sites_id` ASC) ,
  CONSTRAINT `fk_Facilities_Sites1`
    FOREIGN KEY (`Sites_id` )
    REFERENCES `176690-lasbok`.`Sites` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'This table contains information about facilities, e.g. certa' /* comment truncated */;


-- -----------------------------------------------------
-- Table `176690-lasbok`.`Partitions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Partitions` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Partitions` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `description` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
COMMENT = 'This table holds information regarding the physical properti' /* comment truncated */;


-- -----------------------------------------------------
-- Table `176690-lasbok`.`Customer_categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Customer_categories` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Customer_categories` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `description` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
COMMENT = 'This table contains information about the diffenent customer' /* comment truncated */;


-- -----------------------------------------------------
-- Table `176690-lasbok`.`Reservations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Reservations` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Reservations` (
  `id` INT NOT NULL ,
  `Customers_id` INT NOT NULL ,
  `Customer_categories_id` INT NOT NULL ,
  `Sites_id` INT NOT NULL ,
  `description` VARCHAR(45) NOT NULL ,
  `start_date` DATE NOT NULL ,
  `end_date` DATE NOT NULL ,
  `is_preliminary` TINYINT(1) NOT NULL DEFAULT true ,
  `is_verified` TINYINT(1) NOT NULL DEFAULT false ,
  `lock_site` TINYINT(1) NOT NULL DEFAULT false ,
  `number_of_guests` INT NOT NULL ,
  `quoted_price` INT NULL ,
  `extras` TEXT NULL ,
  PRIMARY KEY (`id`, `Customers_id`, `Customer_categories_id`, `Sites_id`) ,
  INDEX `fk_Bookings_Customer_categories1` (`Customer_categories_id` ASC) ,
  INDEX `fk_Bookings_Customers1` (`Customers_id` ASC) ,
  INDEX `fk_Bookings_Sites1` (`Sites_id` ASC) ,
  CONSTRAINT `fk_Bookings_Customer_categories1`
    FOREIGN KEY (`Customer_categories_id` )
    REFERENCES `176690-lasbok`.`Customer_categories` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Bookings_Customers1`
    FOREIGN KEY (`Customers_id` )
    REFERENCES `176690-lasbok`.`Customers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Bookings_Sites1`
    FOREIGN KEY (`Sites_id` )
    REFERENCES `176690-lasbok`.`Sites` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'This table holds information about individual rentals.';


-- -----------------------------------------------------
-- Table `176690-lasbok`.`Relay_cards`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Relay_cards` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Relay_cards` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `Sites_id` INT NOT NULL ,
  `ipaddress` INT UNSIGNED NULL ,
  PRIMARY KEY (`id`, `Sites_id`) ,
  INDEX `fk_Relay_cards_Sites1` (`Sites_id` ASC) ,
  CONSTRAINT `fk_Relay_cards_Sites1`
    FOREIGN KEY (`Sites_id` )
    REFERENCES `176690-lasbok`.`Sites` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'This table holds information about the relay cards used to c' /* comment truncated */;


-- -----------------------------------------------------
-- Table `176690-lasbok`.`Doors`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Doors` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Doors` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `Relay_cards_id` INT NOT NULL ,
  `port` TINYINT NOT NULL ,
  `is_internal` TINYINT(1) NOT NULL DEFAULT false ,
  `description` TINYTEXT NULL ,
  PRIMARY KEY (`id`, `Relay_cards_id`) ,
  INDEX `fk_Doors_Relay_cards1` (`Relay_cards_id` ASC) ,
  CONSTRAINT `fk_Doors_Relay_cards1`
    FOREIGN KEY (`Relay_cards_id` )
    REFERENCES `176690-lasbok`.`Relay_cards` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'This table holds information about doors in the system.';


-- -----------------------------------------------------
-- Table `176690-lasbok`.`Reservation_has_Facilities`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Reservation_has_Facilities` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Reservation_has_Facilities` (
  `Reservations_id` INT NOT NULL ,
  `Facility_partitions_id` INT NOT NULL ,
  PRIMARY KEY (`Reservations_id`, `Facility_partitions_id`) ,
  INDEX `fk_Bookings_has_Facility_partitions_Facility_partitions1` (`Facility_partitions_id` ASC) ,
  INDEX `fk_Bookings_has_Facility_partitions_Bookings1` (`Reservations_id` ASC) ,
  CONSTRAINT `fk_Bookings_has_Facility_partitions_Bookings1`
    FOREIGN KEY (`Reservations_id` )
    REFERENCES `176690-lasbok`.`Reservations` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Bookings_has_Facility_partitions_Facility_partitions1`
    FOREIGN KEY (`Facility_partitions_id` )
    REFERENCES `176690-lasbok`.`Facilities` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `176690-lasbok`.`Partition_has_Doors`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Partition_has_Doors` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Partition_has_Doors` (
  `Partitions_id` INT NOT NULL ,
  `Doors_id` INT NOT NULL ,
  PRIMARY KEY (`Partitions_id`, `Doors_id`) ,
  INDEX `fk_Physical_partitions_has_Doors_Doors1` (`Doors_id` ASC) ,
  INDEX `fk_Physical_partitions_has_Doors_Physical_partitions1` (`Partitions_id` ASC) ,
  CONSTRAINT `fk_Physical_partitions_has_Doors_Physical_partitions1`
    FOREIGN KEY (`Partitions_id` )
    REFERENCES `176690-lasbok`.`Partitions` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Physical_partitions_has_Doors_Doors1`
    FOREIGN KEY (`Doors_id` )
    REFERENCES `176690-lasbok`.`Doors` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `176690-lasbok`.`Servers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Servers` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Servers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `public_ip` INT UNSIGNED NOT NULL ,
  `software_version` VARCHAR(10) NOT NULL ,
  `Sites_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `Sites_id`) ,
  INDEX `fk_Servers_Sites1` (`Sites_id` ASC) ,
  CONSTRAINT `fk_Servers_Sites1`
    FOREIGN KEY (`Sites_id` )
    REFERENCES `176690-lasbok`.`Sites` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'This table contains information needed to reach the servers ' /* comment truncated */;


-- -----------------------------------------------------
-- Table `176690-lasbok`.`Facility_has_Partitions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Facility_has_Partitions` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Facility_has_Partitions` (
  `Facilities_id` INT NOT NULL ,
  `Partitions_id` INT NOT NULL ,
  PRIMARY KEY (`Facilities_id`, `Partitions_id`) ,
  INDEX `fk_Facilities_has_Partitions_Partitions1` (`Partitions_id` ASC) ,
  INDEX `fk_Facilities_has_Partitions_Facilities1` (`Facilities_id` ASC) ,
  CONSTRAINT `fk_Facilities_has_Partitions_Facilities1`
    FOREIGN KEY (`Facilities_id` )
    REFERENCES `176690-lasbok`.`Facilities` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Facilities_has_Partitions_Partitions1`
    FOREIGN KEY (`Partitions_id` )
    REFERENCES `176690-lasbok`.`Partitions` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `176690-lasbok`.`Prices`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Prices` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Prices` (
  `Customer_categories_id` INT NOT NULL ,
  `Facilities_id` INT NOT NULL ,
  `price` INT NOT NULL DEFAULT 0 ,
  `per_head` TINYINT(1) NOT NULL DEFAULT false ,
  PRIMARY KEY (`Customer_categories_id`, `Facilities_id`) ,
  INDEX `fk_Customer_categories_has_Facilities_Facilities1` (`Facilities_id` ASC) ,
  INDEX `fk_Customer_categories_has_Facilities_Customer_categories1` (`Customer_categories_id` ASC) ,
  UNIQUE INDEX `Customer_categories_id_UNIQUE` (`Customer_categories_id` ASC, `Facilities_id` ASC) ,
  CONSTRAINT `fk_Customer_categories_has_Facilities_Customer_categories1`
    FOREIGN KEY (`Customer_categories_id` )
    REFERENCES `176690-lasbok`.`Customer_categories` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Customer_categories_has_Facilities_Facilities1`
    FOREIGN KEY (`Facilities_id` )
    REFERENCES `176690-lasbok`.`Facilities` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `176690-lasbok`.`Users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Users` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Users` (
  `user_name` VARCHAR(64) NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `first_name` VARCHAR(45) NOT NULL ,
  `last_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`user_name`) ,
  UNIQUE INDEX `id_UNIQUE` (`user_name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `176690-lasbok`.`User_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`User_roles` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`User_roles` (
  `id` INT NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `description` TINYTEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `176690-lasbok`.`User_has_User_roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`User_has_User_roles` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`User_has_User_roles` (
  `Users_user_name` VARCHAR(32) NOT NULL ,
  `User_roles_id` INT NOT NULL ,
  PRIMARY KEY (`Users_user_name`, `User_roles_id`) ,
  INDEX `fk_Users_has_User_roles_User_roles1` (`User_roles_id` ASC) ,
  INDEX `fk_Users_has_User_roles_Users1` (`Users_user_name` ASC) ,
  CONSTRAINT `fk_Users_has_User_roles_Users1`
    FOREIGN KEY (`Users_user_name` )
    REFERENCES `176690-lasbok`.`Users` (`user_name` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Users_has_User_roles_User_roles1`
    FOREIGN KEY (`User_roles_id` )
    REFERENCES `176690-lasbok`.`User_roles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `176690-lasbok`.`Buildings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Buildings` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Buildings` (
  `id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  `description` VARCHAR(45) NULL ,
  `Sites_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Buildings_Sites1` (`Sites_id` ASC) ,
  CONSTRAINT `fk_Buildings_Sites1`
    FOREIGN KEY (`Sites_id` )
    REFERENCES `176690-lasbok`.`Sites` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'This table contains information about buildings at a site. B' /* comment truncated */;


-- -----------------------------------------------------
-- Table `176690-lasbok`.`Buildings_has_Facilities`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `176690-lasbok`.`Buildings_has_Facilities` ;

CREATE  TABLE IF NOT EXISTS `176690-lasbok`.`Buildings_has_Facilities` (
  `Buildings_id` INT NOT NULL ,
  `Facilities_id` INT NOT NULL ,
  PRIMARY KEY (`Buildings_id`, `Facilities_id`) ,
  INDEX `fk_Buildings_has_Facilities_Facilities1` (`Facilities_id` ASC) ,
  INDEX `fk_Buildings_has_Facilities_Buildings1` (`Buildings_id` ASC) ,
  CONSTRAINT `fk_Buildings_has_Facilities_Buildings1`
    FOREIGN KEY (`Buildings_id` )
    REFERENCES `176690-lasbok`.`Buildings` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Buildings_has_Facilities_Facilities1`
    FOREIGN KEY (`Facilities_id` )
    REFERENCES `176690-lasbok`.`Facilities` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
