<?php
include 'dbconnect.php';

// Fetch total number of each type of car
$query = "SELECT CarStatus, COUNT(*) as count FROM cars GROUP BY CarStatus";
$result = $conn->query($query);
$total_cars = [];
while ($row = $result->fetch_assoc()) {
    $total_cars[$row['CarStatus']] = $row['count'];
}

// Fetch recent updates
$activity_query = "SELECT CarName, last_updated FROM cars ORDER BY last_updated DESC LIMIT 5";
$activity_result = $conn->query($activity_query);
$activities = [];
while ($activity_row = $activity_result->fetch_assoc()) {
    $activities[] = "Updated " . $activity_row['CarName'] . " on " . date('Y-m-d H:i:s', strtotime($activity_row['last_updated']));
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Dealership Admin Portal</title>
    <link rel="icon" type="image/x-icon" href="imgs/fav.png">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex items-center justify-between">
            <div class="text-white text-lg">
                <a href="#" class="text-white no-underline hover:text-gray-200 hover:text-underline">Car Dealership Admin Portal</a>
            </div>
            <div>
                <a href="add_car.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add New Car</a>
                <a href="view_cars.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">View Inventory</a>
            </div>
        </div>
    </nav>

    <header class="bg-white shadow">
        <div class="container mx-auto p-6">
            <h1 class="text-gray-700 text-3xl font-bold">Dashboard</h1>
        </div>
    </header>

    <main class="container mx-auto p-6">
        <div class="flex flex-wrap -mx-3">
            <!-- Total Cars Widget -->
            <div class="w-full md:w-1/2 xl:w-1/3 p-3">
                <div class="bg-white border rounded shadow">
                    <div class="border-b p-3">
                        <h5 class="font-bold uppercase text-gray-600">Total Cars by Status</h5>
                    </div>
                    <div class="p-5">
                        <canvas id="chartCanvas1" width="400" height="200"></canvas>
                        <script>
                            var ctx = document.getElementById('chartCanvas1').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: Object.keys(<?php echo json_encode($total_cars); ?>),
                                    datasets: [{
                                        label: '# of Cars',
                                        data: Object.values(<?php echo json_encode($total_cars); ?>),
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activities -->
            <div class="w-full md:w-1/2 xl:w-2/3 p-3">
                <div class="bg-white border rounded shadow">
                    <div class="border-b p-3">
                        <h5 class="font-bold uppercase text-gray-600">Recent Activities</h5>
                    </div>
                    <div class="p-5">
                        <ul>
                            <?php foreach ($activities as $activity): ?>
                                <li><?php echo htmlspecialchars($activity); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
