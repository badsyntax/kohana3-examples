#!/usr/bin/env bash

echo -n "Database name: "

read DBNAME

echo -n "MySQL username: "

read MYSQL_USERNAME

echo -n "MySQL password: "

read MYSQL_PASSWORD

mysqladmin -u"${MYSQL_USERNAME}" -p"${MYSQL_PASSWORD}" drop "${DBNAME}"

mysqladmin -u"${MYSQL_USERNAME}" -p"${MYSQL_PASSWORD}" create "${DBNAME}"

cat ../sql/mysql/database.sql | mysql -u"${MYSQL_USERNAME}" -p"${MYSQL_PASSWORD}" "${DBNAME}"

echo "Database successfully created."
