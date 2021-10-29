/*
	getEvent vs getEvents:
		getEvent - returns fine detail for a singular event
		getEvents - returns less detail for a list of events to be used
			to create tables or cards with high level detail
*/

--Switch to the wordpress database
USE wordpress;

--Create the new procedure
DELIMITER ;;
CREATE OR REPLACE PROCEDURE getEvent(
	IN	id		int(11)
)
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
	from Events
	where Events.event_id = id;
END;;
DELIMITER ;


