#!/usr/bin/env bash

echo -n "MySQL username: "

read MYSQL_USERNAME

echo -n "MySQL password: "

read MYSQL_PASSWORD

echo -n "Database name: "

read DBNAME

mysqladmin -u"${MYSQL_USERNAME}" -p"${MYSQL_PASSWORD}" create "${DBNAME}"

cat ../../modules/auth/mysql.sql | mysql -u"${MYSQL_USERNAME}" -p"${MYSQL_PASSWORD}" "${DBNAME}"

echo "Database successfully created."
