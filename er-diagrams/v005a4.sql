-- MySQL Script generated by MySQL Workbench
-- Παρ 02 Ιούν 2017 12:30:36 πμ EEST
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema test_e-front
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `test_e-front` ;

-- -----------------------------------------------------
-- Schema test_e-front
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `test_e-front` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `test_e-front` ;

-- -----------------------------------------------------
-- Table `test_e-front`.`company`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_e-front`.`company` ;

CREATE TABLE IF NOT EXISTS `test_e-front`.`company` (
  `idcompany` INT NOT NULL AUTO_INCREMENT,
  `company_name` VARCHAR(45) NULL,
  PRIMARY KEY (`idcompany`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_e-front`.`ypokatastima`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_e-front`.`ypokatastima` ;

CREATE TABLE IF NOT EXISTS `test_e-front`.`ypokatastima` (
  `idypokatastima` INT NULL AUTO_INCREMENT,
  `company_idcompany` INT NOT NULL,
  `ypokatastima_name` VARCHAR(45) NULL,
  PRIMARY KEY (`idypokatastima`, `company_idcompany`),
  INDEX `fk_ypokatastima_company_idx` (`company_idcompany` ASC),
  CONSTRAINT `fk_ypokatastima_company`
    FOREIGN KEY (`company_idcompany`)
    REFERENCES `test_e-front`.`company` (`idcompany`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_e-front`.`school-class`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_e-front`.`school-class` ;

CREATE TABLE IF NOT EXISTS `test_e-front`.`school-class` (
  `id_school_class` INT NOT NULL AUTO_INCREMENT,
  `ypokatastima_idypokatastima` INT NOT NULL,
  `ypokatastima_company_idcompany` INT NOT NULL,
  `school-class_name` VARCHAR(45) NULL,
  `school-class_desc` VARCHAR(45) NULL,
  PRIMARY KEY (`id_school_class`, `ypokatastima_idypokatastima`, `ypokatastima_company_idcompany`),
  INDEX `fk_taxi_ypokatastima1_idx` (`ypokatastima_idypokatastima` ASC, `ypokatastima_company_idcompany` ASC),
  CONSTRAINT `fk_taxi_ypokatastima1`
    FOREIGN KEY (`ypokatastima_idypokatastima` , `ypokatastima_company_idcompany`)
    REFERENCES `test_e-front`.`ypokatastima` (`idypokatastima` , `company_idcompany`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_e-front`.`speciality`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_e-front`.`speciality` ;

CREATE TABLE IF NOT EXISTS `test_e-front`.`speciality` (
  `idspeciality` INT NOT NULL AUTO_INCREMENT,
  `speciality_code` VARCHAR(45) NULL,
  `speciality_description` VARCHAR(45) NULL,
  PRIMARY KEY (`idspeciality`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_e-front`.`lesson`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_e-front`.`lesson` ;

CREATE TABLE IF NOT EXISTS `test_e-front`.`lesson` (
  `idlesson` INT NOT NULL AUTO_INCREMENT,
  `mathites_number` VARCHAR(45) NULL,
  `tmima_idtmima` INT NOT NULL,
  `tmima_taxi_idtaxi` INT NOT NULL,
  `tmima_taxi_ypokatastima_idypokatastima` INT NOT NULL,
  `tmima_taxi_ypokatastima_company_idcompany` INT NOT NULL,
  `speciality_required` VARCHAR(45) NULL,
  `speciality_idspeciality` INT NOT NULL,
  `taxi_id_school_class` INT NOT NULL,
  `taxi_ypokatastima_idypokatastima` INT NOT NULL,
  `taxi_ypokatastima_company_idcompany` INT NOT NULL,
  `lesson_name` VARCHAR(45) NULL,
  PRIMARY KEY (`idlesson`, `tmima_idtmima`, `tmima_taxi_idtaxi`, `tmima_taxi_ypokatastima_idypokatastima`, `tmima_taxi_ypokatastima_company_idcompany`, `taxi_id_school_class`, `taxi_ypokatastima_idypokatastima`, `taxi_ypokatastima_company_idcompany`),
  INDEX `fk_lesson_speciality1_idx` (`speciality_idspeciality` ASC),
  INDEX `fk_lesson_taxi1_idx` (`taxi_id_school_class` ASC, `taxi_ypokatastima_idypokatastima` ASC, `taxi_ypokatastima_company_idcompany` ASC),
  CONSTRAINT `fk_lesson_speciality1`
    FOREIGN KEY (`speciality_idspeciality`)
    REFERENCES `test_e-front`.`speciality` (`idspeciality`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lesson_taxi1`
    FOREIGN KEY (`taxi_id_school_class` , `taxi_ypokatastima_idypokatastima` , `taxi_ypokatastima_company_idcompany`)
    REFERENCES `test_e-front`.`school-class` (`id_school_class` , `ypokatastima_idypokatastima` , `ypokatastima_company_idcompany`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_e-front`.`professor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_e-front`.`professor` ;

CREATE TABLE IF NOT EXISTS `test_e-front`.`professor` (
  `idprofessor` INT NOT NULL AUTO_INCREMENT,
  `professor_afm` VARCHAR(45) NULL,
  `professor_name` VARCHAR(45) NULL,
  `speciality_idspeciality` INT NOT NULL,
  PRIMARY KEY (`idprofessor`),
  INDEX `fk_professor_speciality1_idx` (`speciality_idspeciality` ASC),
  CONSTRAINT `fk_professor_speciality1`
    FOREIGN KEY (`speciality_idspeciality`)
    REFERENCES `test_e-front`.`speciality` (`idspeciality`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_e-front`.`tmima`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_e-front`.`tmima` ;

CREATE TABLE IF NOT EXISTS `test_e-front`.`tmima` (
  `idtmima` INT NOT NULL AUTO_INCREMENT,
  `mathites_number` VARCHAR(45) NULL,
  `lesson_idlesson` INT NOT NULL,
  `lesson_tmima_idtmima` INT NOT NULL,
  `lesson_tmima_taxi_idtaxi` INT NOT NULL,
  `lesson_tmima_taxi_ypokatastima_idypokatastima` INT NOT NULL,
  `lesson_tmima_taxi_ypokatastima_company_idcompany` INT NOT NULL,
  `professor_idprofessor` INT NOT NULL,
  `tmima_name` VARCHAR(45) NULL,
  `tmima_desc` VARCHAR(45) NULL,
  PRIMARY KEY (`idtmima`, `lesson_idlesson`, `lesson_tmima_idtmima`, `lesson_tmima_taxi_idtaxi`, `lesson_tmima_taxi_ypokatastima_idypokatastima`, `lesson_tmima_taxi_ypokatastima_company_idcompany`),
  INDEX `fk_tmima_lesson1_idx` (`lesson_idlesson` ASC, `lesson_tmima_idtmima` ASC, `lesson_tmima_taxi_idtaxi` ASC, `lesson_tmima_taxi_ypokatastima_idypokatastima` ASC, `lesson_tmima_taxi_ypokatastima_company_idcompany` ASC),
  INDEX `fk_tmima_professor1_idx` (`professor_idprofessor` ASC),
  CONSTRAINT `fk_tmima_lesson1`
    FOREIGN KEY (`lesson_idlesson` , `lesson_tmima_idtmima` , `lesson_tmima_taxi_idtaxi` , `lesson_tmima_taxi_ypokatastima_idypokatastima` , `lesson_tmima_taxi_ypokatastima_company_idcompany`)
    REFERENCES `test_e-front`.`lesson` (`idlesson` , `tmima_idtmima` , `tmima_taxi_idtaxi` , `tmima_taxi_ypokatastima_idypokatastima` , `tmima_taxi_ypokatastima_company_idcompany`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tmima_professor1`
    FOREIGN KEY (`professor_idprofessor`)
    REFERENCES `test_e-front`.`professor` (`idprofessor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_e-front`.`company_professors`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_e-front`.`company_professors` ;

CREATE TABLE IF NOT EXISTS `test_e-front`.`company_professors` (
  `professor_idprofessor` INT NOT NULL AUTO_INCREMENT,
  `company_idcompany` INT NOT NULL,
  INDEX `fk_company_professors_professor1_idx` (`professor_idprofessor` ASC),
  INDEX `fk_company_professors_company1_idx` (`company_idcompany` ASC),
  CONSTRAINT `fk_company_professors_professor1`
    FOREIGN KEY (`professor_idprofessor`)
    REFERENCES `test_e-front`.`professor` (`idprofessor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_company_professors_company1`
    FOREIGN KEY (`company_idcompany`)
    REFERENCES `test_e-front`.`company` (`idcompany`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_e-front`.`dayslot`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_e-front`.`dayslot` ;

CREATE TABLE IF NOT EXISTS `test_e-front`.`dayslot` (
  `iddayslot` INT NOT NULL AUTO_INCREMENT,
  `thisday` DATE NULL,
  `program_type` INT NULL,
  `start_date` DATE NULL,
  `end_date` DATE NULL,
  PRIMARY KEY (`iddayslot`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `test_e-front`.`timeslot_teach`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `test_e-front`.`timeslot_teach` ;

CREATE TABLE IF NOT EXISTS `test_e-front`.`timeslot_teach` (
  `idtimeslot_teach` INT NOT NULL AUTO_INCREMENT,
  `professor_idprofessor` INT NOT NULL,
  `start_time` VARCHAR(45) NULL,
  `timeslot_work_minutes` INT NULL,
  `timeslot_school_year` VARCHAR(45) NULL,
  `tmima_idtmima` INT NOT NULL,
  `tmima_lesson_idlesson` INT NOT NULL,
  `tmima_lesson_tmima_idtmima` INT NOT NULL,
  `tmima_lesson_tmima_taxi_idtaxi` INT NOT NULL,
  `tmima_lesson_tmima_taxi_ypokatastima_idypokatastima` INT NOT NULL,
  `tmima_lesson_tmima_taxi_ypokatastima_company_idcompany` INT NOT NULL,
  `dayslot_iddayslot` INT NOT NULL,
  PRIMARY KEY (`idtimeslot_teach`, `dayslot_iddayslot`),
  INDEX `fk_timeslot_teach_professor1_idx` (`professor_idprofessor` ASC),
  INDEX `fk_timeslot_teach_tmima1_idx` (`tmima_idtmima` ASC, `tmima_lesson_idlesson` ASC, `tmima_lesson_tmima_idtmima` ASC, `tmima_lesson_tmima_taxi_idtaxi` ASC, `tmima_lesson_tmima_taxi_ypokatastima_idypokatastima` ASC, `tmima_lesson_tmima_taxi_ypokatastima_company_idcompany` ASC),
  INDEX `fk_timeslot_teach_dayslot1_idx` (`dayslot_iddayslot` ASC),
  CONSTRAINT `fk_timeslot_teach_professor1`
    FOREIGN KEY (`professor_idprofessor`)
    REFERENCES `test_e-front`.`professor` (`idprofessor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_timeslot_teach_tmima1`
    FOREIGN KEY (`tmima_idtmima` , `tmima_lesson_idlesson` , `tmima_lesson_tmima_idtmima` , `tmima_lesson_tmima_taxi_idtaxi` , `tmima_lesson_tmima_taxi_ypokatastima_idypokatastima` , `tmima_lesson_tmima_taxi_ypokatastima_company_idcompany`)
    REFERENCES `test_e-front`.`tmima` (`idtmima` , `lesson_idlesson` , `lesson_tmima_idtmima` , `lesson_tmima_taxi_idtaxi` , `lesson_tmima_taxi_ypokatastima_idypokatastima` , `lesson_tmima_taxi_ypokatastima_company_idcompany`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_timeslot_teach_dayslot1`
    FOREIGN KEY (`dayslot_iddayslot`)
    REFERENCES `test_e-front`.`dayslot` (`iddayslot`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Here we put data like\nprof01 teached lesson05 on 12-2-2017 at timeslot 1st hour';


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
