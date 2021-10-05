#!/bin/bash
#script to make backup txt files from
#custom wordpress tables


#getopts version is crucial for shell_exec operation
while getopts u:p:h: flag
do
    case "${flag}" in
        u) myuser=${OPTARG};;
	      h) echo "bash backupwordpress.sh -u yourusername -p yourpassword";;
        p) mypassword=${OPTARG};;
    esac
done

mysqldump -u $myuser -p$mypassword wordpress U_Values > /tmp/U_Values.sql
mysqldump -u $myuser -p$mypassword wordpress Audit_Log > /tmp/Audit_Log.sql
mysqldump -u $myuser -p$mypassword wordpress Event_Keywords > /tmp/Event_Keywords.sql
mysqldump -u $myuser -p$mypassword wordpress Event_Performances > /tmp/Event_Performances.sql
mysqldump -u $myuser -p$mypassword wordpress Event_Performers > /tmp/Event_Performers.sql
mysqldump -u $myuser -p$mypassword wordpress Events > /tmp/Events.sql
mysqldump -u $myuser -p$mypassword wordpress Keywords > /tmp/Keywords.sql
mysqldump -u $myuser -p$mypassword wordpress Performance_Keywords > /tmp/Performance_Keywords.sql
mysqldump -u $myuser -p$mypassword wordpress Performance_Performers > /tmp/Performance_Performers.sql
mysqldump -u $myuser -p$mypassword wordpress Performance_Recording > /tmp/Performance_Recording.sql
mysqldump -u $myuser -p$mypassword wordpress Performances > /tmp/Performances.sql
mysqldump -u $myuser -p$mypassword wordpress Performer_Keywords > /tmp/Performer_Keywords.sql
mysqldump -u $myuser -p$mypassword wordpress Permission_Types > /tmp/Permission_Types.sql
mysqldump -u $myuser -p$mypassword wordpress Transcription_Recording > /tmp/Transcription_Recording.sql
mysqldump -u $myuser -p$mypassword wordpress Transcription_SRT > /tmp/Transcription_SRT.sql
mysqldump -u $myuser -p$mypassword wordpress Profile_Images > /tmp/Profile_Images.sql
mysqldump -u $myuser -p$mypassword wordpress Role_Type > /tmp/Role_Type.sql
mysqldump -u $myuser -p$mypassword wordpress User_Addresses > /tmp/User_Addresses.sql
mysqldump -u $myuser -p$mypassword wordpress User_Genders > /tmp/User_Genders.sql
mysqldump -u $myuser -p$mypassword wordpress User_Login_Policies > /tmp/User_Login_Policies.sql
mysqldump -u $myuser -p$mypassword wordpress User_Names > /tmp/User_Names.sql
mysqldump -u $myuser -p$mypassword wordpress User_Phone_Numbers > /tmp/User_Phone_Numbers.sql
mysqldump -u $myuser -p$mypassword wordpress User_Roles > /tmp/User_Roles.sql

echo "Backup completed."


