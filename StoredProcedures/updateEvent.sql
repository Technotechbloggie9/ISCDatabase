--Switch to the wordpress database
USE wordpress;

--Create the new procedure
DELIMITER ;;
CREATE OR REPLACE PROCEDURE updateEvent(
	IN	id		int(11),
	IN	name		varchar(128),
	IN	start_date	date,
	IN	end_date	date,
	IN	description	varchar(600),
	IN	location	varchar(64),
	IN	attendance	int(11),
	IN	is_public	tinyint(1)
)
BEGIN
	update Events set
		Events.name 		= name,
		Events.start_date 	= start_date,
		Events.end_date 	= end_date,
		Events.description 	= description,
		Events.location 	= location,
		Events.attendance 	= attendance,
		Events.is_public 	= is_public
	where Events.event_id = id;

END;;
DELIMITER ;


