<?php
session_start();
require_once 'Database.php';
require_once 'Trip.php';
$db = new Database();
$trip = new Trip($db->connect());
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create_trip') {
    $name = $_POST['trip_name'];
    $location_id = $_POST['location_id'];
    $members = $_POST['members'];
    $trip_date = $_POST['trip_date'];
    $lunch = isset($_POST['lunch']) ? 1 : 0; 
    $price = $_POST['price'];
    $trip->createTrip($user_id, $name, $location_id, $members, $trip_date, $lunch, $price);
    header("Location: dashboard.php"); 
    exit;
}
$locations = $trip->getLocations(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Trip</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Create a New Trip</h1>

    <form action="create_trip.php" method="POST">
        <label for="trip_name">Trip Name:</label>
        <input type="text" id="trip_name" name="trip_name" required>

        <label for="location_id">Location:</label>
        <select name="location_id" id="location_id" required>
            <?php foreach ($locations as $location): ?>
                <option value="<?php echo $location['id']; ?>"><?php echo $location['name']; ?></option>
            <?php endforeach; ?>
        </select>

        <label for="members">Members:</label>
        <input type="number" id="members" name="members" min="1" required>

        <label for="trip_date">Trip Date:</label>
        <input type="date" id="trip_date" name="trip_date" required>

        <label for="lunch">With Lunch (+$20):</label>
        <input type="checkbox" id="lunch" name="lunch" onclick="updatePrice()">

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="100" readonly>

        <button type="submit" name="action" value="create_trip">Create Trip</button>
    </form>

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
</body>
</html>
