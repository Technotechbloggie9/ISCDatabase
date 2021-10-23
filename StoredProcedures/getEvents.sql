--Switch to the wordpress database
USE wordpress;

--Create the new procedure
DELIMITER ;;
CREATE OR REPLACE PROCEDURE getEvents()
BEGIN
	select 	
		event_id		as 'event_id', 
		name	 		as 'name',
		start_date		as 'start_date',
		end_date		as 'end_date',
		description		as 'description',
		location		as 'location',
		attendance		as 'attendance',
		is_public		as 'is_public'
	from Events;
END;;
DELIMITER ;


