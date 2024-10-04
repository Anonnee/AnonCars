<?php
include 'dbconnect.php';

// Fetch all cars from the database
$sql = "SELECT * FROM cars";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cars</title>
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
            <a href="add_car.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add New Car</a>
			<a href="index.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back To Dashboard</a>
        </div>
    </div>
</nav>

<header class="bg-white shadow">
    <div class="container mx-auto p-6">
        <h1 class="text-gray-700 text-3xl font-bold">Car Inventory</h1>
    </div>
</header>

<div class="container mx-auto mt-10 p-6 bg-white shadow-lg rounded">
    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Car ID</th>
                <th class="py-2 px-4 border-b">Car Name</th>
                <th class="py-2 px-4 border-b">Description</th>
                <th class="py-2 px-4 border-b">Quantity</th>
                <th class="py-2 px-4 border-b">Price</th>
                <th class="py-2 px-4 border-b">Status</th>
                <th class="py-2 px-4 border-b">Trim</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border-b"><?php echo $row["CarID"]; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $row["CarName"]; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $row["CarDescription"]; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $row["QuantityAvailable"]; ?></td>
                        <td class="py-2 px-4 border-b">$<?php echo number_format($row["Price"], 2); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $row["CarStatus"]; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $row["CarTrim"]; ?></td>
                        <td class="py-2 px-4 border-b">
                            <div class="flex space-x-2">
                                <a href="edit_car.php?CarID=<?php echo $row["CarID"]; ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</a>
                                <a href="delete_car.php?CarID=<?php echo $row["CarID"]; ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="return confirmDeletion('<?php echo $row["CarID"]; ?>')">Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="py-4 text-center">No cars found in the inventory</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
function confirmDeletion(carID) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'delete_car.php?CarID=' + carID;
        }
    });
    return false; // Prevent the default link behavior
}
</script>

</body>
</html>
<?php $conn->close(); ?>