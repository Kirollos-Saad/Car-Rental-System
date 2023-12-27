/*drop database car_rental_system;*/


create database car_rental_system;
use car_rental_system;

/*
Consider moving date deleted into a seperate relation to avoid null attributes
*/
create table Car(
    plate_number int primary key,
    color varchar(255) not null,
    is_automatic boolean not null,
    price_per_day DECIMAL(6,2) not null,
    model_name varchar(255) not null,
    manufacturer varchar(255) not null,
    year_produced year not null,
    car_status varchar(255) not null CHECK (car_status IN ('Active', 'Out of Service', 'Rented')),
    date_deleted timestamp,
    office_id int not null,
    image_path varchar(255) not null
);
/*
use MD5 encryption for password hash
*/
create table Customer(
    customer_id int AUTO_INCREMENT primary key,
    email varchar(255) unique not null,
    phone varchar(20) unique not null,
    password_hash char(32) not null,
    customer_name varchar(255) not null,
    country varchar(255) not null,
    city varchar(255) not null
);


create table Office(
    office_id int AUTO_INCREMENT primary key,
    country varchar(255) not null,
    city varchar(255) not null
);

create table Admin(
    admin_id int AUTO_INCREMENT primary key,
    email varchar(255) unique not null,
    phone varchar(20) unique not null,
    password_hash char(32) not null,
    office_id int not null,
    foreign key (office_id) references Office(office_id)
);


create table Current_Renting(
    plate_number int,
    customer_id int,
    reserve_date date not null,
    pick_up_date date not null,
    primary key(plate_number, customer_id),
    foreign key (plate_number) references Car(plate_number),
    foreign key (customer_id) references Customer(customer_id)
);

create table Reservation_History(
    plate_number int,
    customer_id int,
    reserve_date date,
    return_date date not null,
    pick_up_date date not null,
    primary key(customer_id, plate_number, reserve_date),
    foreign key (plate_number) references Car(plate_number),
    foreign key (customer_id) references Customer(customer_id)
);


create table Payment(
    amount DECIMAL(10,2) not null,
    payment_type varchar(255) not null CHECK (payment_type IN ('Visa', 'Mastercard', 'PayPal' ,'Cash')),
    payment_date timestamp,
    number_of_days int not null,
    plate_number int,
    customer_id int,
    primary key(customer_id, plate_number, payment_date),
    foreign key (plate_number) references Car(plate_number),
    foreign key (customer_id) references Customer(customer_id)
);


alter table Car add foreign key (office_id) references Office(office_id);