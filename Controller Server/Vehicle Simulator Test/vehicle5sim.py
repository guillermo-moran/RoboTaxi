import urllib.request
import time

def main():

    req = urllib.request.Request('http://meicher.create.stedwards.edu/WeGoVehicleDB/setVehicle.php?vehicleID=5&ownerID=1&capacity=4&inService=0&inUse=0&currentLatitude=30.228194&currentLongitude=-97.754351')
    with urllib.request.urlopen(req) as response:
        the_page = response.read()

    print(the_page)

    time.sleep(10)

    req = urllib.request.Request('http://meicher.create.stedwards.edu/WeGoVehicleDB/setVehicle.php?vehicleID=5&ownerID=1&capacity=4&inService=0&inUse=0&currentLatitude=30.228722&currentLongitude=-97.755607')
    with urllib.request.urlopen(req) as response:
        the_page = response.read()

    print(the_page)

    time.sleep(10)

    req = urllib.request.Request('http://meicher.create.stedwards.edu/WeGoVehicleDB/setVehicle.php?vehicleID=5&ownerID=1&capacity=4&inService=0&inUse=0&currentLatitude=30.228871&currentLongitude=-97.757254')
    with urllib.request.urlopen(req) as response:
        the_page = response.read()

    print(the_page)

    time.sleep(10)

    req = urllib.request.Request('http://meicher.create.stedwards.edu/WeGoVehicleDB/setVehicle.php?vehicleID=5&ownerID=1&capacity=4&inService=0&inUse=0&currentLatitude=30.228519&currentLongitude=-97.755044')
    with urllib.request.urlopen(req) as response:
        the_page = response.read()

    print(the_page)

    req = urllib.request.Request('http://meicher.create.stedwards.edu/WeGoVehicleDB/setVehicle.php?vehicleID=5&ownerID=1&capacity=4&inService=0&inUse=0&currentLatitude=30.227406&currentLongitude=-97.753789')
    with urllib.request.urlopen(req) as response:
        the_page = response.read()

    print(the_page)

    time.sleep(10)


while True:
    main()






