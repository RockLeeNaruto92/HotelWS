-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2015-12-01 16:40:25.266

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP DATABASE IF EXISTS hotel_ws;
CREATE DATABASE hotel_ws;
USE hotel_ws;

-- tables
-- Table airlines
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;

-- tables
-- Table contracts
CREATE TABLE contracts (
    id int  NOT NULL,
    hotel_id varchar(20)  NOT NULL,
    customer_id_number varchar(45)  NOT NULL,
    company_name varchar(45)  NOT NULL,
    company_address varchar(45)  NOT NULL,
    company_phone varchar(45)  NOT NULL,
    booking_rooms int NOT NULL,
    check_in_date date  NOT NULL,
    check_out_date date  NOT NULL,
    status int  NOT NULL,
    payment_method varchar(45)  NOT NULL,
    created_time datetime,
    total_money int  NOT NULL,
    CONSTRAINT contracts_pk PRIMARY KEY (id)
)ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Table hotels
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE hotels (
    id varchar(20)  NOT NULL,
    name varchar(45)  NOT NULL,
    star int  NOT NULL,
    province varchar(45)  NOT NULL,
    country varchar(45)  NOT NULL,
    address varchar(45)  NOT NULL,
    website varchar(45)  NOT NULL,
    phone varchar(45)  NOT NULL,
    total_rooms int  NOT NULL,
    available_rooms int NOT NULL,
    cost int  NOT NULL,
    CONSTRAINT hotels_pk PRIMARY KEY (id)
)ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;





-- foreign keys
-- Reference:  contracts_hotels (table: contracts)


ALTER TABLE contracts ADD CONSTRAINT contract_hotel_fk FOREIGN KEY contracts (hotel_id)
    REFERENCES hotels (id);



-- End of file.

