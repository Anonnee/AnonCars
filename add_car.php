<?php
include 'dbconnect.php';

// Define variables and initialize with empty values
$carName = $carDescription = $quantityAvailable = $price = $carStatus = $carTrim = "";
$carName_err = $carDescription_err = $quantityAvailable_err = $price_err = $carStatus_err = $carTrim_err = "";
$success_message = $error_message = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate car name
    if (empty(trim($_POST["carName"]))) {
        $carName_err = "Please enter the car name.";
    } else {
        $carName = trim($_POST["carName"]);
    }

    // Validate car description
    if (empty(trim($_POST["carDescription"]))) {
        $carDescription_err = "Please enter a description.";
    } else {
        $carDescription = trim($_POST["carDescription"]);
    }

    // Validate quantity available
    if (empty(trim($_POST["quantityAvailable"]))) {
        $quantityAvailable_err = "Please enter the quantity available.";
    } elseif (!is_numeric($_POST["quantityAvailable"])) {
        $quantityAvailable_err = "Please enter a valid number.";
    } else {
        $quantityAvailable = trim($_POST["quantityAvailable"]);
    }

    // Validate price 
    if (empty(trim($_POST["price"]))) {
        $price_err = "Please enter the price.";
    } elseif (!is_numeric($_POST["price"])) {
        $price_err = "Please enter a valid price.";
    } else {
        $price = trim($_POST["price"]);
    }

    // Validate car status
    if (empty(trim($_POST["carStatus"]))) {
        $carStatus_err = "Please select the car status.";
    } else {
        $carStatus = trim($_POST["carStatus"]);
    }

    // Validate car trim
    if (empty(trim($_POST["carTrim"]))) {
        $carTrim_err = "Please enter the car trim.";
    } else {
        $carTrim = trim($_POST["carTrim"]);
    }

    // Ensure the connection is open
    if ($conn->connect_error) {
        $error_message = "Connection failed: " . $conn->connect_error;
    }

    // Check input errors before inserting in the database
    if (empty($carName_err) && empty($carDescription_err) && empty($quantityAvailable_err) && empty($price_err) && empty($carStatus_err) && empty($carTrim_err)) {
        
        // Generate a unique CarID with a 3-digit format (ADS-XXX or TRD-XXX)
        $prefix = ($carStatus == 'New') ? 'ADS-' : 'TRD-';
        
        // Fetch the highest CarID with the same prefix and limit to 3-digit format
        $sql = "SELECT CarID FROM cars WHERE CarID LIKE '$prefix%' ORDER BY CarID DESC LIMIT 1";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Extract the numeric part of the CarID
            $last_id_number = intval(substr($row['CarID'], 4));
            $newCarID = $prefix . sprintf('%03d', $last_id_number + 1); // Increment by 1 and keep 3-digit format
        } else {
            $newCarID = $prefix . '001'; // Start from 001 if no IDs exist
        }

        // Prepare an insert statement
        $sql = "INSERT INTO cars (CarID, carName, carDescription, quantityAvailable, price, ProductAddedBy, carStatus, carTrim)
                VALUES (?, ?, ?, ?, ?, 'YourName', ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssidss", $newCarID, $param_carName, $param_carDescription, $param_quantityAvailable, $param_price, $param_carStatus, $param_carTrim);

            // Set parameters
            $param_carName = $carName;
            $param_carDescription = $carDescription;
            $param_quantityAvailable = $quantityAvailable;
            $param_price = $price;
            $param_carStatus = $carStatus;
            $param_carTrim = $carTrim;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                $success_message = "Car added successfully with ID $newCarID.";
            } else {
                $error_message = "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Car</title>
    <link rel="icon" type="image/x-icon" href="imgs/fav.png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
<nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex items-center justify-between">
            <div class="text-white text-lg">
                <a href="#" class="text-white no-underline hover:text-gray-200 hover:text-underline">Car Dealership Admin Portal</a>
            </div>
            <div>
                <a href="index.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back To Dashboard</a>
            </div>
        </div>
    </nav>
	<header class="bg-white shadow">
        <div class="container mx-auto p-6">
            <h1 class="text-gray-700 text-3xl font-bold">Add New Car</h1>
        </div>
    </header>
    <div class="container mx-auto mt-10 p-6 bg-white shadow-lg rounded">
 
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="mb-4">
                <label class="block text-gray-700">Car Name</label>
                <input type="text" name="carName" class="w-full p-2 border rounded" value="<?php echo $carName; ?>">
                <span class="text-red-600"><?php echo $carName_err; ?></span>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Car Description</label>
                <textarea name="carDescription" class="w-full p-2 border rounded"><?php echo $carDescription; ?></textarea>
                <span class="text-red-600"><?php echo $carDescription_err; ?></span>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">In Stock</label>
                <input type="number" name="quantityAvailable" class="w-full p-2 border rounded" value="<?php echo $quantityAvailable; ?>">
                <span class="text-red-600"><?php echo $quantityAvailable_err; ?></span>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Price</label>
                <input type="text" name="price" class="w-full p-2 border rounded" value="<?php echo $price; ?>">
                <span class="text-red-600"><?php echo $price_err; ?></span>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Car Status (New/Used)</label>
                <select name="carStatus" class="w-full p-2 border rounded">
                    <option value="New" <?php echo ($carStatus == 'New') ? 'selected' : ''; ?>>New</option>
                    <option value="Used" <?php echo ($carStatus == 'Used') ? 'selected' : ''; ?>>Used</option>
                </select>
                <span class="text-red-600"><?php echo $carStatus_err; ?></span>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Car Trim</label>
                <input type="text" name="carTrim" class="w-full p-2 border rounded" value="<?php echo $carTrim; ?>">
                <span class="text-red-600"><?php echo $carTrim_err; ?></span>
            </div>
            <div class="mb-4">
                <input type="submit" value="Submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
            </div>
        </form>
    </div>

    <!-- Toast Notifications -->
    <?php if (!empty($success_message)): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '<?php echo $success_message; ?>',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    <?php elseif (!empty($error_message)): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo $error_message; ?>',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    <?php endif; ?>
</body>
</html>