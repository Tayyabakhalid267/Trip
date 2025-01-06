<?php
require_once 'Database.php';

class Trip {
    private $conn;
    private $table = 'trips';

    public function __construct($db) {
        $this->conn = $db;
    }
    public function createTrip($user_id, $name, $location_id, $members, $trip_date, $lunch, $price) {
        
        if ($lunch) {
            $price += 20; 
        }
        $location_query = "SELECT name FROM locations WHERE id = ?";
        $location_stmt = $this->conn->prepare($location_query);
        $location_stmt->bindParam(1, $location_id);
        $location_stmt->execute();
        $location = $location_stmt->fetch(PDO::FETCH_ASSOC);
        $location_name = $location ? $location['name'] : 'Unknown Location';
        $query = "INSERT INTO " . $this->table . " (user_id, name, location_id, location_name, members, trip_date, lunch, price) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->bindParam(2, $name);
        $stmt->bindParam(3, $location_id);
        $stmt->bindParam(4, $location_name);  
        $stmt->bindParam(5, $members);
        $stmt->bindParam(6, $trip_date);
        $stmt->bindParam(7, $lunch);
        $stmt->bindParam(8, $price);

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Error inserting trip");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    public function getTrips($user_id) {
        $query = "SELECT t.*, l.name AS location_name 
                  FROM " . $this->table . " t
                  LEFT JOIN locations l ON t.location_id = l.id
                  WHERE t.user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
