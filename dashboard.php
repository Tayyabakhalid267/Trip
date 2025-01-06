<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION['user'];
require_once 'Database.php';
require_once 'Trip.php';

$db = (new Database())->connect();
$tripModel = new Trip($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_trip') {
    $name = $_POST['trip_name'];
    $location_id = $_POST['location_id'];
    $members = $_POST['members'];
    $trip_date = $_POST['trip_date'];
    $lunch = isset($_POST['lunch']) ? 1 : 0;
    $price = $_POST['price'];

    if ($tripModel->createTrip($user['id'], $name, $location_id, $members, $trip_date, $lunch, $price)) {
        echo "Trip created successfully!";
    } else {
        echo "Error creating trip.";
    }
}
$locations_query = "SELECT * FROM locations";
$locations_result = $db->query($locations_query);
$locations = $locations_result->fetchAll(PDO::FETCH_ASSOC);

$trips = $tripModel->getTrips($user['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Dashboard</title>
    <script>
        function updatePrice() {
            var lunchCheckbox = document.getElementById('lunch');
            var priceField = document.getElementById('price');
            var basePrice = 100; 

            if (lunchCheckbox.checked) {
                priceField.value = basePrice + 20; 
            } else {
                priceField.value = basePrice; 
            }
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <h2>Welcome, <?php echo $user['name']; ?></h2>
        <form action="logout.php" method="POST">
            <button type="submit" name="action" value="logout">Logout</button>
        </form>
    </div>

    <div class="container">
        <h1>Your Trips</h1>
        <table>
            <tr><th>Trip Name</th><th>Location</th><th>Date</th><th>Members</th><th>Price</th></tr>
            <?php foreach ($trips as $trip): ?>
                <tr>
                    <td><?php echo $trip['name']; ?></td>
                    <td><?php echo $trip['location_name']; ?></td>
                    <td><?php echo $trip['trip_date']; ?></td>
                    <td><?php echo $trip['members']; ?></td>
                    <td><?php echo $trip['price']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Create a New Trip</h2>
        <form action="dashboard.php" method="POST">
            <label for="trip_name">Trip Name</label>
            <input type="text" id="trip_name" name="trip_name" required>

            <label for="location_id">Location</label>
            <select name="location_id" id="location_id" required>
                <?php foreach ($locations as $location): ?>
                    <option value="<?php echo $location['id']; ?>"><?php echo $location['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="members">Members</label>
            <input type="number" id="members" name="members" min="1" required>

            <label for="trip_date">Trip Date</label>
            <input type="date" id="trip_date" name="trip_date" required>

            <label for="lunch">With Lunch (+$20)</label>
            <input type="checkbox" id="lunch" name="lunch" onclick="updatePrice()">

            <label for="price">Price</label>
            <input type="number" id="price" name="price" value="100" required readonly> 

            <button type="submit" name="action" value="create_trip">Create Trip</button>
        </form>
    </div>
</body>
</html>
