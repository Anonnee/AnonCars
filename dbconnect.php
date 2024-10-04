<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "car_dealership";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    error_log("Database created successfully or already exists.\n");
} else {
    error_log("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($dbname);

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS cars (
    CarID varchar(10) PRIMARY KEY,
    CarName varchar(50) NOT NULL,
    CarDescription text NOT NULL,
    QuantityAvailable int NOT NULL,
    Price decimal(10,2) NOT NULL,
    ProductAddedBy varchar(50) NOT NULL DEFAULT 'Hrishikesh Kindre',
    CarStatus varchar(10) NOT NULL,
    CarTrim varchar(30) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    error_log("Table 'cars' checked/created successfully.\n");
    // Check if the table is empty
    $checkData = "SELECT CarID FROM cars";
    $result = $conn->query($checkData);
    if ($result->num_rows == 0) { // If the table is empty, insert data
        // Prepare your insert statements
        $insert_queries = [
			"INSERT INTO cars (CarID, CarName, CarDescription, QuantityAvailable, Price, ProductAddedBy, CarStatus, CarTrim)
				VALUES 	('ADS-101', 'Dodge Challenger', 'A powerful muscle car that offers great performance and classic styling.', 5, 28000.00, 'Hrikish Kindre', 'New', 'SXT'),
						('ADS-102', 'Dodge Challenger', 'A powerful muscle car that offers great performance and classic styling.', 3, 32000.00, 'Daulat Talpde', 'New', 'GT'),
						('ADS-103', 'Dodge Challenger', 'A powerful muscle car that offers great performance and classic styling.', 2, 36000.00, 'Johnny Lever', 'New', 'R/T'),
						('TRD-101', 'Dodge Challenger', 'A powerful muscle car that offers great performance and classic styling.', 1, 33000.00, 'Deepak Kalal', 'Used', 'SRT Hellcat'),
						('ADS-104', 'Ford Mustang', 'Iconic American muscle car known for its impressive performance and sleek design.', 4, 27000.00, 'Bablu Phatak', 'New', 'EcoBoost'),
						('ADS-105', 'Ford Mustang', 'Iconic American muscle car known for its impressive performance and sleek design.', 2, 35000.00, 'Hrikish Kindre', 'New', 'GT'),
						('TRD-102', 'Ford Mustang', 'Iconic American muscle car known for its impressive performance and sleek design.', 1, 30000.00, 'Daulat Talpde', 'Used', 'Mach 1'),
						('ADS-106', 'Chevy Camaro', 'A sporty car known for its athletic handling and powerful engine options.', 3, 25000.00, 'Johnny Lever', 'New', 'LS'),
						('ADS-107', 'Chevy Camaro', 'A sporty car known for its athletic handling and powerful engine options.', 2, 29000.00, 'Deepak Kalal', 'New', 'LT'),
						('ADS-108', 'Chevy Camaro', 'A sporty car known for its athletic handling and powerful engine options.', 1, 37000.00, 'Bablu Phatak', 'New', 'SS'),
						('TRD-103', 'Chevy Camaro', 'A sporty car known for its athletic handling and powerful engine options.', 1, 34000.00, 'Hrikish Kindre', 'Used', 'ZL1'),
						('ADS-109', 'Honda Civic', 'Reliable and efficient, the Civic is known for its longevity and compact design.', 4, 22000.00, 'Daulat Talpde', 'New', 'LX'),
						('ADS-110', 'Honda Accord', 'A staple in the midsize sedan market, offering comfort and innovative technology.', 3, 24000.00, 'Johnny Lever', 'New', 'Sport'),
						('TRD-104', 'Honda CR-V', 'Spacious and versatile, the CR-V is ideal for families seeking practicality and safety.', 2, 26000.00, 'Deepak Kalal', 'Used', 'EX-L'),
						('ADS-111', 'Kia Sorento', 'A family-friendly SUV offering ample space and modern tech features.', 4, 29000.00, 'Bablu Phatak', 'New', 'S'),
						('ADS-112', 'Kia Optima', 'Sleek design and comfortable interiors make the Optima a great choice for a midsize sedan.', 3, 23000.00, 'Hrikish Kindre', 'New', 'EX'),
						('TRD-105', 'Kia Forte', 'Compact yet stylish, the Forte offers excellent value and efficiency for urban drivers.', 2, 19000.00, 'Daulat Talpde', 'Used', 'GT-Line')",
];

        foreach ($insert_queries as $query) {
            if ($conn->query($query) === TRUE) {
                error_log("Record inserted successfully.\n");
            } else {
                error_log("Error inserting record: " . $conn->error . "\n");
            }
        }
    }
} else {
    error_log("Error checking/creating table: " . $conn->error);
}

// Close connection
?>