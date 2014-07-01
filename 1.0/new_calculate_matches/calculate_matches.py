#!/usr/bin/python

import MySQLdb

# Open database connection
db = MySQLdb.connect("localhost", "root", "AA3x8-fpe50-m8eeq-w4x7v-x6r8f", "snelkoppeling")

# prepare a cursor object using cursor() method
cursor = db.cursor()

# execute SQL query using execute() method.
cursor.execute("SELECT VERSION()")

# Fetch a single row using fetchone() method.
data = cursor.fetchone()

print "Database version : %s " % data

# disconnect from server
db.close()