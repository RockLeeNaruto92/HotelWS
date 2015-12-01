-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2015-12-01 16:40:25.266

DROP hotel_ws IF EXISTS;
CREATE DATABASE hotel_ws;
USE hotel_ws;


-- tables
-- Table contract_hotel
CREATE TABLE contract_hotel (
    contract_id int  NOT NULL,
    hotel_id varchar(20)  NOT NULL,
    company_name varchar(45)  NOT NULL,
    customer_cmt varchar(45)  NOT NULL,
    company_address varchar(45)  NOT NULL,
    company_phone varchar(45)  NOT NULL,
    number_single_room int  NOT NULL,
    number_double_room int  NOT NULL,
    number_four_people_room int  NOT NULL,
    check_in_date date  NOT NULL,
    check_out_date date  NOT NULL,
    status int  NOT NULL,
    payments_method varchar(45)  NOT NULL,
    contract_create_date date  NOT NULL,
    single_cost int  NOT NULL,
    double_cost int  NOT NULL,
    four_people_cost int  NOT NULL,
    constract_changeable_day date  NOT NULL,
    changed_count int  NOT NULL,
    total_money int  NOT NULL,
    hotel_info_hotel_id int  NOT NULL,
    CONSTRAINT contract_hotel_pk PRIMARY KEY (contract_id)
);

-- Table hotel_info
CREATE TABLE hotel_info (
    hotel_id int  NOT NULL,
    hotel_name varchar(45)  NOT NULL,
    hotel_star int  NOT NULL,
    hotel_ward varchar(45)  NOT NULL,
    hotel_country varchar(45)  NOT NULL,
    hotel_city varchar(45)  NOT NULL,
    hotel_full_address varchar(90)  NOT NULL,
    hotel_website varchar(45)  NOT NULL,
    hotel_email varchar(45)  NOT NULL,
    hotel_phone varchar(45)  NOT NULL,
    total_room int  NOT NULL,
    single_room_avaiable int  NOT NULL,
    double_room_available int  NOT NULL,
    four_people_room_available int  NOT NULL,
    single_room_cost int  NOT NULL,
    double_room_cost int  NOT NULL,
    four_people_room_cost int  NOT NULL,
    CONSTRAINT hotel_info_pk PRIMARY KEY (hotel_id)
);





-- foreign keys
-- Reference:  contract_hotel_hotel_info (table: contract_hotel)


ALTER TABLE contract_hotel ADD CONSTRAINT contract_hotel_hotel_info FOREIGN KEY contract_hotel_hotel_info (hotel_info_hotel_id)
    REFERENCES hotel_info (hotel_id);



-- End of file.

