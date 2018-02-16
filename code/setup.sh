#!/bin/bash

db_user="chanande"
db_hostname="mcsdb.utm.utoronto.ca"
db_name="chanande_309"
db_password="40156"

sed -e "s/DB_NAME/$db_name/" -e "s/DB_HOSTNAME/$db_hostname/" -e "s/DB_USER/$db_user/" -e "s/DB_PASSWORD/$db_password/" dbconnect_string_template.php > ../lib/dbconnect_string.php

psql "dbname='$db_name' user='$db_user' password='$db_password' host='$db_hostname'" -f schema.sql