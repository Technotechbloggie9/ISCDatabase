--Switch to the wordpress database
USE wordpress;

--Create the new procedure
DELIMITER ;;
CREATE OR REPLACE PROCEDURE createEvent(
	IN	name		varchar(128),
	IN	start_date	date,
	IN	end_date	date,
	IN	description	varchar(600),
	IN	location	varchar(64),
	IN	attendance	int(11),
	IN	is_public	tinyint(1)
)
BEGIN
	insert into Events(
		event_id,
		name,
		start_date,
		end_date,
		description,
		location,
		attendance,
		is_public
	) 
		values (
			0,
			name,
			start_date,
			end_date,
			description,
			location,
			attendance,
			is_public
		) returning Events.event_id;

END;;
DELIMITER ;


