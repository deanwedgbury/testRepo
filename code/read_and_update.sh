#!/bin/sh




$cmd="i=0 ; while[ 1 ] ; do sleep 10; moisture=1000 ; java update_db $moisture $i ; i=$[$i+1] ; done"

eval "$cmd" &

#i=0
#while[ 1 ]
#do
#	sleep 10
	#moisture = ser.readline()
#	moisture=1000
#	./update_db.java $moisture $i
#	i=$[$i+1]
#done