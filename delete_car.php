<?php
include 'dbconnect.php';

// Process delete operation after confirmation
if(isset($_GET["CarID"]) && !empty($_GET["CarID"])){
    // Prepare a delete statement
    $sql = "DELETE FROM cars WHERE CarID = ?";
    
    if($stmt = $conn->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_carID);

        // Set parameters
        $param_carID = $_GET["CarID"];

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Records deleted successfully. Redirect to view_cars.php
            header("location: view_cars.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
        
        // Close statement
        $stmt->close();
    }
     
    // Close connection
    $conn->close();
} else{
    // Check existence of CarID parameter
    if(empty(trim($_GET["CarID"]))){
        // URL doesn't contain CarID parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>