USE order;

CREATE TABLE orderdb(
    orderId INT AUTO_INCREMENT PRIMARY KEY,
    userId INT FOREIGN KEY,
    vehicleId INT FOREIGN KEY,
    orderDate TIMESTAMP NOT NULL,
    startLatitude FLOAT NOT NULL,
    startLongitude FLOAT NOT NULL,
    endLatitude FLOAT NOT NULL,
    endLongitude FLOAT NOT NULL,
    amount FLOAT  NOT NULL
)
