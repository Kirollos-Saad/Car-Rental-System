use car_rental_system;

/* Add Some Offices*/
insert into office values(1,'Egypt','Alexandria');
insert into office values(2,'USA','New York');
insert into office values(3,'Russia','Moscow');
insert into office values(4,'UAE','Dubai');
insert into office values(5,'Saudi Arabia','Makka');
insert into office values(6,'France','Paris');
insert into office values(7,'USA','Washington');


/* Add Some Admins*/
INSERT into `admin` VALUES (1,'ahmedHany@gmail.com','201212234866','81dc9bdb52d04dc20036dbd8313ed055',1);/* 1234 */
insert into `Admin` values(2,'ali@gmail.com','20122102121','202cb962ac59075b964b07152d234b70',1);/* 123*/
insert into `Admin` values(3,'johnSmith@gmail.com','+10122102121','e10adc3949ba59abbe56e057f20f883e',2); /*123456 */


/* Add Some Customers*/
insert into customer values(1,'kiro@gmail.com','+201111111122','202cb962ac59075b964b07152d234b70','kiro','Egypt','Alexandria'); /*123*/
insert into customer values(2,'Ahmedgabr@gmail.com','+1012021021223','81dc9bdb52d04dc20036dbd8313ed055','Ahmed Gabr','USA','Miami,Florida'); /*1234*/
insert into customer values(3,'aliAhmed@gmail.com','+201119898227','827ccb0eea8a706c4c34a16891f84e7b','Ali Ahmed','Egypt','Alexandria');/*12345*/
insert into customer values(4,'william@gmail.com','+1543434322','4f20e4542317edb61b1a710a13ae6a95','William Hanks','USA','Denver,Colorado');/* 2502! */
insert into customer values(5,'karpov@gmail.com','+7545545454','a30636566360aa3fc13fd9e8ffbcdd66','Vladmir Karpov','Russia','Moscow');/* 2rhf1 */


/*Add Some Cars*/
insert into car values(1,'white','1',90,'Benz CLA class','Mercedes','2015','active',NULL,'2022-04-05',4,'https://upload.wikimedia.org/wikipedia/commons/7/71/Mercedes-Benz_C118_IMG_2673.jpg');
insert into car values(2,'blue','1',100,'Benz CLA class','Mercedes','2017','active',NULL,'2022-10-05',4,'https://www.topgear.com/sites/default/files/2023/10/Medium-44235-CLA250e.jpg');
insert into car values(3,'silver','1',50,'Picanto','Kia','2023','active',NULL,'2022-10-05',2,'https://images.carexpert.com.au/crop/1200/630/app/uploads/2023/01/Kia-Picanto-GT_HERO-16x9-2.jpg');
insert into car values(4,'red','0',30,'Alto K10','Suzuki','2018','active',NULL,'2022-01-01',1,'https://www.arabsauto.com/wp-content/uploads/2022/08/2023-Suzuki-Alto-K10-ArabsAuto-9.jpg');
insert into car values(5,'white','0',35,'Lancer','Mitsubishi','2010','active',NULL,'2022-01-02',1,'https://carsguide-res.cloudinary.com/image/upload/f_auto%2Cfl_lossy%2Cq_auto%2Ct_default/v1/editorial/mitsubishi-lancer-used-07-1001x565-%281%29.jpg');
insert into car values(6,'red','1',80,'Dzire','Suzuki','2021','active',NULL,'2022-03-21',3,'https://imgcdn.zigwheels.ph/large/gallery/color/29/257/suzuki-swift-dzire-color-168959.jpg');
insert into car values(7,'silver','1',120,'Benz A class','Mercedes','2017','active',NULL,'2022-05-28',7,'https://www.mercedes-benz.com.eg/content/dam/hq/passengercars/cars/a-class/saloon-v177-pi/mercedes-benz-a-class-v177-design-contentgallery-front-01-2730x1536-07-2018.jpg');



/*Add Some Cars to Reservation History */
use car_rental_system;
INSERT INTO Reservation_History(plate_number, customer_id, reserve_date, pick_up_date, return_date)
VALUES (4, 1, "2023-1-1", "2023-1-2", "2023-6-25");

use car_rental_system;
INSERT INTO Reservation_History(plate_number, customer_id, reserve_date, pick_up_date, return_date)
VALUES (6, 5, "2023-6-1", "2023-6-8", "2023-12-5");



/*Add Some Cars to Current Reservation */
use car_rental_system;
INSERT INTO Current_Renting(plate_number, customer_id, reserve_date, pick_up_date)
VALUES (7, 2, "2023-12-10", "2023-12-12");


UPDATE Car
SET car_status = 'Rented'
WHERE plate_number = 7;
