#!/bin/bash
#script to make backup txt files from
#custom wordpress tables

#change these to match your setup
#myuser = "root"
#mypassword = ""
#wp = "wordpress"
#an alternative is to use read $myvar style
#to do so comment out commands above and use those below
#but note that it must be a valid mariadb user
#and password
#this now reads by flag -u for username
#-p for password
while getopts u:p:h: flag
do
    case "${flag}" in
        u) myuser=${OPTARG};;
	h) echo "bash reloadwordpress.sh -u yourusername -p yourpassword";;
        p) mypassword=${OPTARG};;
    esac
done
#echo "What is your username?:"
#read myuser
#echo "What is your password?:"
#read mypassword
mysql -u $myuser -p$mypassword wordpress < /tmp/U_Values.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Audit_Log.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Event_Keywords.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Event_Performances.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Event_Performers.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Events.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Keywords.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Performance_Keywords.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Performance_Performers.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Performance_Recording.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Performances.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Performer_Keywords.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Permission_Types.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Profile_Images.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Role_Type.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Transcription_Recording.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/Transcription_SRT.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/User_Addresses.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/User_Genders.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/User_Login_Policies.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/User_Names.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/User_Phone_Numbers.sql
mysql -u $myuser -p$mypassword wordpress < /tmp/User_Roles.sql

echo "Reloaded content from backup files."

