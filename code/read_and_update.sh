#!/bin/bash.
while[ 1 ]
do
	sleep 1000
	moisture = ser.readline()
	./update_db.java $moisture $i
	$i=$i+1
done