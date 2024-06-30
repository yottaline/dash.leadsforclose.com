CREATE TABLE IF NOT EXISTS
  `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_code` VARCHAR(8) NOT NULL,
    `user_name` VARCHAR(120) NOT NULL,
    `user_email` VARCHAR(120) NOT NULL,
    `user_password` VARCHAR(255) NOT NULL,
    `user_active` BOOLEAN NOT NULL DEFAULT TRUE,
    `user_modified` DATETIME DEFAULT NULL,
    `user_modified_by` INT UNSIGNED NOT NULL,
    `user_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE (`user_code`),
    UNIQUE (`user_email`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- --------------------------------------

CREATE TABLE IF NOT EXISTS
  `ro_clients` (
    `ro_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ro_code` VARCHAR(8) NOT NULL,
    `ro_fullName` VARCHAR(120) NOT NULL,
    `ro_email` VARCHAR(120) NOT NULL,
    `ro_phone` VARCHAR(25) NOT NULL,
    `ro_active` BOOLEAN NOT NULL DEFAULT TRUE,
    `ro_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ro_id`),
    UNIQUE (`ro_code`),
    UNIQUE (`ro_id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

  -----------------------------------------------

  CREATE TABLE IF NOT EXISTS
  `rt_clients` (
    `rt_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `rt_code` VARCHAR(8) NOT NULL,
    `rt_firstName` VARCHAR(100) NOT NULL,
    `rt_lastName` VARCHAR(100) NOT NULL,
    `rt_email` VARCHAR(120) NOT NULL,
    `rt_phone` VARCHAR(24) NOT NULL,
    `rt_umberSeats` INT UNSIGNED NOT NULL,
    `rt_state` VARCHAR(255) NOT NULL,
    `rt_status` BOOLEAN NOT NULL DEFAULT TRUE,
    `rt_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`rt_id`),
    UNIQUE (`rt_code`),
    UNIQUE (`rt_email`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

  -----------------------------------------------

  CREATE TABLE IF NOT EXISTS
  `r_attachments` (
    `attach_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `attach_file` VARCHAR(70) NOT NULL,
    `attach_reClient`INT UNSIGNED NOT NULL,
    `attach_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`attach_id`),
     FOREIGN KEY (`attach_reClient`) REFERENCES `rt_clients` (`rt_id`),
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

