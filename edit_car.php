<?php
include 'dbconnect.php';

// Define variables and initialize with empty values
$carID = $carName = $carDescription = $quantityAvailable = $price = $carStatus = $carTrim = "";
$carName_err = $carDescription_err = $quantityAvailable_err = $price_err = $carStatus_err = $carTrim_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate inputs
    $carID = trim($_POST["carID"]); // Hidden input containing the car ID
    $carName = trim($_POST["carName"]);
    $carDescription = trim($_POST["carDescription"]);
    $quantityAvailable = trim($_POST["quantityAvailable"]);
    $price = trim($_POST["price"]);
    $carStatus = trim($_POST["carStatus"]);
    $carTrim = trim($_POST["carTrim"]);

    // Prepare an update statement
    $sql = "UPDATE cars SET CarName=?, CarDescription=?, QuantityAvailable=?, Price=?, CarStatus=?, CarTrim=? WHERE CarID=?";

    if($stmt = $conn->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ssidsss", $param_carName, $param_carDescription, $param_quantityAvailable, $param_price, $param_carStatus, $param_carTrim, $param_carID);

        // Set parameters
        $param_carName = $carName;
        $param_carDescription = $carDescription;
        $param_quantityAvailable = $quantityAvailable;
        $param_price = $price;
        $param_carStatus = $carStatus;
        $param_carTrim = $carTrim;
        $param_carID = $carID;

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $success_message = "Car updated successfully.";
        } else{
            $error_message = "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }
}

// Check existence of id parameter before processing further
if(isset($_GET["CarID"]) && !empty(trim($_GET["CarID"]))){
    // Get URL parameter
    $carID =  trim($_GET["CarID"]);

    // Prepare a select statement
    $sql = "SELECT * FROM cars WHERE CarID = ?";
    if($stmt = $conn->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_carID);

        // Set parameters
        $param_carID = $carID;

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            $result = $stmt->get_result();

            if($result->num_rows == 1){
                $row = $result->fetch_assoc();

                // Retrieve individual field value
                $carName = $row["CarName"];
                $carDescription = $row["CarDescription"];
                $quantityAvailable = $row["QuantityAvailable"];
                $price = $row["Price"];
                $carStatus = $row["CarStatus"];
                $carTrim = $row["CarTrim"];
            } else{
                // URL doesn't contain valid id. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car</title>
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
           <a href="view_cars.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back To Inventory</a>
        </div>
    </div>
</nav>

<header class="bg-white shadow">
    <div class="container mx-auto p-6">
        <h1 class="text-gray-700 text-3xl font-bold">Edit Car</h1>
    </div>
</header>

<div class="container mx-auto mt-10 p-6 bg-white shadow-lg rounded">
    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" class="space-y-6">
        <div>
            <label class="block text-gray-700">Car Name</label>
            <input type="text" name="carName" class="w-full p-2 border rounded" value="<?php echo $carName; ?>">
        </div>
        <div>
            <label class="block text-gray-700">Car Description</label>
            <textarea name="carDescription" class="w-full p-2 border rounded"><?php echo $carDescription; ?></textarea>
        </div>
        <div>
            <label class="block text-gray-700">In Stock</label>
            <input type="number" name="quantityAvailable" class="w-full p-2 border rounded" value="<?php echo $quantityAvailable; ?>">
        </div>
        <div>
            <label class="block text-gray-700">Price</label>
            <input type="text" name="price" class="w-full p-2 border rounded" value="<?php echo $price; ?>">
        </div>
        <div>
            <label class="block text-gray-700">Car Status (New/Used)</label>
            <select name="carStatus" class="w-full p-2 border rounded">
                <option value="New" <?php echo ($carStatus == 'New') ? 'selected' : ''; ?>>New</option>
                <option value="Used" <?php echo ($carStatus == 'Used') ? 'selected' : ''; ?>>Used</option>
            </select>
        </div>
        <div>
            <label class="block text-gray-700">Car Trim</label>
            <input type="text" name="carTrim" class="w-full p-2 border rounded" value="<?php echo $carTrim; ?>">
        </div>
        <input type="hidden" name="carID" value="<?php echo $carID; ?>">
        <input type="submit" value="Submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
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