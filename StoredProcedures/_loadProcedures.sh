#!/bin/bash

# Script must be made executable, to do so, issue the following shell command:
# sudo chmod +x _loadProcedures.sh

# To execute script from shell:
# ./_loadProcedures.sh

# Script must be ran each time the stored procedures in database need to be
# updated (after code changes in .sql files are made).

# MariaDB connection info
dbUser=nextdev

# Get MariaDB password, do not store in script for security reasons
read -sp 'MariaDB password: ' dbPass 
echo

# Iterate over each .sql file in directory and execute against database
fileList="./*.sql"
for file in $fileList
do
	echo Loading: $file
	mariadb -u $dbUser -p$dbPass < $file
	echo
done

