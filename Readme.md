# Car Dealership Management System

This project is a simple web-based application designed to manage a car dealership's inventory. It allows the dealership staff to add, view, edit, and delete car records.

## Features

- **Add Car**: Add a new car to the inventory.
- **View Cars**: View the list of all available cars.
- **Edit Car**: Update details of an existing car.
- **Delete Car**: Remove a car from the inventory.
  
## Technologies Used

- **PHP**: For server-side scripting.
- **MySQL**: For the database (schema included in `cars.sql`).
- **HTML/CSS**: For the frontend design.

## Database Setup

1. Import the `cars.sql` file into your MySQL database.
2. Update the database connection settings in `dbconnect.php` to match your environment.

## How to Run

1. Clone the repository.
2. Set up the MySQL database using the provided `cars.sql` file.
3. Ensure that your web server is running PHP and can connect to MySQL.
4. Access `index.php` through your browser to start managing the car inventory.

## Future Improvements

- Add user authentication for admin users.
- Implement search functionality for filtering cars.