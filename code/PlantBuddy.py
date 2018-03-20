# communicate between the pi and the arduino

from subprocess import call

import time
import smbus

import requests
import json


bus = smbus.SMBus(1)
address = 0x04 # address of the arduino pin 

port = 10511
plantID = 1
interval = 1


def writeNumber(value):
    bus.write_byte(address, value)
    return -1

def readNumber():
    number = bus.read_byte(address)
    return number

# 1 is temp
# 2 is humidity
# 3 is moisture
def readData(type):
    writeNumber(type)
    # sleep one second
    time.sleep(1)
    response = readNumber() # this is the value the arduino responds with
    
    return response

if __name__ == '__main__':
    while True:
        
        # Get values from arduino
        temp = readData(1)
    	humidity = readData(2)
    	moisture = readData(3)


        
        #call(["ls", "-l"])
        #call(["java", "Update"])
        
        # Update the database
        #link = "http://cslinux.utm.utoronto.ca:" + port + "/api/updateHistory?id=" + plantID +"&temp=" + temp + "&humidity=" + humidity + "&moisture=" + moisture
		#send_data = urllib2.urlopen(link).read()
		link_for_push = "http://cslinux.utm.utoronto.ca:" + str(port) + "/api/updateHistory"
		push = requests.put(url=link_for_push, data={"id":plantID, "temp":temp, "humidity":humidity, "moisture":moisture})

		# Read from database and turn on the pump if watering is on
		#json_water = urllib2.urlopen("http://cslinux.utm.utoronto.ca:10511/api/getState?id=1").read()

		link_for_water = "http://cslinux.utm.utoronto.ca:" + str(port) + "/api/getState?id=" + str(plantID)
		json_water = requests.get(link_for_water)
		water = json.loads(json_water)['state'][0]		
		if (water):
			writeNumber(7)
		else:
			writeNumber(8)

		time.sleep(interval)

    





