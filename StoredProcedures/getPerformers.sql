--Switch to the wordpress database
USE wordpress;

--Create the new procedure
DELIMITER ;;
CREATE OR REPLACE PROCEDURE getPerformers()
BEGIN
	select 	ID 			as 'UserID', 
		display_name 		as 'Name',
		user_email		as 'Email' 
	from wp_users 
		left join User_Roles on wp_users.ID = User_Roles.user_id 
	where User_Roles.role_id  = 1;
END;;
DELIMITER ;


