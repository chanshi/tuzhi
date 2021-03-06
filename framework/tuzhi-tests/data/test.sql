SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE DATABASE IF NOT EXISTS `tuzhi_test` DEFAULT CHARACTER SET UTF8 ;

CREATE TABLE IF NOT EXISTS `tuzhi_test`.`user` (
  `userId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `userName` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `createTime` INT(11) UNSIGNED NOT NULL,
  `lastTime` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`userId`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `tuzhi_test`.`user_info` (
  `userId` INT  UNSIGNED NOT NULL AUTO_INCREMENT,
  `gender` TINYINT(1) UNSIGNED NULL,
  `mobile` VARCHAR(45) NULL,
  PRIMARY KEY (`userId`),
    FOREIGN KEY (`userId`)
    REFERENCES `tuzhi_test`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `tuzhi_test`.`user_login_logs` (
  `logsId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `userId` INT UNSIGNED NOT NULL,
  `loginTime` INT(11) UNSIGNED NOT NULL,
  `loginIp` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`logsId`),
    FOREIGN KEY (`userId`)
    REFERENCES `tuzhi_test`.`user` (`userId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
