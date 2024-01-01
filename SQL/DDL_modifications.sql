/* Allow Date Deleted to be NULL*/

ALTER TABLE Car
MODIFY COLUMN date_deleted TIMESTAMP NULL;


/*Set date deleted for all cars in the system to be NULL
Will undeleted all cars
*/
UPDATE Car
SET date_deleted = NULL;
