--Switch to the wordpress database
USE wordpress;

--Create the new procedure
DELIMITER ;;
CREATE OR REPLACE PROCEDURE deleteEvent(
	IN	eventID	int(11)
)
BEGIN
	delete from Events
	where Events.event_id = eventID
	returning Events.event_id;

END;;
DELIMITER ;


