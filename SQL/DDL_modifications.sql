/* Allow Date Deleted to be NULL*/

ALTER TABLE Car
MODIFY COLUMN date_deleted TIMESTAMP NULL;


/*Set date deleted for all cars in the system to be NULL
Will undeleted all cars
*/
UPDATE Car
SET date_deleted = NULL;

/* Add Date Added column and allow it to be NULL */
ALTER TABLE Car
ADD COLUMN date_added TIMESTAMP NULL;

/* Set date_added for all cars in the system to be the current timestamp */
UPDATE Car
SET date_added = "2023-01-01 23:09:17";


/* Allow Pickup Date to be NULL*/

ALTER TABLE Current_Renting
MODIFY COLUMN pick_up_date TIMESTAMP NULL;


/*Set pickup date deleted for all cars in the system to be NULL
*/
UPDATE Current_Renting
SET pick_up_date = NULL;