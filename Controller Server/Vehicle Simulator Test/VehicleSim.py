#!/usr/bin/env /home/gmorancr/virtualenv/python34/3.4/bin/python3

import urllib.request
import time
import sys


#   EXAMPLE USAGE:
#
#   *** Requires Python 3 and urllib.request ***
#
#   python3 VehicleSim.py vehicleID latitude longitude latitude longitude latitude longitude
#
#   i.e python3 VehicleSim.py 5 40.55553829 -97.38104739 40.55453829 -97.38153739 40.54353829 -97.38764739
#
#

def main():

    args = sys.argv
    del args[0] #remove *.py from args list

    vehicleID = args[0] #first argument is the vehicleID
    del args[0] # remove vehicleID from args

    argsLen = len(args) #number of args

    if (argsLen % 2 != 0) :
        print("Error! Invalid coordinate values")
        exit()
    else :

        setVehicleInUse(vehicleID, True)

        array = []
        count = 0

        for i in range(0, argsLen) :
            count += 1
            array.append(args[i])

            if count % 2 == 0 :
                print('Sending Vehicle Request')
                moveVehicle(vehicleID, array)
                array = []
                time.sleep(5)

        setVehicleInUse(vehicleID, False)

def setVehicleInUse(vehicleID, status) :

    if (status == True) :

        req = urllib.request.Request('https://meicher.create.stedwards.edu/WeGoVehicleDB/setVehicle.php?vehicleID=%s&inUse=1' % (vehicleID))

        with urllib.request.urlopen(req) as response:
            the_page = response.read()

        print(the_page)
    else :

        req = urllib.request.Request('https://meicher.create.stedwards.edu/WeGoVehicleDB/setVehicle.php?vehicleID=%s&inUse=0' % (vehicleID))

        with urllib.request.urlopen(req) as response:
            the_page = response.read()

        print(the_page)


def moveVehicle(vehicleID, coordinatesArray):

    latitude  = coordinatesArray[0]
    longitude = coordinatesArray[1]

    req = urllib.request.Request('https://meicher.create.stedwards.edu/WeGoVehicleDB/setVehicle.php?vehicleID=%s&inUse=1&currentLatitude=%s&currentLongitude=%s' % (vehicleID, latitude,longitude))

    with urllib.request.urlopen(req) as response:
        the_page = response.read()

    print(the_page)

    #time.sleep(10)



main()
