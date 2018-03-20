# communicate between the pi and the arduino

from subprocess import call



import time
'''
import smbus

bus = smbus.SMBus(1)

# This is the address we setup in the Arduino Program
address = 0x04

def writeNumber(value):
    bus.write_byte(address, value)
    return -1

def readNumber():
    number = bus.read_byte(address)
    return number
'''
'''
while True:
    var = input("Enter 1 for temp(in celsius), 2 for humdity(0-100%), 3 for moisture(0-255) or 9 to toggle the motor: ")
    if not var:
        continue

    writeNumber(var)
    # sleep one second
    time.sleep(1)

    number = readNumber() # this is the value the arduino responds with
    print "Arduino: ", number
    print
'''

def readMoisture():
    '''
    # Test Get only moisture
    writeNumber(3)
    # sleep one second
    time.sleep(1)
    number = readNumber() # this is the value the arduino responds with
    '''
    number = 1
    return number

if __name__ == '__main__':
    interval = 1#10
    i=0
    while True:
        time.sleep(interval)
        
        # Get values from arduino
        moisture=readMoisture()

        # Update the database
        #call(["ls", "-l"])
        call(["java", "Update"])

        i=i+1


    





